<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierMaster extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    protected $table = 'supplier_master';

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function getPhotoAttribute($image)
    {
        if($image == null || $image == '') {
            return asset('public/assets/noimage/1.png');
        } else {
            return url('storage/app/supplier/'.$image);
        }
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y h:i A',strtotime($value));
    }

    public function getNameAttribute($value) {
        return ucfirst($value);
    }
}
