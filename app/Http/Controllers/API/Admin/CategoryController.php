<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function createCategory(Request $request){
        // initializing
        $data = $request->toArray();
        $repo = new CategoryRepository();

        // operations
        $resp = $repo->create($data);
        if ($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Kategori başarıyla oluşturuldu.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Kategori oluşturulurken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function showCategories(){
        // initializing
        $repo = new CategoryRepository();

        // operations
        $resp = $repo->all();
        if ($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Kategoriler başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Kategoriler getirilirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function showCategory($categoryId){
        // initializing
        $repo = new CategoryRepository();

        // operations
        $resp = $repo->get($categoryId);
        if ($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Kategori başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Kategori getirilirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function deleteCategory($categoryId){
        // initializing
        $repo = new CategoryRepository();

        // operations
        $resp = $repo->delete($categoryId);
        if ($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Kategori başarıyla silindi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Kategori silinirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function updateCategory($categoryId,Request $request){
        // initializing
        $repo = new CategoryRepository();
        $data = $request->toArray();

        // operations
        $resp = $repo->update($categoryId,$data);
        if ($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Kategori başarıyla güncellendi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Kategori güncellenirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function setActive($categoryId){
        // initializing
        $repo = new CategoryRepository();

        // operations
        $resp = $repo->setActive($categoryId);
        if ($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Kategori başarıyla aktif hale getirildi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Kategori silinirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function setPassive($categoryId){
        // initializing
        $repo = new CategoryRepository();

        // operations
        $resp = $repo->setPassive($categoryId);
        if ($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Kategori başarıyla pasif hale getirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Kategori pasif hale getirilirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function getSubCategories($categoryId){
        // initializing
        $repo = new CategoryRepository();

        // operations
        $resp = $repo->getSubCategoriesOfCategory($categoryId);
        if ($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Kategoriye ait alt kategoriler başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Kategoriye ait alt kategoriler getirilirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }
}
