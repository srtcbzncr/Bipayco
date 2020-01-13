<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorController extends Controller
{
    public function courses(){
        return view('instructor.courses');
    }

    public function books(){
        return view('instructor.books');
    }

    public function exams(){
        return view('instructor.exams');
    }

    public function homeworks(){
        return view('instructor.homeworks');
    }

    public function performance(){
        return view('instructor.performance');
    }

    public function questions(){
        return view('instructor.questions');
    }
}
