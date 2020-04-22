<?php

namespace App\Http\Controllers\PrepareLesson;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\GeneralEducation\Entry;
use App\Models\PrepareLessons\Course;
use App\Repositories\Learn\PrepareLessons\LearnRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearnController extends Controller
{
    // Sections Lesson ve source verileri al.
    public function getCourse($id){
        // course entry control
        $user = Auth::user();
        $course = Course::find($id);
        if($this->entry($user,$course) == false){
            return redirect()->route('pl_course',$id);
        }

        // initialization
        $repo = new LearnRepository();
        $user_id = $user->id;
        // Operations
        $resp = $repo->getCourse($id,$user_id);
        $data = $resp->getData();
        return view('prepare_for_lesson.watch')->with('course',$data)->with('isTest',false);
    }

    private function entry(User $user, Course $course){
        $now = date('Y-m-d', time());
        $entry = Entry::where('student_id', $user->student->id)->where('course_type','App\Models\PrepareLessons\Course')->where('course_id', $course->id)->where('active', true)->first();
        if($entry != null and date('Y-m-d',strtotime($entry->access_start))<=$now and date('Y-m-d',strtotime($entry->access_finish))>=$now){
            return true;
        }
        else{
            return false;
        }
    }

    public function getLesson($course_id,$lesson_id){
        // initialization
        $repo = new LearnRepository();

        // Operations
        $user = Auth::user();
        $course = Course::find($course_id);
        if($this->entry($user,$course)){
            $resp = $repo->getLesson($course_id,$lesson_id);
            $data = $resp->getData();
            return view('prepare_for_lesson.watch')->with('course',$data);
        }
        else{
            return redirect()->route('pl_course',$course_id);
        }

    }

    public function getFirstTest($courseId,$sectionId){
        // initialization
        $repo = new LearnRepository();
        $user_id = Auth::id();
        // Operations
        $resp = $repo->getCourse($courseId,$user_id);
        $data = $resp->getData();
        return view('prepare_for_lesson.watch')->with('courseId',$courseId)->with('sectionId',$sectionId)->with('course',$data)->with('isTest',true);
    }
    public function getLastTest($courseId,$sectionId){
        // initialization
        $repo = new LearnRepository();
        $user_id = Auth::id();
        // Operations
        $resp = $repo->getCourse($courseId,$user_id);
        $data = $resp->getData();
        return view('prepare_for_lesson.watch')->with('courseId',$courseId)->with('sectionId',$sectionId)->with('course',$data)->with('isTest',true);
    }
}
