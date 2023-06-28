<?php namespace App\Utils;

use App\Models\Apps;

class AppsUtils {
    public static function getApps(){
        $lApps = Apps::where('is_active', 1)->get();

        return $lApps;
    }
}