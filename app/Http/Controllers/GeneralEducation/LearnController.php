<?php

namespace App\Http\Controllers\GeneralEducation;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\GeneralEducation\Course;
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
        if(!$user->can('entry',$course)){
            return redirect()->route('ge_course',$id);
        }

        // initialization
        $repo = new LearnRepository();
        $user_id = Auth::user()->id;
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
        if($this->entry($user,$course)){
            $resp = $repo->getLesson($course_id,$lesson_id);
            $data = $resp->getData();
            return view('general_education.watch')->with('course',$data);
        }
        else{
            return redirect()->route('ge_course',$course_id);
        }

      /*  if($resp->getResult()){
            $data = $resp->getData();
            return view('general_education.watch')->with('course',$data);
        }*/

    }

    private function entry($user,$course){
        $now = date('Y-m-d', time());
        $entry = Entry::where('student_id', $user->student->id)->where('course_type','App\Models\PrepareLessons\Course')->where('course_id', $course->id)->where('active', true)->first();
        if($entry != null and date('Y-m-d',strtotime($entry->access_start))<=$now and date('Y-m-d',strtotime($entry->access_finish))>=$now){
            return true;
        }
        else{
            return false;
        }
    }
}
