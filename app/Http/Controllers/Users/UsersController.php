<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(){
        $lUsers = \DB::table('users')
                    ->where('is_active', 1)
                    ->where('is_deleted', 0)
                    ->get();

        return view('users.users');
    }

    public function create(){

    }

    public function update(){

    }

    public function delete(){

    }
}
