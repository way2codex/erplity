<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'product_category';
    protected $guarded = [];
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function getNameAttribute($value) {
        return ucfirst($value);
    }

    public function getImageAttribute($image)
    {
        if($image == null || $image == '') {
            return asset('public/assets/noimage/1.png');
        } else {
            return url('storage/app/product_category/'.$image);
        }
    }
}
