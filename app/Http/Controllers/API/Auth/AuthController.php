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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function courses($id){
        // Initializations
        $user = User::find($id);
        $studentRepo = new StudentRepository;
        $geCourseRepo = new CourseRepository;
        $plCourseRepo = new \App\Repositories\PrepareLessons\CourseRepository();
        $peCourseRepo = new \App\Repositories\PrepareExams\CourseRepository();

        // Operations
        $courses = $studentRepo->courses($user->student->id);
        if ($courses->getResult()){
            $geCourses = $courses->getData()['ge'];
            $plCourses = $courses->getData()['pl'];
            $peCourses = $courses->getData()['pe'];
            $geCoursesResp = array();
            $plCoursesResp = array();
            $peCoursesResp = array();
            foreach($geCourses as $course){
                array_push($geCoursesResp, ['course' => $course, 'progress' => $geCourseRepo->calculateProgress($course->id, $user->id)->getData()]);
            }
            foreach($plCourses as $course){
                array_push($plCoursesResp, ['course' => $course, 'progress' => $plCourseRepo->calculateProgress($course->id, $user->id)->getData()]);
            }
            foreach($peCourses as $course){
                array_push($peCoursesResp, ['course' => $course, 'progress' => $peCourseRepo->calculateProgress($course->id, $user->id)->getData()]);
            }
            return response()->json(['error' => false, 'courses' => [
                'ge' => $geCoursesResp,
                'pl' => $plCoursesResp,
                'pe' => $peCoursesResp,
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
            //Event::fire(new InstructorCallEvent($data));

            return new InstructorResource($instructorResp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => 'Eğitmen bulunamadı.']);
        }
    }

    public function resetPasswordTokenControl(Request $request){
        $data = $request->toArray();
        $email = $data['email'];
        $token = $data['token'];

        $flag = false;
        $now = date('Y-m-d H:i:s', time());
        $results=DB::table('password_resets')->where('email',$email)->where('token',$token)->get();
        foreach ($results as $result){
            if(date('Y-m-d H:i:s',strtotime('+ '.'1'.' hour', strtotime($result->access_start)))>$now){
                $flag = true;
                break;
            }
        }

        if($flag){
            return response()->json([
               'error' => false,
               'data' =>  $email
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Token bulunamadı.'
        ],400);
    }

    private function instructorProfile($instructorId,$userId = null){
        // Initializations
        $repo = new InstructorRepository;

        // Operations
        $resp = $repo->getInstructor($instructorId,$userId);

        // Response
        if($resp->getResult()){
            return view('auth.instructor_profile', ['instructor' => $resp->getData()]);
        }
        else{
            return redirect()->route('error');
        }
    }
}
