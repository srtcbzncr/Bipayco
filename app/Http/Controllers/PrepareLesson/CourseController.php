<?php

namespace App\Http\Controllers\PrepareLesson;

use App\Http\Controllers\Controller;
use App\Models\PrepareLessons\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CourseController extends Controller
{
    public function createGet($id = null){
        if($id==null){
            return view("prepare_for_lesson.course_create");
        }
        else{
            $course = Course::find($id);
            $user = Auth::user();
            if($user->can('checkManager',$course)){
                if($course==null){
                    return view("prepare_for_lesson.course_create");
                }
                else{
                    View::share('course',$course);
                    return view("prepare_for_lesson.course_create");
                }
            }
            else{
                return redirect()->route('instructor_courses');
            }
        }
    }
}
