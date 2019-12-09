<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Auth\User;
use App\Repositories\Auth\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registerGet(){
        return view('auth.register');
    }

    public function registerPost(RegisterRequest $request){
        // Validation
        $validated = $request->validated();

        // Initializations
        $repo = new UserRepository;

        // Operations
        $resp = $repo->create($validated);
        if($resp->getResult()){
            return redirect('home', 200);
        }
        else{
            return redirect()->back()->withErrors('error_message', $resp->getError()->getMessage());
        }

    }

    public function loginGet(){
        return view('auth.login');
    }

    public function loginPost(LoginRequest $request){
        // Validation
        $validated = $request->validated();

        // Operations
        if(Auth::check()){
            return redirect('home', 200);
        }
        else{
            if(Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $validated['remember'])){
                return redirect('home', 200);
            }
            else{
                return redirect()->back()->withErrors('error_message', __('auth.login_failed'));
            }
        }
    }
}
