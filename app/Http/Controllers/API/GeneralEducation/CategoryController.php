<?php

namespace App\Http\Controllers\API\GeneralEducation;

use App\Http\Controllers\Controller;
use App\Http\Resources\GE_SubCategoryResource;
use App\Repositories\GeneralEducation\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Resources\GE_CategoryResource;

class CategoryController extends Controller
{
    public function index(){
        // Repo initialization
        $repo = new CategoryRepository;

        // Operations
        $resp = $repo->all();

        // Response
        if($resp->getResult()){
            return GE_CategoryResource::collection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function show($id){
        // Repo initialization
        $repo = new CategoryRepository;

        // Operations
        $resp = $repo->get($id);

        // Response
        if($resp->getResult()){
            return new GE_CategoryResource($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function show2($id){
        // Repo initialization
        $repo = new CategoryRepository;

        // Operations
        $categoryResp = $repo->get($id);
        $coursesResp = $repo->getCourses($id);
        $subCategoriesResp = $repo->getSubCategories($id);
        $courseCount = count($coursesResp->getData());
        $subCategoriesCount = count($subCategoriesResp->getData());

        // Response
        if($categoryResp->getResult() and $coursesResp->getResult() and $subCategoriesResp->getResult()){
            $data = array();
            $data['category'] = $categoryResp->getData();
            $data['course_count'] = $courseCount;
            $data['sub_categories_count'] = $subCategoriesCount;
            $data['sub_categories'] = $subCategoriesResp->getData();

            return response()->json([
               'error' => false,
               'data' => $data
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Kategori verileri getirilirken hata oluştu.Tekrar deneyin.'
        ],400);
    }
}
