<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\SubjectRepository;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function createSubject(Request $request){
        // initializing
        $data = $request->toArray();
        $repo = new SubjectRepository();

        // operations
        $resp = $repo->create($data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Konu başarıyla oluşturuldu.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Konu oluştururken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function showSubjects(){
        // initializing
        $repo = new SubjectRepository();

        // operations
        $resp = $repo->all();
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Konular başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Konular getirilirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function showSubject($subjectId){
        // initializing
        $repo = new SubjectRepository();

        // operations
        $resp = $repo->get($subjectId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Konu başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Konu getirilirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function deleteSubject($subjectId){
        // initializing
        $repo = new SubjectRepository();

        // operations
        $resp = $repo->delete($subjectId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Konu başarıyla silindi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Konu silinirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function updateSubject($subjectId,Request $request){
        // initializing
        $data = $request->toArray();
        $repo = new SubjectRepository();

        // operations
        $resp = $repo->update($subjectId,$data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Konu başarıyla güncellendi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Konu güncellenirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }
}
