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
                'data' => $resp->getData(),
                'message' => 'Admin başarıyla oluşturuldu.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Admin oluşturulurken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function deleteAdmin($adminId){
        $repo = new AuthRepository();

        $resp = $repo->deleteAdmin($adminId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Admin başarıyla silindi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Admin silinirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function activeAdmin($adminId){
        $repo = new AuthRepository();

        $resp = $repo->activeAdmin($adminId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Admin başarıyla aktifleştirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Admin aktifleştirilirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function passiveAdmin($adminId){
        $repo = new AuthRepository();

        $resp = $repo->passiveAdmin($adminId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Admin başarıyla pasifleştirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Admin pasifleştirilirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function showAdmins(){
        $repo = new AuthRepository();

        $resp = $repo->showAdmins();
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Admin verileri başarıyla getirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Admin verileri getirilirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function getAdmin($adminId){
        $repo = new AuthRepository();

        $resp = $repo->getAdmin($adminId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Admin başarıyla getirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Admin getirilirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function showStudents(){
        $repo = new AuthRepository();

        $resp = $repo->showStudents();
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'öğrenci verileri başarıyla getirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Öğrenci verileri getirilirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function getStudent($studentId){
        $repo = new AuthRepository();

        $resp = $repo->getStudent($studentId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Öğrenci başarıyla getirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Öğrenci getirilirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function activeStudent($studentId){
        $repo = new AuthRepository();

        $resp = $repo->activeStudent($studentId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Öğrenci başarıyla aktifleştirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Öğrenci aktifleştirilirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function passiveStudent($studentId){
        $repo = new AuthRepository();

        $resp = $repo->passiveStudent($studentId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Öğrenci başarıyla pasifleştirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Öğrenci pasifleştirilirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function deleteStudent($studentId){
        $repo = new AuthRepository();

        $resp = $repo->deleteStudent($studentId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Öğrenci başarıyla silindi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Öğrenci silinirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function showInstructors(){
        $repo = new AuthRepository();

        $resp = $repo->showInstructors();
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Eğitmen verileri başarıyla getirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Eğitmen verileri getirilirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function getInstructor($instructorId){
        $repo = new AuthRepository();

        $resp = $repo->getInstructor($instructorId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Eğitmen başarıyla getirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Eğitmen getirilirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function activeInstructor($instructorId){
        $repo = new AuthRepository();

        $resp = $repo->activeInstructor($instructorId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Eğitmen başarıyla aktifleştirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Eğitmen aktifleştirilirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function passiveInstructor($instructorId){
        $repo = new AuthRepository();

        $resp = $repo->passiveInstructor($instructorId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Eğitmen başarıyla pasifleştiridi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Eğitmen pasifleştirilirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function deleteInstructor($instructorId){
        $repo = new AuthRepository();

        $resp = $repo->deleteInstructor($instructorId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Eğitmen başarıyla silindi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Eğitmen silinirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function showGuardians(){
        $repo = new AuthRepository();

        $resp = $repo->showGuardians();
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Veli verileri başarıyla getirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Veli verileri getirilirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function getGuardian($guardianId){
        $repo = new AuthRepository();

        $resp = $repo->getGuardian($guardianId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Veli başarıyla getirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Veli getirilirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function activeGuardian($guardianId){
        $repo = new AuthRepository();

        $resp = $repo->activeGuardian($guardianId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Veli başarıyla aktifleşitirilirdi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Veli aktifleştirilirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function passiveGuardian($guardianId){
        $repo = new AuthRepository();

        $resp = $repo->passiveGuardian($guardianId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Veli başarıyla pasifleştirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Veli pasifleştirilirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function deleteGuardian($guardianId){
        $repo = new AuthRepository();

        $resp = $repo->deleteGuardian($guardianId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Veli başarıyla silindi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Veli silinirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }
}
