<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstructorResource;
use App\Models\Auth\User;
use App\Repositories\Auth\InstructorRepository;
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
                array_push($geCoursesResp, ['course' => $course, 'progress' => $geCourseRepo->calculateProgress($course->id, $user->student->id)->getData()]);
            }
            return response()->json(['error' => false, 'courses' => [
                'ge' => $geCoursesResp,
                'pl' => array(),
                'pe' => array(),
                'books' => array(),
                'exams' => array(),
                'homeworks' => array(),
            ]]);
        }
        else {
            return response()->json(['error' => true, 'message' => $courses->getError()]);
        }
    }

    public function getInstructorByMail(Request $request){
        // Initializations
        $instructorRepo = new InstructorRepository();

        // Operations
        $instructorResp = $instructorRepo->getByEmail($request->query('email'));

        // Response
        if($instructorResp->getResult() and $instructorResp->isDataNull() == false){
            return new InstructorResource($instructorResp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => 'Eğitmen bulunamadı.']);
        }
    }
}
