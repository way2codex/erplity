<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrderPayments extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    protected $table = 'purchase_order_payments';


    public function order()
    {
        return $this->hasOne(PurchaseOrder::class, 'id', 'order_id')->with('supplier');
    }
}
