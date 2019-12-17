<?php

namespace App\Repositories\Auth;

use App\Repositories\IRepository;
use App\Models\Auth\User;
use App\Repositories\RepositoryResponse;
use App\Repositories\Auth\StudentRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserRepository implements IRepository{

    /**
     * Return all users.
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
            $object = User::all();
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
     * Return a user by id.
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
            $object = User::find($id);
        }
        catch(\Exception $e){
            $error = $e;
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
        $object = new User;

        // Operations
        try{
            DB::beginTransaction();
            $object->district_id = $data['district_id'];
            $object->first_name = $data['first_name'];
            $object->last_name = $data['last_name'];
            $object->username = $data['username'];
            $object->email = $data['email'];
            $object->phone_number = $data['phone_number'];
            $object->password = Hash::make($data['password']);
            $object->save();
            $studentRepository = new StudentRepository;
            $studentResp = $studentRepository->create(['user_id' => $object->id]);
            if(!$studentResp->getResult() or $studentResp->isDataNull()){
                $result = false;
                $error = new \Exception(__('auth.create_profile_failed'));
            }
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    /**
     * Update a user's personal data.
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
            $object = User::find($id);
            $object->district_id = $data['district_id'];
            $object->first_name = $data['first_name'];
            $object->last_name = $data['last_name'];
            $object->email = $data['email'];
            $object->phone_number = $data['phone_number'];
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
     * Update a user's password.
     *
     * @param  int @id, array @data
     * @return App\Repositories\RepositoryResponse
     */
    public function updatePassword($id, array $data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = User::find($id);
            $object->password = Hash::make($data['new_password']);
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
     * Update a user's avatar.
     *
     * @param  int @id, array @data
     * @return App\Repositories\RepositoryResponse
     */
    public function updateAvatar($id, array $data)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = User::find($id);
            if($object->avatar != 'avatars/default.jpg'){
                Storage::delete($object->avatar);
            }
            $avatarPath = $data['avatar']->store('avatars');
            $object->avatar = $avatarPath;
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

    public function delete($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $user = User::find($id);
            Storage::delete($user->avatar);
            $user->delete();
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function setActive($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = User::find($id);
            $object->active = true;
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

    public function setPassive($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = User::find($id);
            $student = $object->student;
            if($student != null){
                $student->active = false;
                $student->save();
            }
            $instructor = $object->instructor;
            if($instructor != null){
                $instructor->active = false;
                $instructor->save();
            }
            $admin = $object->admin;
            if($admin != null){
                $admin->active = false;
                $admin->save();
            }
            $guardian = $object->guardian;
            if($guardian != null){
                $guardian->active = false;
                $guardian->save();
            }
            $object->active = false;
            $object->save();
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
}
