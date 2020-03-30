<?php

namespace App\Http\Controllers\PrepareLesson;

use App\Http\Controllers\Controller;
use App\Models\Auth\Instructor;
use App\Models\PrepareLessons\Course;
use App\Repositories\PrepareLessons\CourseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class CourseController extends Controller
{
    public function show($id, Request $request){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->get($id);
        $completedLessonsResp = $repo->getCompletedLessons($id, Auth::id());
        $entriesResp = $repo->getStudents($id);
        $progress = $repo->calculateProgress($resp->getData()->id, Auth::id());
        //$similarCourses = $repo->getSimilarCourses($id);
        $data = [
            'course' => $resp->getData(),
            'entries' => $entriesResp->getData(),
            'student_count' => count($resp->getData()->entries),
            'progress' => $progress->getData(),
            'completed' => $completedLessonsResp->getData(),
           // 'similar_courses' => $similarCourses->getData(),
        ];

        // Response
        if($resp->getResult()){
            return view('prepare_for_lesson.course_detail', $data);
        }
        else{
            return redirect()->route('error');
        }
    }

    public function createGet($id = null){
        if($id==null){
            return view("prepare_for_lesson.course_create");
        }
        else{
            $course = Course::find($id);
            $user = Auth::user();
            $instructor = Instructor::where('user_id',$user->id)->first();
            if($instructor != null){
                $geCourseInstructor = DB::table("ge_courses_instructors")->where('course_id',$course->id)
                    ->where('instructor_id',$instructor->id)->where('course_type','App\Models\PrepareLessons\Course')->first();
                if($geCourseInstructor != null){
                    if($geCourseInstructor->is_manager == 1){
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
                else{
                    return redirect()->route('instructor_courses');
                }
            }
            else{
                return redirect()->route('instructor_courses');
            }
//            if($user->can('checkManager',$course)){
//                if($course==null){
//                    return view("prepare_for_lesson.course_create");
//                }
//                else{
//                    View::share('course',$course);
//                    return view("prepare_for_lesson.course_create");
//                }
//            }
//            else{
//                return redirect()->route('instructor_courses');
//            }
        }
    }
}
