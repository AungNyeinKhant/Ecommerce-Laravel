<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\WalletTransaction;
use App\CPU\Helpers;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;

class UserWalletController extends Controller
{
    public function index()
{  
    $wallet_status = Helpers::get_business_settings('wallet_status');

    if ($wallet_status == 1) {
        $current_month_start = Carbon::now()->startOfMonth();
        $current_month_end = Carbon::now()->endOfMonth();
        $previous_month_start = Carbon::now()->subMonth()->startOfMonth();
        $previous_month_end = Carbon::now()->subMonth()->endOfMonth();

        // Get current month total use
        $total_current_month_debit = WalletTransaction::where('user_id', auth('customer')->id())
            ->whereBetween('created_at', [$current_month_start, $current_month_end])
            ->sum('debit');
        $total_current_month_credit = WalletTransaction::where('user_id', auth('customer')->id())
            ->whereBetween('created_at', [$current_month_start, $current_month_end])
            ->where('transaction_type', 'order_refund')
            ->sum('credit');
        // Calculate the total current month use (debit - credit)
        $total_current_month_use = $total_current_month_debit - $total_current_month_credit;

        // Get previous month total use
        $total_previous_month_debit = WalletTransaction::where('user_id', auth('customer')->id())
            ->whereBetween('created_at', [$previous_month_start, $previous_month_end])
            ->sum('debit');
        $total_previous_month_credit = WalletTransaction::where('user_id', auth('customer')->id())
            ->whereBetween('created_at', [$previous_month_start, $previous_month_end])
            ->where('transaction_type', 'order_refund')
            ->sum('credit');
        $total_previous_month_use  = $total_previous_month_debit - $total_previous_month_credit;
           

        $total_wallet_balance = auth('customer')->user()->wallet_balance;
        $wallet_transaction_list = WalletTransaction::where('user_id', auth('customer')->id())
            ->latest()
            ->paginate(15);
            $wallet_transaction_list = WalletTransaction::where('user_id',auth('customer')->id())
                                                    ->latest()
                                                    ->paginate(15);
        return view('web-views.users-profile.user-wallet', compact('total_wallet_balance', 'wallet_transaction_list', 'total_current_month_use', 'total_previous_month_use'));
    } else {
        Toastr::warning(\App\CPU\translate('access_denied!'));
        return back();
    }
}

}
