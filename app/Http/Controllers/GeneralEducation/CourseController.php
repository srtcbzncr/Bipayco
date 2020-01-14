<?php

namespace App\Http\Controllers\GeneralEducation;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\GeneralEducation\Course;
use App\Repositories\GeneralEducation\CategoryRepository;
use App\Repositories\GeneralEducation\CourseRepository;
use App\Repositories\GeneralEducation\SubCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Mail\Transport\ArrayTransport;
use Illuminate\Support\Facades\Auth;
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

    public function createGet($id = null){
        if($id==null){
            return view("general_education.course_create");
        }
        else{
            $course = Course::find($id);
            if($course==null){
                return view("general_education.course_create");
            }
            else{
                View::share('course',$course);
                return view("general_education.course_create");
            }
        }
    }
    public function createPost(CourseRequest $request){
        // Validation
        $validateData = $request->validated();

        // Initializations
        $repoCourse = new CourseRepository();

        // Operations
        $respCourse = $repoCourse->create($validateData);

        if($respCourse->getResult()){
            return redirect()->route('ge_course_create_get');
        }
        else{
            return redirect()->back()->with('error', $respCourse->getError()->getMessage());
        }
    }
}
