<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\BaseRepository;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function createCity(Request $request){
        // initializing
        $data = $request->toArray();
        $repo = new BaseRepository();

        // Operations
        $resp = $repo->create($data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Şehir başarıyla oluşturuldu.',
            ]);
        }

        return response()->json([
           'error' => true,
           'message' => 'Şehir oluşturulurken hata meydana geldi.Tekrar deneyin',
           'errorMessage' =>  $resp->getError()
        ],400);
    }

    public function showCities(){
        // initializing
        $repo = new BaseRepository();

        // Operations
        $resp = $repo->all();
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Şehir başarıyla getirildi.',
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Şehir getirilirken hata meydana geldi.Tekrar deneyin',
            'errorMessage' =>  $resp->getError()
        ],400);
    }

    public function showCity($city_id){
        // initializing
        $repo = new BaseRepository();

        // Operations
        $resp = $repo->get($city_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Şehir başarıyla getirildi.',
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Şehir getirilirken hata meydana geldi.Tekrar deneyin',
            'errorMessage' =>  $resp->getError()
        ],400);
    }

    public function deleteCity($cityId){
        // initializing
        $repo = new BaseRepository();

        // Operations
        $resp = $repo->delete($cityId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Şehir başarıyla silindi.',
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Şehir silinirken hata meydana geldi.Tekrar deneyin',
            'errorMessage' =>  $resp->getError()
        ],400);
    }

    # --İLÇE--

    public function createDistrict(Request $request){
        // initializing
        $data = $request->toArray();
        $repo = new BaseRepository();

        // Operations
        $resp = $repo->createDistrict($data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'İlçe başarıyla oluşturuldu.',
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'İlçe oluşturulurken hata meydana geldi.Tekrar deneyin',
            'errorMessage' =>  $resp->getError()
        ],400);
    }

    public function showDistricts(){
        // initializing
        $repo = new BaseRepository();

        // Operations
        $resp = $repo->allDistricts();
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'İlçe başarıyla getirildi.',
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'İlçe getirilirken hata meydana geldi.Tekrar deneyin',
            'errorMessage' =>  $resp->getError()
        ],400);
    }

    public function deleteDistrict($districtId){
        // initializing
        $repo = new BaseRepository();

        // Operations
        $resp = $repo->deleteDistrict($districtId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'İlçe başarıyla silindi.',
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'İlçe silinirken hata meydana geldi.Tekrar deneyin',
            'errorMessage' =>  $resp->getError()
        ],400);
    }
}
