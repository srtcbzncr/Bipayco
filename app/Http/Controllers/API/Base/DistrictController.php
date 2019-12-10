<?php

namespace App\Http\Controllers\API\Base;

use App\Http\Controllers\Controller;
use App\Http\Resources\DistrictCollection;
use App\Http\Resources\DistrictResource;
use App\Repositories\Base\DistrictRepository;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return DistrictCollection
     */
    public function index()
    {
        // Repo initialization
        $repo = new DistrictRepository;

        // Operations
        $resp = $repo->all();

        // Response
        if($resp->getResult()){
            return new DistrictCollection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return DistrictResource
     */
    public function show($id)
    {
        // Repo initialization
        $repo = new DistrictRepository;

        // Operations
        $resp = $repo->get($id);

        // Response
        if($resp->getResult()){
            return new DistrictResource($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }
}
