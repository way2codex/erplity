<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class Helper
{
    public static function message_popup($message, $type)
    {
        Session::flash('message', $message);
        Session::flash('type', $type);
    }

    public static function unlinkFile($file) {
        try {
            $file = array_reverse(explode('/',$file));
            $path = $file[1].'/'.$file[0];
            unlink('storage/app/'.$path);
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function setting() {
        return Setting::first();
    }
}
