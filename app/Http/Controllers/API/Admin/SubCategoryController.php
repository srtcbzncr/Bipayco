<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\SubCategoryRepository;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function createSubCategory(Request $request){
        // initializing
        $data = $request->toArray();
        $repo = new SubCategoryRepository();

        // operations
        $resp = $repo->create($data);
        if($resp->getResult()){
            return response()->json([
               'error' => false,
               'data' => $resp->getData(),
               'message' => 'Alt kategori başarıyla oluşturuldu.'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Alt kategori oluşturulurken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function showSubCategories(){
        // initializing
        $repo = new SubCategoryRepository();

        // operations
        $resp = $repo->all();
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Alt kategoriler başarıyla getirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Alt kategoriler getirilirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function showSubCategory($subCategoryId){
        // initializing
        $repo = new SubCategoryRepository();

        // operations
        $resp = $repo->get($subCategoryId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Alt kategori başarıyla getirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Alt kategori getirilirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function deleteSubCategory($subCategoryId){
        // initializing
        $repo = new SubCategoryRepository();

        // operations
        $resp = $repo->delete($subCategoryId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Alt kategori başarıyla silindi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Alt kategori silinirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function updateSubCategory($subCategoryId,Request $request){
        // initializing
        $data = $request->toArray();
        $repo = new SubCategoryRepository();

        // operations
        $resp = $repo->update($subCategoryId,$data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Alt kategori başarıyla güncellendi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Alt kategori güncellenirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function setActive($subCategoryId){
        // initializing
        $repo = new SubCategoryRepository();

        // operations
        $resp = $repo->setPassive($subCategoryId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Alt kategori başarıyla aktif hale getirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Alt kategori silinirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }
    public function setPassive($subCategoryId){
        // initializing
        $repo = new SubCategoryRepository();

        // operations
        $resp = $repo->setPassive($subCategoryId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Alt kategori başarıyla aktif hale getirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Alt kategori silinirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }
}
