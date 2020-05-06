<?php

namespace App\Http\Controllers\API\PrepareExams;

use App\Http\Controllers\Controller;
use App\Repositories\PrepareLessons\CurriculumRepository;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    public function showExamCourses($id){
        // Repo initialization
        $repo = new CurriculumRepository();

        // Operations
        $resp = $repo->showExamCourses($id);

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
