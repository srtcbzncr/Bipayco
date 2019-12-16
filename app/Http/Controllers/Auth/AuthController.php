<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Auth\User;
use App\Repositories\Auth\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function registerGet(){
        return view('auth.register');
    }

    public function registerPost(RegisterRequest $request)
    {
        // Validation
        $validatedData = $request->validated();

        // Initializations
        $repo = new UserRepository;

        // Operations
        $resp = $repo->create($validatedData);
        if($resp->getResult()){
            return redirect()->route('home');
        }
        else {
            return redirect()->back()->with('error', __('auth.register_failed'));
        }
    }

    public function loginGet(){
        if(Auth::check()){
            return redirect()->route('home');
        }
        else{
            return view('auth.login');
        }
    }

    public function loginPost(LoginRequest $request){
        // Validation
        $validatedData = $request->validated();

        $remember = false;
        if(in_array('remember', $validatedData)){
            if($validatedData['remember'] == 'on'){
                $remember = true;
            }
        }

        // Operations
        if(Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']], $remember)){
            return redirect()->route('home');
        }
        else{
            return redirect()->back()->with('error', __('auth.login_failed'));
        }
    }

    public function settings(){
        return view('auth.settings');
    }
}
