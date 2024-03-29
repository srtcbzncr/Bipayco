<?php

namespace App\Http\Controllers\GeneralEducation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\GeneralEducation\CategoryRepository;

class CategoryController extends Controller
{
    public function show($id){
        // Repo initialization
        $repo = new CategoryRepository;

        // Operations
        $categoryResp = $repo->get($id);
        $coursesResp = $repo->getCourses($id);
        $subCategoriesResp = $repo->getSubCategories($id);
        $courseCount = count($coursesResp->getData()->where('active',true)->where('deleted_at',null));
        $subCategoriesCount = count($subCategoriesResp->getData());

        // Response
        if($categoryResp->getResult() and $coursesResp->getResult() and $subCategoriesResp->getResult()){
            return view('general_education.category', [
                'category' => $categoryResp->getData(),
                'course_count' => $courseCount,
                'sub_categories_count' => $subCategoriesCount,
                'sub_categories' => $subCategoriesResp->getData(),
            ]);
        }
        else{
            return redirect()->route('error');
        }
    }
}
