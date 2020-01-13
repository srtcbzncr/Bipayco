<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\InstructorRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Requests\UpdateInstructorRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdatePersonalDataRequest;
use App\Models\Auth\User;
use App\Repositories\Auth\InstructorRepository;
use App\Repositories\Auth\StudentRepository;
use App\Repositories\Auth\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function registerGet(){
        if(Auth::check()){
            return redirect()->route('home');
        }
        else {
            return view('auth.register');
        }
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
            if(Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']], false)){
                return redirect()->route('home');
            }
            return redirect()->route('loginGet');
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

    public function settings(Request $request)
    {
        $student = false;
        $instructor = false;
        $guardian = false;
        $manager = false;
        $admin = false;
        if(Auth::user()->student != null){
            $student = true;
        }
        if(Auth::user()->instructor != null){
            $instructor = true;
        }
        if(Auth::user()->guardian != null){
            $guardian = true;
        }
        if(Auth::user()->manager != null){
            $manager = true;
        }
        if(Auth::user()->admin != null){
            $admin = true;
        }
        $data = [
            'user' => Auth::user(),
            'has_student_profile' => $student,
            'student_profile' => Auth::user()->student,
            'has_instructor_profile' => $instructor,
            'instructor_profile' => Auth::user()->instructor,
            'has_guardian_profile' => $guardian,
            'guardian_profile' => Auth::user()->guardian,
            'has_manager_profile' => $manager,
            'manager_profile' => Auth::user()->manager,
            'has_admin_profile' => $admin,
            'admin_profile' => Auth::user()->admin
        ];

        if(!$request->session()->has('photo') and !$request->session()->has('security')){
            $request->session()->flash('personal_data', 'uk-active');
            $request->session()->flash('photo', null);
            $request->session()->flash('security', null);
        }
        return view('auth.settings', $data);
    }

    public function updatePersonalData(UpdatePersonalDataRequest $request)
    {
        // Validation
        $validatedData = $request->validated();

        // Initializations
        $repo = new UserRepository;

        // Operations
        $resp = $repo->update(Auth::id(), $validatedData);
        // Response
        if($resp->getResult()){
            return redirect()->back()->with(['result_message' => true, 'error' => false, 'message' => __('auth.update_successfull'), 'personal_data' => 'uk-active', 'security' => null, 'photo' => null]);
        }
        else{
            return redirect()->back()->with(['result_message' => true, 'error' => true, 'message' => __('auth.update_unsuccessfull'), 'personal_data' => 'uk-active', 'security' => null, 'photo' => null]);
        }
    }

    public function updateAvatar(UpdateAvatarRequest $request)
    {
        if($request->hasFile('avatar')){
            // Validation
            $validatedData = $request->validated();

            // Initialization
            $repo = new UserRepository;

            // Operations
            $resp = $repo->updateAvatar(Auth::id(), $request->toArray());

            // Response
            if($resp->getResult()){
                return redirect()->back()->with(['result_message' => true, 'error' => false, 'message' => __('auth.avatar_update_successfull'), 'personal_data' => null, 'security' => null, 'photo' => 'uk-active']);
            }
            else{
                return redirect()->back()->with(['result_message' => true, 'error' => true, 'message' => __('auth.avatar_update_unsuccessfull'), 'personal_data' => null, 'security' => null, 'photo' => 'uk-active']);
            }
        }
        else{
            return redirect()->back()->with(['result_message' => true, 'error' => true, 'message' => __('auth.avatar_update_unsuccessfull'), 'personal_data' => null, 'security' => null, 'photo' => 'uk-active']);
        }
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        // Validation
        $validatedData = $request->validated();

        if(Hash::check($validatedData['old_password'], Auth::user()->password)){
            if($validatedData['old_password'] == $validatedData['new_password']){
                return redirect()->back()->with(['result_message' => true, 'error' => true, 'message' => __('auth.same_password'), 'personal_data' => null, 'security' => 'uk-active', 'photo' => null]);
            }
            else{
                // Initializations
                $repo = new UserRepository;

                // Operations
                $resp = $repo->updatePassword(Auth::id(), $validatedData);
                if($resp->getResult()){
                    return redirect()->back()->with(['result_message' => true, 'error' => false, 'message' => __('auth.update_successfull'), 'personal_data' => null, 'security' => 'uk-active', 'photo' => null]);
                }
                else{
                    return redirect()->back()->with(['result_message' => true, 'error' => true, 'message' => __('auth.update_unsuccessfull'), 'personal_data' => null, 'security' => 'uk-active', 'photo' => null]);
                }
            }
        }
        else{
            return redirect()->back()->with(['result_message' => true, 'error' => true, 'message' => __('auth.password_not_correct'), 'personal_data' => null, 'security' => 'uk-active', 'photo' => null]);
        }
    }

    public function logout(){
        if(Auth::check()){
            Auth::logout();
            return redirect()->route('home');
        }
        else{
            return redirect()->route('home');
        }
    }

    public function updateInstructorData(UpdateInstructorRequest $request){
        // Validation
        $validatedData = $request->validated();

        // Initializations
        $repo = new InstructorRepository;
        // Operations
        $resp = $repo->update(Auth::user()->instructor->id, $request->toArray());

        // Response
        if($resp->getResult()){
            return redirect()->back()->with(['result_message' => true, 'error' => false, 'message' => __('auth.update_successfull')]);
        }
        else{
            return redirect()->back()->with(['result_message' => true, 'error' => true, 'message' => __('auth_update_unsuccessfull')]);
        }
    }

    public function studentProfile($id){
        // Initializations
        $repo = new StudentRepository;

        // Operations
        $resp = $repo->get($id);

        // Response
        if($resp->getResult()){
            return view('auth.student_profile', ['student' => $resp->getData()]);
        }
        else{
            return redirect()->route('error');
        }
    }

    public function instructorProfile($id){
        // Initializations
        $repo = new InstructorRepository;

        // Operations
        $resp = $repo->get($id);

        // Response
        if($resp->getResult()){
            return view('auth.instructor_profile', ['instructor' => $resp->getData()]);
        }
        else{
            return redirect()->route('error');
        }
    }

    public function createInstructorGet(){
        if(Auth::check()){
            return view('auth.instructor_register');
        }
        else {
            return view('auth.register');
        }
    }
    public function createInstructorPost(InstructorRequest $request){
        // Validation
        $validatedData = $request->validated();
        $validatedData['user_id']=Auth::id();


        // Initializations
        $repo = new InstructorRepository();

        // Operations
        $resp = $repo->create($validatedData);
        if($resp->getResult()){
            return redirect()->route('instructor_courses');
        }
        else {
            return redirect()->back()->with('error', $resp->getError()->getMessage());
        }
    }
}
