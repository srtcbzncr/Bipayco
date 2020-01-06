<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Repositories\Auth\StudentRepository;
use App\Repositories\GeneralEducation\CourseRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function courses($id){
        // Initializations
        $user = User::find($id);
        $studentRepo = new StudentRepository;
        $geCourseRepo = new CourseRepository;

        // Operations
        $courses = $studentRepo->courses($user->student->id);
        if ($courses->getResult()){
            $geCourses = $courses->getData()['ge'];
            $geCoursesResp = array();
            foreach($geCourses as $course){
                array_push($geCoursesResp, ['course' => $course, 'progress' => $geCourseRepo->calculateProgress($course->id, $user->student->id)]);
            }
            return response()->json(['error' => false, 'courses' => $geCoursesResp]);
        }
        else {
            return response()->json(['error' => true, 'message' => $courses->getError()]);
        }
    }
}
