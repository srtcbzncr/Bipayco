<?php

namespace App\Http\Controllers\PrepareExams;

use App\Http\Controllers\Controller;
use App\Models\PrepareExams\Course;
use App\Repositories\Curriculum\ExamRepository;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function show(){
        // initializing
        $repo = new ExamRepository();

        // operations
        $resp = $repo->all();
        if($resp->getResult()){
            $data = $resp->getData();
            return view('prepare_for_exams.exam',$data);
        }
        else{
            return redirect()->back();
        }

    }
}
