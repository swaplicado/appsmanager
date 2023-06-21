<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    function userapps () {
        $lApps = \DB::table('adm_apps AS a')
                    ->where('a.is_active', true)
                    ->get();

        $lUsers = \DB::table('users AS u')
                    ->where('u.is_active', true)
                    ->where('u.is_deleted', false)
                    ->get();

        foreach ($lUsers as $oUser) {
            foreach ($lApps as $oApp) {
                $oUser->{$oApp->id_app} = \DB::table('adm_user_apps')->where('app_id', $oApp->id_app)
                                                                    ->where('user_id', $oUser->id)
                                                                    ->exists();
            }
        }

        // dd($lUsers);

        return view('configurations.userapps')->with('lUsers', $lUsers)
                            ->with('lApps', $lApps);
    }
}
