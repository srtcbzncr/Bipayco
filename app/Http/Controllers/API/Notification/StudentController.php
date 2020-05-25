<?php

namespace App\Http\Controllers\API\Notification;

use App\Http\Controllers\Controller;
use App\Repositories\UserOperations\NotificationRepository;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function accept($studentId,$guardianId){
        $repo = new NotificationRepository();
        $resp = $repo->accept($studentId,$guardianId);
        if($resp->getResult()){
            return response()->json([
               'error' => false,
               'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Bir hata meydana geldi.Tekrar deneyin',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function reject($studentId,$guardianId){
        $repo = new NotificationRepository();
        $resp = $repo->reject($studentId,$guardianId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Bir hata meydana geldi.Tekrar deneyin',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function redirect($studentId,$guardianId){
        $repo = new NotificationRepository();
        $resp = $repo->redirect($studentId,$guardianId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Bir hata meydana geldi.Tekrar deneyin',
            'errorMessage' => $resp->getError()
        ],400);
    }
}
