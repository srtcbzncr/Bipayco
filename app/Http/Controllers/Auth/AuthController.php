<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Auth\User;
use App\Repositories\Auth\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function registerGet(){
        return view('auth.register');
    }

    public function registerPost(RegisterRequest $request){
        // Validation
        $validatedData = $request->validated();

        // Initializations
        $repo = new UserRepository;

        // Operations
        $resp = $repo->create($validatedData);
        dd($resp);
        if($resp->getResult()){
            return redirect('home', 200);
        }
        else{
            error_log($resp->getError()->getMessage());
            return redirect()->back()->withErrors('error_message', $resp->getError()->getMessage());
        }

    }

    public function loginGet(){
        return view('auth.login');
    }

    public function loginPost(LoginRequest $request){
        // Validation
        $validatedData = $request->validated();

        // Operations
        if(Auth::check()){
            return redirect('home', 200);
        }
        else{
            if(Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']], $validatedData['remember'])){
                return redirect('home', 200);
            }
            else{
                return redirect()->back()->withErrors('error_message', __('auth.login_failed'));
            }
        }
    }
}
