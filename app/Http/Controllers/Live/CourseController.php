<?php

namespace App\Http\Controllers\Live;

use App\Http\Controllers\Controller;
use App\Models\Live\Course;
use App\Repositories\Live\CourseRepository;
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
            if($user->can('checkManager',$course)){
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

    public function show($id){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->get($id);
        $entriesResp = $repo->getStudents($id);
        //$similarCourses = $repo->getSimilarCourses($id);
        $data = [
            'course' => $resp->getData(),
            'entries' => $entriesResp->getData(),
            'student_count' => count($entriesResp->getData()),
        ];


        dd($resp->getError());
        // Response
        if($resp->getResult() and $entriesResp->getResult()){
            return view('live.course_detail', $data);
        }
        else{
            return redirect()->route('error');
        }
    }
}
