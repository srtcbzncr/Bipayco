<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AuthRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function createAdmin(Request $request){
        $data = $request->toArray();
        $repo = new AuthRepository();

        $resp = $repo->createAdmin($data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
           'error' => true,
           'errorMessage' => $resp->getError()
        ],400);
    }

    public function deleteAdmin($adminId){
        $repo = new AuthRepository();

        $resp = $repo->deleteAdmin($adminId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function activeAdmin($adminId){
        $repo = new AuthRepository();

        $resp = $repo->activeAdmin($adminId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function passiveAdmin($adminId){
        $repo = new AuthRepository();

        $resp = $repo->passiveAdmin($adminId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function showAdmins(){
        $repo = new AuthRepository();

        $resp = $repo->showAdmins();
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function getAdmin($adminId){
        $repo = new AuthRepository();

        $resp = $repo->showAdmins();
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError()
        ],400);
    }
}
