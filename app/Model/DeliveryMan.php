<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DeliveryMan extends Model
{
    protected $hidden = ['password','auth_token'];

    protected $casts = [
        'is_active'=>'integer'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class,'delivery_man_id');
    }
}
