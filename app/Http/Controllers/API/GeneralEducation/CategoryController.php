<?php

namespace App\Http\Controllers\API\GeneralEducation;

use App\Http\Controllers\Controller;
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
}
