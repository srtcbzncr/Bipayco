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

    public function showStudents(){
        $repo = new AuthRepository();

        $resp = $repo->showStudents();
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

    public function getStudent($studentId){
        $repo = new AuthRepository();

        $resp = $repo->getStudent($studentId);
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

    public function activeStudent($studentId){
        $repo = new AuthRepository();

        $resp = $repo->activeStudent($studentId);
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

    public function passiveStudent($studentId){
        $repo = new AuthRepository();

        $resp = $repo->passiveStudent($studentId);
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

    public function deleteStudent($studentId){
        $repo = new AuthRepository();

        $resp = $repo->deleteStudent($studentId);
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

    public function showInstructors(){
        $repo = new AuthRepository();

        $resp = $repo->showInstructors();
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

    public function getInstructor($instructorId){
        $repo = new AuthRepository();

        $resp = $repo->getInstructor($instructorId);
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

    public function activeInstructor($instructorId){
        $repo = new AuthRepository();

        $resp = $repo->activeInstructor($instructorId);
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

    public function passiveInstructor($instructorId){
        $repo = new AuthRepository();

        $resp = $repo->passiveInstructor($instructorId);
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

    public function deleteInstructor($instructorId){
        $repo = new AuthRepository();

        $resp = $repo->deleteInstructor($instructorId);
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

    public function showGuardians(){
        $repo = new AuthRepository();

        $resp = $repo->showGuardians();
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

    public function getGuardian($guardianId){
        $repo = new AuthRepository();

        $resp = $repo->getGuardian($guardianId);
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

    public function activeGuardian($guardianId){
        $repo = new AuthRepository();

        $resp = $repo->activeGuardian($guardianId);
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

    public function passiveGuardian($guardianId){
        $repo = new AuthRepository();

        $resp = $repo->passiveGuardian($guardianId);
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

    public function deleteGuardian($guardianId){
        $repo = new AuthRepository();

        $resp = $repo->deleteGuardian($guardianId);
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
