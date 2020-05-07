<?php

namespace App\Http\Controllers\PrepareExams;

use App\Http\Controllers\Controller;
use App\Models\Auth\Instructor;
use App\Models\PrepareExams\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class CourseController extends Controller
{
    public function createGet($id = null){
        if($id==null){
            return view("prepare_for_exams.course_create");
        }
        else{
            $course = Course::find($id);
            $user = Auth::user();
            $instructor = Instructor::where('user_id',$user->id)->first();
            if($instructor != null){
                $geCourseInstructor = DB::table("ge_courses_instructors")->where('course_id',$course->id)
                    ->where('instructor_id',$instructor->id)->where('course_type','App\Models\PrepareExams\Course')->first();
                if($geCourseInstructor != null){
                    if($geCourseInstructor->is_manager == 1){
                        if($course==null){
                            return view("prepare_for_exams.course_create");
                        }
                        else{
                            View::share('course',$course);
                            return view("prepare_for_exams.course_create");
                        }
                    }
                    else{
                        return redirect()->route('instructor_courses');
                    }
                }
                else{
                    return redirect()->route('instructor_courses');
                }
            }
            else{
                return redirect()->route('instructor_courses');
            }
        }
    }
}
