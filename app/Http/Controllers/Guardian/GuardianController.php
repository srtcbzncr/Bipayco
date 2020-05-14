<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuardianController extends Controller
{
    public function students(){
        return view('guardian.students');
    }

    public function studentProfile(){
        return view('guardian.student_profile');
    }

    public function studentCourseDetail($guardianUserId,$studentUserId,$courseId){
        return view('guardian.student_course_detail')->with('guardianUserId',$guardianUserId)
            ->with('studentUserId',$studentUserId)->with('courseId',$courseId);
    }
}
