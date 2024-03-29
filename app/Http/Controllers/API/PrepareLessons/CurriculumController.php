<?php

namespace App\Http\Controllers\API\PrepareLessonS;

use App\Http\Controllers\Controller;
use App\Repositories\GeneralEducation\CategoryRepository;
use App\Repositories\PrepareLessons\CurriculumRepository;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    public function index(){
        // Repo initialization
        $repo = new CurriculumRepository();

        // Operations
        $resp = $repo->all();

        // Response
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function showLessonCourses($id){
        // Repo initialization
        $repo = new CurriculumRepository();

        // Operations
        $resp = $repo->showLessonCourses($id);

        // Response
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()]);
        }
    }



}
