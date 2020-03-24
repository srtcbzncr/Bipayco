<?php

namespace App\Http\Controllers\GeneralEducation;

use App\Http\Controllers\Controller;
use App\Repositories\Learn\GeneralEducation\LearnRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class LearnController extends Controller
{
    // Sections Lesson ve source verileri al.
    public function getCourse($id){
        // initialization
        $repo = new LearnRepository();
        $user_id = Auth::user()->id;
        // Operations
        $resp = $repo->getCourse($id,$user_id);
        if($resp->getResult()){
            $data = $resp->getData();
            return view('general_education.watch')->with('course',$data);
        }

        return redirect()->back();
    }

    // Video veya pdf verisini al.
    public function getLesson($course_id,$lesson_id){
        // initialization
        $repo = new LearnRepository();

        // Operations
        $resp = $repo->getLesson($course_id,$lesson_id);
        $data = $resp->getData();
      /*  if($resp->getResult()){
            $data = $resp->getData();
            return view('general_education.watch')->with('course',$data);
        }*/

        return view('general_education.watch')->with('course',$data);
    }
}
