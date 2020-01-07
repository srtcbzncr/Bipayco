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
        $entriesResp = $repo->getStudents($id);
        $progress = $repo->calculateProgress($resp->getData()->id, Auth::id());
        $similarCourses = $repo->getSimilarCourses($id);
        $data = [
            'course' => $resp->getData(),
            'entries' => $entriesResp->getData(),
            'student_count' => count($resp->getData()->entries),
            'progress' => $progress->getData(),
            'completed' => $completedLessonsResp->getData(),
            'similar_courses' => $similarCourses->getData(),
        ];

        // Response
        if($resp->getResult()){
            return view('general_education.course_detail', $data);
        }
        else{
            return redirect()->route('error');
        }
    }
}
