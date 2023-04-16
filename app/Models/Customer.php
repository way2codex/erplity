<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'customer';
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function getPhotoAttribute($image)
    {
        if ($image == null || $image == '') {
            return asset('public/assets/noimage/1.png');
        } else {
            return url('storage/app/customer/' . $image);
        }
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y h:i A', strtotime($value));
    }

    public function getNameAttribute($value) {
        return ucfirst($value);
    }

    public function orders()
    {
        return $this->hasMany(OrderMaster::class, 'customer_id', 'id');
    }
}
