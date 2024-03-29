<?php

namespace App\Repositories\Auth;

use App\Models\Auth\User;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Entry;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use App\Models\Auth\Student;
use App\Repositories\Base\SchoolRepository;
use App\Repositories\Auth\GuardianRepository;
use Illuminate\Support\Facades\DB;

class StudentRepository implements IRepository{

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
            $object = Student::all();
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
     * Return a student by id.
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
            $object = Student::find($id);
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
     * Return a student by id.
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
            $object = Student::where('reference_code', $referenceCode)->where('deleted_at',null)->first();
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
     * Create a new student.
     *
     * @param  array @data
     * @return App\Repositories\RepositoryResponse
     */
    public function create(array $data)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = new Student;

        // Operations
        try{
            $userRepository = new UserRepository;
            $userResp = $userRepository->get($data['user_id']);
            if($userResp->getResult() and !$userResp->isDataNull()){
                $object->user_id = $userResp->getData()->id;
                $object->reference_code = uniqid('st'.random_int(100,999), false);
                $object->save();
            }
            else{
                $result = false;
                $error = new \Exception(__('auth.create_profile_failed'));
            }
        }
        catch (\Exception $e){
            $error = $e;
            $result = false;
        }
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    /**
     * Update a student.
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
            $object = Student::find($id);
            $object->school_id = $data['school_id'];
            $object->guardian_id = $data['guardian_id'];
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
     * Delete a student.
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
            Student::destroy($id);
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
     * Set student's active column to true.
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
            $object = Student::find($id);
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
     * Set student's active column to false.
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
            $object = Student::find($id);
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
     * Set student's school.
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
            $schoolResp = $schoolRepository->getByStudentReferenceCode($referenceCode);
            if($schoolResp->getResult() and !$schoolResp->isDataNull()){
                DB::beginTransaction();
                $object = Student::find($id);
                $object->school_id = $schoolResp->getData()->id;
                $object->save();
                DB::commit();
            }
            else{
                throw new \Exception(__('auth.create_profile_failed'));
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
     * Set student's guardian.
     *
     * @params  $int id, string @referenceCode
     * @return App\Repositories\RepositoryResponse
     */
    public function setGuardian($id, $referenceCode)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $guardianRepository = new GuardianRepository;
            $guardianResp = $guardianRepository->getByReferenceCode($referenceCode);
            if($guardianResp->getResult() and !$guardianResp->isDataNull()){
                DB::beginTransaction();
                $object = Student::find($id);
                $object->guardian_id = $guardianResp->getData()->id;
                $object->save();
                DB::commit();
            }
            else{
                throw new \Exception(__('auth.create_profile_failed'));
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

    public function courses($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $student = Student::find($id);
            $user = User::find($student->user_id);
            $geCourses = DB::select('SELECT * FROM ge_courses WHERE id IN(SELECT course_id FROM ge_entries WHERE student_id='.$id.' AND course_type="App\\\\Models\\\\GeneralEducation\\\\Course")');
            $plCourses = DB::select('SELECT * FROM pl_courses WHERE id IN(SELECT course_id FROM ge_entries WHERE student_id='.$id.' AND course_type="App\\\\Models\\\\PrepareLessons\\\\Course")');
            $peCourses = DB::select('SELECT * FROM pe_courses WHERE id IN(SELECT course_id FROM ge_entries WHERE student_id='.$id.' AND course_type="App\\\\Models\\\\PrepareExams\\\\Course")');
            $liveCourses = DB::select('SELECT * FROM live_courses WHERE id IN(SELECT live_course_id FROM live_entries WHERE student_id='.$id.')');

            $tempGeCourses = array();
            $tempPlCourses = array();
            $tempPeCourses = array();
            $tempLiveCourses = array();
            foreach ($geCourses as $key=>$course){
                if($this->entryGe($user,$course)){
                    $tempGeCourses[$key] = $course;
                }
            }
            foreach ($plCourses as $key=>$course){
                if($this->entryPl($user,$course)){
                    $tempPlCourses[$key] = $course;
                }
            }
            foreach ($peCourses as $key=>$course){
                if($this->entryPe($user,$course)){
                    $tempPeCourses[$key] = $course;
                }
            }
            foreach ($liveCourses as $key=>$course){
                if($this->entryLive($user,$course)){
                    $tempLiveCourses[$key] = $course;
                }
            }

            $object = [
                'ge' => $tempGeCourses,
                'pl' => $tempPlCourses,
                'pe' => $tempPeCourses,
                'live' => $tempLiveCourses
            ];
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    private function entryGe($user,$course){
        $now = date('Y-m-d', time());
        $entry = Entry::where('student_id', $user->student->id)->where('course_type','App\Models\GeneralEducation\Course')->where('course_id', $course->id)->where('active', true)->first();
        if($entry != null and date('Y-m-d',strtotime($entry->access_start))<=$now and date('Y-m-d',strtotime($entry->access_finish))>=$now){
            return true;
        }
        else{
            return false;
        }
    }
    private function entryPl($user,$course){
        $now = date('Y-m-d', time());
        $entry = Entry::where('student_id', $user->student->id)->where('course_type', \App\Models\PrepareLessons\Course::class)->where('course_id', $course->id)->where('active', true)->first();
        if($entry != null and date('Y-m-d',strtotime($entry->access_start))<=$now and date('Y-m-d',strtotime($entry->access_finish))>=$now){
            return true;
        }
        else{
            return false;
        }
    }

    private function entryPe($user,$course){
        $now = date('Y-m-d', time());
        $entry = Entry::where('student_id', $user->student->id)->where('course_type', \App\Models\PrepareExams\Course::class)->where('course_id', $course->id)->where('active', true)->first();
        if($entry != null and date('Y-m-d',strtotime($entry->access_start))<=$now and date('Y-m-d',strtotime($entry->access_finish))>=$now){
            return true;
        }
        else{
            return false;
        }
    }

    private function entryLive($user,$course){
        $entry = \App\Models\Live\Entry::where('student_id', $user->student->id)->where('live_course_id', $course->id)->first();
        if($entry != null and $course->completed_at == null){
            return true;
        }
        else{
            return false;
        }
    }

    public function geEntries($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $student = Student::find($id);
            $object = $student->geEntries->where('active', true)->get();
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
