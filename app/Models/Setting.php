<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'setting';

    public function getLogoAttribute($image)
    {
        if($image == null || $image == '') {
            return asset('public/assets/images/logo-icon.png');
        } else {
            return url('storage/app/setting/'.$image);
        }
    }
}
