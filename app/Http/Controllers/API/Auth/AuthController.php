<?php

namespace App\Http\Controllers\API\Auth;

use App\Events\Auth\InstructorCallEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\InstructorResource;
use App\Models\Auth\User;
use App\Models\UsersOperations\LastWatchedCourses;
use App\Repositories\Auth\InstructorRepository;
use App\Repositories\Auth\StudentRepository;
use App\Repositories\GeneralEducation\CourseRepository;
use App\Repositories\UserOperations\UserOperations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

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

    // explain: this method get last 6 watched courses.
    public function getLastWatchedCourses($student_id){
        // Initializing
        $repo = new UserOperations();

        // Operations
        $resp = $repo->getLastWatchedCourses($student_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Son izlenen kurslar getirilemedi'
            ]);
        }
    }

    public function getInstructorByMail(Request $request){
        // Initializations
        $instructorRepo = new InstructorRepository();

        // Operations
        $instructorResp = $instructorRepo->getByEmail($request->query('email'));

        // Response
        if($instructorResp->getResult() and $instructorResp->isDataNull() == false){

            $user = User::where('email',$request->query('email'))->first();
            $name = $user->first_name.' '.$user->last_name;
            $email = $request->query('email');
            $data = array();
            $data['name'] = $name;
            $data['email'] = $email;
            Event::fire(new InstructorCallEvent($data));

            return new InstructorResource($instructorResp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => 'Eğitmen bulunamadı.']);
        }
    }
}
