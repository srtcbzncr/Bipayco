<?php

namespace App\Http\Controllers\GeneralEducation;

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
        $courseCount = count($coursesResp->getData()->where('active',true)->where('deleted_at',null));

        // Response
        if($subCategoryResp->getResult() and $coursesResp->getResult()){
            return view('general_education.sub_category', [
                'sub_category' => $subCategoryResp->getData(),
                'course_count' => $courseCount,
            ]);
        }
        else{
            return redirect()->route('error');
        }
    }
}
