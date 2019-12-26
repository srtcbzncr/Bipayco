<?php

namespace App\Http\Controllers\GeneralEducation;

use App\Http\Controllers\Controller;
use App\Repositories\GeneralEducation\CourseRepository;
use Illuminate\Http\Request;
use Illuminate\Mail\Transport\ArrayTransport;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function show($id){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->get($id);
        $completedLessonsResp = $repo->getCompletedLessons($id, Auth::id());
        $studentsResp = $repo->getStudents($id);
        $progress = $repo->calculateProgress($resp->getData()->id, Auth::id());
        $data = [
            'course' => $resp->getData(),
            'students' => $studentsResp->getData(),
            'student_count' => count($resp->getData()->entries),
            'progress' => $progress,
            'completed' => $completedLessonsResp->getData(),
        ];

        // Response
        if($resp->getResult()){
            return view('general_education.course_detail', $resp->getData());
        }
        else{
            return redirect()->route('error');
        }
    }
}
