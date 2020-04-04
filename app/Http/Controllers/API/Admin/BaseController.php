<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\BaseRepository;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    # Country
    public function createCountry(Request $request){

    }

    public function showCountries(){

    }

    public function showCountry($countryId){

    }

    public function deleteCountry($countryId){

    }

    public function updateCountry($countryId,Request $request){

    }

    # City ...
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
                'data' => $resp->getData()
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
                'data' => $resp->getData()
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
                'data' => $resp->getData()
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

    function updateCity($cityId,Request $request){
        // initializing
        $repo = new BaseRepository();
        $data = $request->toArray();

        // Operations
        $resp = $repo->update($cityId,$data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Şehir başarıyla güncellendi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Şehir güncellenirken hata meydana geldi.Tekrar deneyin',
            'errorMessage' =>  $resp->getError()
        ],400);
    }

    public function setActiveCity($cityId){
        // initializing
        $repo = new BaseRepository();

        // Operations
        $resp = $repo->setActive($cityId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Şehir başarıyla aktif hale getirildi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Şehir güncellenirken hata meydana geldi.Tekrar deneyin',
            'errorMessage' =>  $resp->getError()
        ],400);
    }

    public function setPassiveCity($cityId){
        // initializing
        $repo = new BaseRepository();

        // Operations
        $resp = $repo->setPassive($cityId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Şehir başarıyla pasif hale getirildi.',
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Şehir güncellenirken hata meydana geldi.Tekrar deneyin',
            'errorMessage' =>  $resp->getError()
        ],400);
    }

    public function getDistricts($cityId){
        // initializing
        $repo = new BaseRepository();

        // Operations
        $resp = $repo->getDistrictsOfCity($cityId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Şehire ait ilçeler başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Şehire ait ilçeler getirilirken hata meydana geldi.Tekrar deneyin',
            'errorMessage' =>  $resp->getError()
        ],400);
    }

    # --İLÇE------------------------

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
                'data' => $resp->getData()
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
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'İlçe getirilirken hata meydana geldi.Tekrar deneyin',
            'errorMessage' =>  $resp->getError()
        ],400);
    }

    public function showDistrict($districtId){
        // initializing
        $repo = new BaseRepository();

        // Operations
        $resp = $repo->getDistrict($districtId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'İlçe başarıyla getirildi.',
                'data' => $resp->getData()
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

    public function updateDistrict($districtId,Request $request){
        // initializing
        $data = $request->toArray();
        $repo = new BaseRepository();

        // Operations
        $resp = $repo->updateDistrict($districtId,$data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'İlçe başarıyla güncellendi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'İlçe güncellenirken hata meydana geldi.Tekrar deneyin',
            'errorMessage' =>  $resp->getError()
        ],400);
    }

    public function setActiveDistrict($districtId){
        // initializing
        $repo = new BaseRepository();

        // Operations
        $resp = $repo->setActiveDistrict($districtId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'İlçe başarıyla aktif hale getirildi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'İlçe güncellenirken hata meydana geldi.Tekrar deneyin',
            'errorMessage' =>  $resp->getError()
        ],400);
    }

    public function setPassiveDistrict($districtId){
        // initializing
        $repo = new BaseRepository();

        // Operations
        $resp = $repo->setPassiveDistrict($districtId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'İlçe başarıyla pasif hale getirildi.',
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'İlçe güncellenirken hata meydana geldi.Tekrar deneyin',
            'errorMessage' =>  $resp->getError()
        ],400);
    }
}
