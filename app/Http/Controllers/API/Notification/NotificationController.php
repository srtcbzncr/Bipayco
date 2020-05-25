<?php

namespace App\Http\Controllers\API\Notification;

use App\Http\Controllers\Controller;
use App\Repositories\UserOperations\NotificationRepository;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function create($userId,Request $request){
        $data = $request->toArray();
        $repo = new NotificationRepository();
        $resp = $repo->createNotification($userId,$data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Bildirim başarıyla oluşturuld.'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Bildirim oluşturulurken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ]);
    }

    public function show($userId){
        $repo = new NotificationRepository();
        $resp = $repo->show($userId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Bildirimler başarıyla getirildi.'
            ]);
        }

        return response()->json([
           'error' => true,
           'message' => 'Bildirimler getirilirken bir hata meydana geldi.Tekrar deneyin.',
           'errorMessage' => $resp->getError()
        ]);
    }

    public function get($notificationId){
        $repo = new NotificationRepository();
        $resp = $repo->get($notificationId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Bildirim başarıyla getirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Bildirim getirilirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ]);
    }

    public function delete($notificationId){
        $repo = new NotificationRepository();
        $resp = $repo->delete($notificationId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Bildirim başarıyla silindi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Bildirim silindi bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ]);
    }

    public function seen($notificationId){
        $repo = new NotificationRepository();
        $resp = $repo->seen($notificationId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Bildirimin görüntülenme durumu başarıyla güncellendi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Bildirimin görüntülenme durumu güncellenirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ]);
    }

    public function acceptGuardian($studentId,$guardianId){
        $repo = new NotificationRepository();
        $resp = $repo->acceptGuardian($studentId,$guardianId);
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

    public function rejectGuardian($studentId,$guardianId){
        $repo = new NotificationRepository();
        $resp = $repo->rejectGuardian($studentId,$guardianId);
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
