<?php

namespace App\Http\Controllers\GeneralEducation;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Entry;
use App\Repositories\Learn\GeneralEducation\LearnRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class LearnController extends Controller
{
    // Sections Lesson ve source verileri al.
    public function getCourse($id){
        // course entry control
        $user = Auth::user();
        $course = Course::find($id);
        if($user->can('entry',$course) == false){
            return redirect()->route('ge_course',$id);
        }

        // initialization
        $repo = new LearnRepository();
        $user_id = Auth::id();
        // Operations
        $resp = $repo->getCourse($id,$user_id);
        $data = $resp->getData();
        return view('general_education.watch')->with('course',$data);
    }
    // Video veya pdf verisini al.
    public function getLesson($course_id,$lesson_id){
        // initialization
        $repo = new LearnRepository();

        // Operations
        $user = Auth::user();
        $course = Course::find($course_id);
        if($user->can('entry',$course)){
            $resp = $repo->getLesson($course_id,$lesson_id);
            $data = $resp->getData();
            return view('general_education.watch')->with('course',$data);
        }
        else{
            return redirect()->route('ge_course',$course_id);
        }


    }
}
