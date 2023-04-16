<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderMaster extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    protected $table = 'order_master';


    public function order_product()
    {
        return $this->hasMany(OrderProducts::class, 'order_id', 'id');
    }

    public function order_payment()
    {
        return $this->hasMany(OrderPayments::class, 'order_id', 'id')->orderBy('id', 'desc');
    }
    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id')->withTrashed();;
    }

    // public function getFinalTotalAttribute($value)
    // {
    //     return number_format($value, 2);
    // }

    // public function getTotalAttribute($value)
    // {
    //     return number_format($value, 2);
    // }

    // public function getDiscountAttribute($value)
    // {
    //     return number_format($value, 2);
    // }

    // public function getDebitAmountAttribute($value)
    // {
    //     return number_format($value, 2);
    // }

    // public function getCreditAmountAttribute($value)
    // {
    //     return number_format($value, 2);
    // }
}
