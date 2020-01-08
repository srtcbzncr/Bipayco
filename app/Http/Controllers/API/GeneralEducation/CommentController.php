<?php

namespace App\Http\Controllers\API\GeneralEducation;

use App\Http\Controllers\Controller;
use App\Repositories\GeneralEducation\CommentRepository;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Request $request){
        // Repo initialization
        $repo = new CommentRepository;


        if($request->has('content') and $request->has('point')){
            // Operations
            $resp = $repo->create($request->toArray());

            // Response
            if($resp->getResult()){
                return response()->json(['error' => false, 'message' => __('general_education.comment_is_added')]);
            }
            else{
                return response()->json(['error' => true, 'message' => $resp->getError()]);
            }
        }
        else{
            return response()->json(['error' => false, 'message' => 'Lütfen alanları eksiksiz doldurun.']);
        }
    }
}
