<?php

namespace App\Http\Controllers\API\GeneralEducation;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Repositories\GeneralEducation\CommentRepository;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(CommentRequest $request){
        // Validation
        $validatedData = $request->validated();

        // Repo initialization
        $repo = new CommentRepository;

        // Operations
        $resp = $repo->create($validatedData);

        // Response
        if($resp->getResult()){
            return response()->json(['error' => false, 'message' => __('general_education.comment_is_added')]);
        }
        else{
            return response()->json(['error' => true, 'message' => __('general_education.comment_is_not_added')]);
        }
    }
}
