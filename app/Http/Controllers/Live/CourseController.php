<?php

namespace App\Http\Controllers\Live;

use App\Http\Controllers\Controller;
use App\Models\Live\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CourseController extends Controller
{
    public function createGet($id=null){
        if($id==null){
            return view("live.course_create");
        }
        else{
            $course = Course::find($id);
            $user = Auth::user();
            if($user->can('checkManager',$course)){ // live için check manager yaz.
                if($course==null){
                    return view("live.course_create");
                }
                else{
                    View::share('course',$course);
                    return view("live.course_create");
                }
            }
            else{
                return redirect()->route('instructor_courses');
            }
        }
    }
}
