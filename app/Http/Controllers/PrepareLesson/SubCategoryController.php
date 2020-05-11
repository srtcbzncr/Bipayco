<?php

namespace App\Http\Controllers\PrepareLesson;

use App\Http\Controllers\Controller;
use App\Models\PrepareLessons\Course;
use App\Repositories\Curriculum\LessonRepository;
use App\Repositories\PrepareLessons\CurriculumRepository;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function show($id){
        // initializing
        $repo = new LessonRepository();

        // operations
        $resp = $repo->get($id);
        if($resp->getResult()){
            $data = $resp->getData();
            $courses = Course::where('lesson_id',$id)->get();
            $data['courseCount'] = count($courses->where('active',true)->where('deleted_at',null));
            return view('prepare_for_lesson.lesson',$data);
        }
        else{
            return redirect()->back();
        }

    }
}
