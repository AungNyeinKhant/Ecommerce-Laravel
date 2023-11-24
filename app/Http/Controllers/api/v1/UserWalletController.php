<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\WalletTransaction;
use App\CPU\Helpers;
use Illuminate\Support\Facades\Validator;
use function App\CPU\translate;
use Carbon\Carbon;

class UserWalletController extends Controller
{
    public function list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'limit' => 'required',
            'offset' => 'required',
        ]);

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        $wallet_status = Helpers::get_business_settings('wallet_status')?? 0;

        if($wallet_status == 1)
        {
            $user = $request->user();
            $total_wallet_balance = $user->wallet_balance;
           // Calculate current and previous month's total debit 
           $current_month_start = Carbon::now()->startOfMonth();
           $current_month_end = Carbon::now()->endOfMonth();
           $previous_month_start = Carbon::now()->subMonth()->startOfMonth();
           $previous_month_end = Carbon::now()->subMonth()->endOfMonth();
            //  By ANK
                // Get current month total use
            $total_current_month_debit = WalletTransaction::where('user_id', $user->id)
                ->whereBetween('created_at', [$current_month_start, $current_month_end])
                ->sum('debit');
            $total_current_month_credit = WalletTransaction::where('user_id', $user->id)
                ->whereBetween('created_at', [$current_month_start, $current_month_end])
                ->where('transaction_type', 'order_refund')
                ->sum('credit');
            // Calculate the total current month use (debit - credit)
            $total_current_month_use = $total_current_month_debit - $total_current_month_credit;

            // Get previous month total use
            $total_previous_month_debit = WalletTransaction::where('user_id', $user->id)
                ->whereBetween('created_at', [$previous_month_start, $previous_month_end])
                ->sum('debit');
            $total_previous_month_credit = WalletTransaction::where('user_id', $user->id)
                ->whereBetween('created_at', [$previous_month_start, $previous_month_end])
                ->where('transaction_type', 'order_refund')
                ->sum('credit');
            $total_previous_month_use  = $total_previous_month_debit - $total_previous_month_credit;

            $total_wallet_balance = auth('customer')->user()->wallet_balance;
            $wallet_transactio_list = WalletTransaction::where('user_id', $user->id)
                ->latest()
                ->paginate($request['limit'], ['*'], 'page', $request['offset']);

                return response()->json([
                    'limit' => (integer)$request->limit,
                    'offset' => (integer)$request->offset,
                    'total_wallet_balance' => $total_wallet_balance,
                    'total_current_month_use' => $total_current_month_use,
                    'total_previous_month_use' => $total_previous_month_use,
                    'total_wallet_transactio' => $wallet_transactio_list->total(),
                    'wallet_transactio_list' => $wallet_transactio_list->items()
                 ],200);
            // End ANK
        
            /*
           $total_current_month_debit = WalletTransaction::where('user_id', $user->id)
               ->whereBetween('created_at', [$current_month_start, $current_month_end])
               ->sum('debit');

           $total_previous_month_debit = WalletTransaction::where('user_id', $user->id)
               ->whereBetween('created_at', [$previous_month_start, $previous_month_end])
               ->sum('debit');
           

           $wallet_transactio_list = WalletTransaction::where('user_id', $user->id)
               ->latest()
               ->paginate($request['limit'], ['*'], 'page', $request['offset']);

           return response()->json([
               'limit' => (integer)$request->limit,
               'offset' => (integer)$request->offset,
               'total_wallet_balance' => $total_wallet_balance,
               'total_current_month_debit' => $total_current_month_debit,
               'total_previous_month_debit' => $total_previous_month_debit,
               'total_wallet_transactio' => $wallet_transactio_list->total(),
               'wallet_transactio_list' => $wallet_transactio_list->items()
            ],200);
            */
        }else{
            
            return response()->json(['message' => translate('access_denied!')], 422);
        }
    }
}