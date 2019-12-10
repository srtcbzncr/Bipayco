<?php

namespace App\Http\Controllers\API\Base;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Http\Resources\CountryCollection;
use App\Http\Resources\CityCollection;
use App\Repositories\Base\CountryRepository;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CountryCollection
     */
    public function index()
    {
        // Repo initialization
        $repo = new CountryRepository;

        // Operations
        $resp = $repo->all();

        // Response
        if($resp->getResult()){
            return new CountryCollection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Repo initialization
        $repo = new CountryRepository;

        // Operations
        $resp = $repo->get($id);

        // Response
        if($resp->getResult()){
            return new CountryResource($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function cities($id){
        // Repo initialization
        $repo = new CountryRepository;

        // Operations
        $resp = $repo->getCities($id);

        // Response
        if($resp->getResult()){
            return new CityCollection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }
}
