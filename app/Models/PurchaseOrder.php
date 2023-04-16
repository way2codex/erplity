<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    protected $table = 'purchase_order';


    public function purchase_order_product()
    {
        return $this->hasMany(PurchaseOrderProduct::class, 'order_id', 'id');
    }
    public function order_payment()
    {
        return $this->hasMany(PurchaseOrderPayments::class, 'order_id', 'id')->orderBy('id', 'desc');
    }
    public function supplier()
    {
        return $this->hasOne(SupplierMaster::class, 'id', 'supplier_id')->withTrashed();
    }

    public function getFinalTotalAttribute($value)
    {
        return number_format($value, 2);
    }

    public function getTotalAttribute($value)
    {
        return number_format($value, 2);
    }

    public function getDiscountAttribute($value)
    {
        return number_format($value, 2);
    }
}
