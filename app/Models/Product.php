<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    protected $table = 'product_master';

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function getRateAttribute($value)
    {
        return number_format($value, 2);
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }


    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id')->withDefault(['name' => '-']);
    }
    public function product_images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
}
