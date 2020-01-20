<?php

namespace App\Repositories\Auth;

use App\Models\Auth\User;
use App\Models\GeneralEducation\Course;
use App\Repositories\Base\SchoolRepository;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use App\Models\Auth\Instructor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InstructorRepository implements IRepository{

    /**
     * Return all students.
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
            $object = Instructor::all();
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
     * Return a instructor by id.
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
            $object = Instructor::find($id);
        }
        catch (\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByEmail($email)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $user = User::where('email',$email)->first();
            $object = Instructor::where('user_id', $user->id)->first();
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
     * Return a instructor by reference code.
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
            $object = Instructor::where('reference_code', $referenceCode)->first();
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
     * Create a new instructor.
     *
     * @param  array @data
     * @return App\Repositories\RepositoryResponse
     */
    public function create(array $data)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = new Instructor;

        // Operations
        try{
            $userRepository = new UserRepository;
            $userResp = $userRepository->get($data['user_id']);
            if($userResp->getResult() and !$userResp->isDataNull()){
                $referenceInstructorId = null;
                if($data['reference_code'] != null){
                    $referenceInstructorResp = $this->getByReferenceCode($data['reference_code']);
                    if($referenceInstructorResp->getResult() and $referenceInstructorResp->isDataNull() == false){
                        $referenceInstructorId = $referenceInstructorResp->getData()->id;
                    }
                    else{
                        throw new \Exception(__('auth.invalid_reference_code'));
                    }
                }
                DB::beginTransaction();
                $object->user_id = $userResp->getData()->id;
                $object->identification_number = $data['identification_number'];
                $object->reference_instructor_id = $referenceInstructorId;
                $object->title = $data['title'];
                $object->bio = $data['bio'];
                $object->iban = $data['iban'];
                $object->reference_code = uniqid('in'.random_int(100,999), false);
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
     * Update a instructor.
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
            $object = Instructor::find($id);
            $object->identification_number = $data['identification_number'];
            $object->title = $data['title'];
            $object->bio = $data['bio'];
            $object->iban = $data['iban'];
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
     * Delete a instructor.
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
            Instructor::destroy($id);
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
     * Set instructor's active column to true.
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
            $object = Instructor::find($id);
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
     * Set instructor's active column to false.
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
            $object = Instructor::find($id);
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

    /**
     * Set instructor's school.
     *
     * @params  $int id, string @referenceCode
     * @return App\Repositories\RepositoryResponse
     */
    public function setSchool($id, $referenceCode)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $schoolRepository = new SchoolRepository;
            $schoolResp = $schoolRepository->getByInstructorReferenceCode($referenceCode);
            if($schoolResp->getResult() and !$schoolResp->isDataNull()){
                DB::beginTransaction();
                $object = Instructor::find($id);
                $object->school_id = $schoolResp->getData()->id;
                $object->save();
                DB::commit();
            }
            else{
                throw new \Exception(__('auth.create_profile_failed'));
            }
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getLastGeCourses(){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $data = DB::table('ge_courses_instructors')->where('instructor_id',Auth::user()->instructor->id)->where('course_type','App\Models\GeneralEducation\Course')
                ->orderBy('created_at','desc')->take(20)->get();
            foreach ($data as $key => $item){
                $object[$key] = Course::find($item->course_id);
            }
        }
        catch (\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function getLastPlCourses(){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $data = DB::table('ge_courses_instructors')->where('instructor_id',Auth::user()->instructor->id)->where('course_type','App\Models\PrepareLessons\Course')
                ->orderBy('created_at','desc')->take(20)->get();
            foreach ($data as $key => $item){
                $object[$key] = \App\Models\PrepareLessons\Course::find($item->course_id);
            }
        }
        catch (\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function getLastPeCourses(){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = array();
        }
        catch (\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
}
