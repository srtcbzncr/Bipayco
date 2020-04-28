<?php

namespace App\Http\Controllers\API\Basket;

use App\Http\Controllers\Controller;
use App\Models\UsersOperations\Basket;
use App\Repositories\UserOperations\BasketRepository;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function add(Request $request){
        // Initializing
        $data = $request->toArray();
        $repo = new BasketRepository();

        // Operations
        $resp=$repo->add($data);
        if($resp->getResult()){
            return response()->json([
               'error' => false,
               'message' => 'Kurs başarıyla eklendi.'
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Kurs eklenirken hata oluştu. Tekrar deneyin.',
                'errorMessage' => $resp->getError()
            ]);
        }
    }

    public function remove(Request $request){

        // Initializing
        $data = $request->toArray();
        $repo = new BasketRepository();

        // Operations
        $resp=$repo->remove($data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Kurs başarıyla kaldırıldı'
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Kurs kaldırılırken hata. Tekrar deneyin.',
                'errorMessage' => $resp->getError()
            ]);
        }
    }

    public function removeAll($user_id){
        // Initializing
        $repo = new BasketRepository();

        // Operations
        $resp=$repo->removeAll($user_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Sepet başarıyla silindi',
                'data' => $resp->getData()
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Sepet silinirken hata oluştu.Tekrar deneyin.'
            ]);
        }
    }

    public function show($user_id){
        // Initializing
        $repo = new BasketRepository();

        // Operations
        $resp=$repo->show($user_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Sepet başarıyla getirildi',
                'data' => $resp->getData()
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Sepet getirilirken hata oluştu.Tekrar deneyin.'
            ]);
        }
    }

    public function buy($userId,Request $request){
        
    }
}
