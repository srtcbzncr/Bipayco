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

    public function settings()
    {
        $user = Auth::user();
        $student = false;
        $instructor = false;
        $guardian = false;
        $manager = false;
        $admin = false;
        if($user->student != null){
            $student = true;
        }
        if($user->instructor != null){
            $instructor = true;
        }
        if($user->guardian != null){
            $guardian = true;
        }
        if($user->manager != null){
            $manager = true;
        }
        if($user->admin != null){
            $admin = true;
        }
        $data = [
            'user' => $user,
            'has_student_profile' => $student,
            'student_profile' => $user->student,
            'has_instructor_profile' => $instructor,
            'instructor_profile' => $user->instructor,
            'has_guardian_profile' => $guardian,
            'guardian_profile' => $user->guardian,
            'has_manager_profile' => $manager,
            'manager_profile' => $user->manager,
            'has_admin_profile' => $admin,
            'admin_profile' => $user->admin,
        ];
        return view('auth.settings', $data);
    }

    public function updatePersonalData(UpdatePersonalDataRequest $request, $id)
    {
        // Validation
        $validatedData = $request->validated();

        // Initializations
        $repo = new UserRepository;

        // Operations
        $resp = $repo->update($validatedData);
        if($resp->getResult()){
            return redirect()->back()->with(['error' => false, 'message' => __('auth.update_successfull')]);
        }
        else{
            return redirect()->back()->with(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function updateAvatar(UpdateAvatarRequest $request, $id)
    {
        // Validation
        $validatedData = $request->validated();

        // Initializations
        $repo = new UserRepository;

        // Operations
        $resp = $repo->updateAvatar($validatedData);
        if($resp->getResult()){
            return redirect()->back()->with(['error' => false, 'message' => __('auth.update_successfull')]);
        }
        else{
            return redirect()->back()->with(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function updatePassword(UpdatePasswordRequest $request, $id)
    {
        // Validation
        $validatedData = $request->validated();

        // Initializations
        $repo = new UserRepository;

        // Operations
        $resp = $repo->updatePassword($validatedData);
        if($resp->getResult()){
            return redirect()->back()->with(['error' => false, 'message' => __('auth.update_successfull')]);
        }
        else{
            return redirect()->back()->with(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

}
