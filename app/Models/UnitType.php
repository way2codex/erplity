<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitType extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    protected $table = 'unit_type';

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function getNameAttribute($value) {
        return ucfirst($value);
    }
}
