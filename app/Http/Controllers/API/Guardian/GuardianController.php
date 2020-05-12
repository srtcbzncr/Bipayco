<?php

namespace App\Http\Controllers\API\Guardian;

use App\Http\Controllers\Controller;
use App\Repositories\Guardian\GuardianRepository;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    public function create(Request $request){
        $repo = new GuardianRepository();
        $resp=$repo->create($request->toArray());
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

    public function update($userId,Request $request){
        $repo = new GuardianRepository();
        $resp=$repo->update($userId,$request->toArray());
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

    public function delete($userId){
        $repo = new GuardianRepository();
        $resp=$repo->delete($userId);
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

    public function get($userId){
        $repo = new GuardianRepository();
        $resp=$repo->get($userId);
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

    public function addStudent(Request $request){
        $repo = new GuardianRepository();
        $resp=$repo->addStudent($request->toArray());
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

    public function deleteStudent($userId,$otherId){
        $repo = new GuardianRepository();
        $resp=$repo->deleteStudent($userId,$otherId);
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

    public function getStudents($userId){
        $repo = new GuardianRepository();
        $resp=$repo->getStudents($userId);
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

    public function getStudent($userId,$otherId){
        $repo = new GuardianRepository();
        $resp=$repo->getStudent($userId,$otherId);
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

    public function getCourseInfo(){

    }

    public function getflTestInfo(){

    }
}
