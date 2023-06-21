<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $lApps = \DB::table('adm_apps AS a')
                    ->leftJoin('adm_user_apps AS ua', 'ua.app_id', '=', 'a.id_app')
                    ->where('a.is_active', true);

        if (! \Auth::user()->isAdmin()) {
            $lApps = $lApps->where('ua.user_id', \Auth::user()->id);
        }

        $lApps = $lApps->get();

        return view('home')->with('lApps', $lApps);
    }
}
