<?php

namespace App\Http\Controllers\API\GeneralEducation;

use App\Http\Controllers\Controller;
use App\Models\GeneralEducation\Course;
use App\Repositories\GeneralEducation\FavoriteRepository;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function create(Request $request){
        // Repo initialization
        $repo = new FavoriteRepository;

        $array = $request->toArray();
        $array['course'] = Course::find($request->course_id);

        // Operations
        $resp = $repo->create($array);

        // Response
        if($resp->getResult()){
            return response()->json(['error' => false, 'message' => __('general_education.course_is_added_favorites')]);
        }
        else{
            return response()->json(['error' => true, 'message' => __('general_education.course_is_added_favorites')]);
        }
    }
}
