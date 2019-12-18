<?php

namespace App\Http\Controllers\API\GeneralEducation;

use App\Http\Controllers\Controller;
use App\Repositories\GeneralEducation\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        // Repo initialization
        $repo = new CategoryRepository;

        // Operations
        $resp = $repo->all();

        // Response
        if($resp->getResult()){
            return CategoryResource::collection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }
}
