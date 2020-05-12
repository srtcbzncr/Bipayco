<?php


namespace App\Repositories\Guardian;


use App\Models\Auth\Guardian;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;

class GuardianRepository implements IRepository
{

    public function all()
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{

        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function get($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Guardian::where('user_id',$id)->first();
            if($object == null){
                $error = "Veli bulunamadı";
                $result = false;
            }
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function create(array $data)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $control = Guardian::where('user_id',$data['userId'])->first();
            if($control != null){
                $error = "Zaten veli olarak kayıtlısınız.";
                $result = false;
            }
            else{
                DB::beginTransaction();
                $object = new Guardian();
                $object->user_id = $data['userId'];
                $object->active = false;
                $object->reference_code = uniqid('gu'.random_int(100,999), false);
                $object->save();
                DB::commit();
            }
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function update($id, array $data)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Guardian::where('user_id',$id)->first();
            if($object == null){
                $error = "Veli bulunamadı.";
                $result = false;
            }
            else{
                DB::beginTransaction();
                $object->save();
                DB::commit();
            }

        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function delete($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Guardian::where('user_id',$id)->first();
            if($object == null){
                $error = "Veli bulunamadı";
                $result = false;
            }
            else{
                DB::beginTransaction();
                $object->delete();
                DB::commit();
            }
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function setActive($id)
    {
        // TODO: Implement setActive() method.
    }

    public function setPassive($id)
    {
        // TODO: Implement setPassive() method.
    }

    public function addStudent(){

    }


}
