<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function registerGet(){
        return view('auth.register');
    }

    public function registerPost(Request $request){

    }

    public function loginGet(){
        return view('auth.login');
    }

    public function loginPost(Request $request){

    }
}
