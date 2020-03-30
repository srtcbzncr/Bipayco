<?php

namespace App\Http\Controllers\API\GeneralEducation;

use App\Http\Controllers\Controller;
use App\Repositories\GeneralEducation\SubCategoryRepository;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function show($id){
        // Repo initialization
        $repo = new SubCategoryRepository;

        // Operations
        $subCategoryResp = $repo->get($id);
        $coursesResp = $repo->getCourses($id);
        $courseCount = count($coursesResp->getData());

        // Response
        if($subCategoryResp->getResult() and $coursesResp->getResult()){
            $data = array();
            $data['sub_category'] = $subCategoryResp->getData();
            $data['courses'] = $coursesResp->getData();
            $data['course_count'] = $courseCount;

            return response()->json([
               'error' => false,
               'data' => $data
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Alt kategori verileri çekilirlen hata oluştu.Tekrar deneyin.'
        ]);
    }
}
