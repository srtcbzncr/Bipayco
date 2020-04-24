<?php

namespace App\Http\Controllers\PrepareLesson;

use App\Http\Controllers\Controller;
use App\Models\Auth\Student;
use App\Models\Auth\User;
use App\Models\GeneralEducation\Entry;
use App\Models\PrepareLessons\Course;
use App\Models\PrepareLessons\Lesson;
use App\Models\PrepareLessons\Section;
use App\Models\QuestionSource\Student\FirstLastTestStatus;
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
        // kurs tutarlılık ve erişim kontrol
        $lesson = Lesson::find($lesson_id);
        if($lesson==null){
            return redirect()->back();
        }

        $section = Section::find($lesson->section_id);
        if($section==null){
            return redirect()->back();
        }

        $flag = false;
        if($section->course_id == $course_id){
            $student = Student::where('user_id',Auth::id())->first();
            $sections = Section::where('course_id',$course_id)->orderBy('no', 'asc')->get();
            foreach ($sections as $key => $item){
                if($item->id == $section->id){
                    if(isset($item[$key-1])){
                        $beforeSection = $item[$key-1];
                        $controlStatus = FirstLastTestStatus::where('sectionId',$beforeSection->id)
                            ->where('sectionType','App\Models\PrepareLessons\Section')
                            ->where('result',true)
                            ->where('studentId',$student->id)->get();
                        if($controlStatus == null or count($controlStatus) == 0){
                            $flag = false;
                            break;
                        }
                        else{
                            $flag = true;
                            break;
                        }
                    }
                    else{
                        $flag = true;
                        break;
                    }
                }
            }
        }
        else{
            return redirect()->back();
        }

        if(!$flag){
            return redirect()->back();
        }

        // initialization
        $repo = new LearnRepository();

        // Operations
        $user = Auth::user();
        $course = Course::find($course_id);
        if($this->entry($user,$course)){
            $resp = $repo->getLesson($course_id,$lesson_id);
            $data = $resp->getData();
            return view('prepare_for_lesson.watch')->with('course',$data)->with('isTest',false);
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
        $section = Section::find($sectionId);
        $data['selectedSection'] = $section;
        return view('prepare_for_lesson.watch')->with('courseId',$courseId)->with('course',$data)->with('isTest',true)->with('testType',0);
    }
    public function getLastTest($courseId,$sectionId){
        // initialization
        $repo = new LearnRepository();
        $user_id = Auth::id();
        // Operations
        $resp = $repo->getCourse($courseId,$user_id);
        $data = $resp->getData();
        $section = Section::find($sectionId);
        $data['selectedSection'] = $section;
        return view('prepare_for_lesson.watch')->with('courseId',$courseId)->with('course',$data)->with('isTest',true)->with('testType',1);
    }
}
