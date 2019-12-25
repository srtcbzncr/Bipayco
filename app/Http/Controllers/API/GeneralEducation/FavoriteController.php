<?php

namespace App\Http\Controllers\API\GeneralEducation;

use App\Http\Controllers\Controller;
use App\Repositories\GeneralEducation\FavoriteRepository;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function create(Request $request){
        // Repo initialization
        $repo = new FavoriteRepository;

        // Operations
        $resp = $repo->create(['user_id' => $request->user_id, 'course_id' => $request->course_id]);

        // Response
        if($resp->getResult()){
            return response()->json(['error' => false, 'message' => __('general_education.course_is_added_favorites')]);
        }
        else{
            return response()->json(['error' => true, 'message' => __('general_education.course_is_added_favorites')]);
        }
    }
}
