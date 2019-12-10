<?php

namespace App\Http\Controllers\API\Base;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityCollection;
use App\Http\Resources\DistrictCollection;
use App\Repositories\Base\CityRepository;
use App\Http\Resources\CityResource;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CityCollection
     */
    public function index()
    {
        // Repo initialization
        $repo = new CityRepository;

        // Operations
        $resp = $repo->all();

        // Response
        if($resp->getResult()){
            return new CityCollection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return CityResource
     */
    public function show($id)
    {
        // Repo initialization
        $repo = new CityRepository;

        // Operations
        $resp = $repo->get($id);

        // Response
        if($resp->getResult()){
            return new CityResource($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return DistrictCollection
     */
    public function districts($id){
        // Repo initialization
        $repo = new CityRepository;

        // Operations
        $resp = $repo->getDistricts($id);

        // Response
        if($resp->getResult()){
            return new DistrictCollection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }
}
