<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\UserApp;
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

        return view('configurations.userapps')->with('lUsers', $lUsers)
                            ->with('lApps', $lApps);
    }

    function updateAccess(Request $request) {
        $oUserApp = UserApp::where('user_id', $request->user_id)
                ->where('app_id', $request->app_id)
                ->first();

        if (is_null($oUserApp)) {
            $oUserApp = new UserApp();
            $oUserApp->user_id = $request->user_id;
            $oUserApp->app_id = $request->app_id;
            $oUserApp->save();
        }
        else {
            $oUserApp->delete();
        }

        return json_encode("OK");
    }
}
