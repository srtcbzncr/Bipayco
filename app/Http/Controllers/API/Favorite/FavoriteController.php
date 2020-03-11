<?php

namespace App\Http\Controllers\API\Favorite;

use App\Http\Controllers\Controller;
use App\Repositories\UserOperations\FavoriteRepository;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function add(Request $request){
        return $request->all();
        // Initializing
        $data = $request->toArray();
        $repo = new FavoriteRepository();

        // Operations
        $resp=$repo->add($data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Kurs başarıyla favorilere eklendi.'
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Kurs favorilere eklenirken hata oluştu. Tekrar deneyin.'
            ]);
        }
    }

    public function remove(Request $request){
        // Initializing
        $data = $request->toArray();
        $repo = new FavoriteRepository();

        // Operations
        $resp=$repo->remove($data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Kurs favorilere başarıyla kaldırıldı'
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Kurs favorilerden kaldırılırken hata. Tekrar deneyin.'
            ]);
        }
    }

    public function show($user_id){
        // Initializing
        $repo = new FavoriteRepository();

        // Operations
        $resp=$repo->show($user_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Favoriler başarıyla getirildi'
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Favoriler getirilirken hata oluştu.Tekrar deneyin.'
            ]);
        }
    }
}
