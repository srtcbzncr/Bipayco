<?php

namespace App\Repositories\Auth;

use App\Models\Auth\Guardian;
use App\Models\Auth\User;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;

class GuardianRepository implements IRepository{

    /**
     * Return all guardian.
     *
     * @return App\Repositories\RepositoryResponse
     */
    public function all()
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Guardian::all();
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    /**
     * Return a guardian by id.
     *
     * @param  int $id
     * @return App\Repositories\RepositoryResponse
     */
    public function get($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Guardian::find($id);
        }
        catch (\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    /**
     * Return a guardian by id.
     *
     * @param  string $referenceCode
     * @return App\Repositories\RepositoryResponse
     */
    public function getByReferenceCode($referenceCode)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Guardian::where('reference_code', $referenceCode)->first();
        }
        catch (\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    /**
     * Create a new guardian.
     *
     * @param  array @data
     * @return App\Repositories\RepositoryResponse
     */
    public function create(array $data)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = new Guardian;

        // Operations
        try{
            $userRepository = new UserRepository;
            $userResp = $userRepository->get($data['user_id']);
            if($userResp->getResult() and !$userResp->isDataNull()){
                DB::beginTransaction();
                $object->user_id = $userResp->getData()->id;
                $object->reference_code = uniqid('gu'.random_int(100,999), false);
                $object->save();
                DB::commit();
            }
            else{
                throw new \Exception(__('auth.create_profile_failed'));
            }
        }
        catch (\Exception $e){
            DB::rollBack();
            $error = $e;
            $result = false;
        }
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    /**
     * Update a guardian.
     *
     * @param  int @id, array @data
     * @return App\Repositories\RepositoryResponse
     */
    public function update($id, array $data)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Guardian::find($id);
            $object->save();
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    /**
     * Delete a guardian.
     *
     * @param  int @id
     * @return App\Repositories\RepositoryResponse
     */
    public function delete($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            Guardian::destroy($id);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    /**
     * Set guardian's active column to true.
     *
     * @param  int @id
     * @return App\Repositories\RepositoryResponse
     */
    public function setActive($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Guardian::find($id);
            $object->active = true;
            $object->save();
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        //Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    /**
     * Set guardian's active column to false.
     *
     * @param  int @id
     * @return App\Repositories\RepositoryResponse
     */
    public function setPassive($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Guardian::find($id);
            $object->active = false;
            $object->save();
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
}
