<?php

namespace App\Http\Controllers\Config;

use Illuminate\Http\Request;

class AppsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userapps()
    {
        $lApps = \DB::table('adm_apps AS a')
                    ->where('a.is_active', true)
                    ->get();

        $lUsers = \DB::table('users AS u')
                    ->where('u.is_active', true)
                    ->where('u.is_deleted', false)
                    ->get();

        foreach ($lUsers as $oUser) {
            foreach ($lApps as $oApp) {
                $oUser->$oApp->id_app = \DB::table('adm_user_apps')->where('app_id', $oApp->id_app)
                                                                    ->where('user_id', $oUser->id)
                                                                    ->exists();
            }
        }

        return view('home')->with('lUsers', $lUsers)
                            ->with('lApps', $lApps);
    }
}
