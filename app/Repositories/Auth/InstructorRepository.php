<?php

namespace App\Repositories\Auth;

use App\Models\Auth\User;
use App\Models\GeneralEducation\Answer;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Entry;
use App\Models\GeneralEducation\Lesson;
use App\Models\GeneralEducation\Purchase;
use App\Models\GeneralEducation\Question;
use App\Models\GeneralEducation\Section;
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
            $object = Instructor::where('user_id', $user->id)->where('deleted_at',null)->first();
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
            $object = Instructor::where('reference_code', $referenceCode)->where('deleted_at',null)->first();
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
            $data = DB::table('ge_courses_instructors')->where('instructor_id',Auth::user()->instructor->id)
                ->where('deleted_at',null)->where('course_type','App\Models\GeneralEducation\Course')
                ->orderBy('created_at','desc')->take(20)->get();
            foreach ($data as $key => $item){
                $object[$key] = Course::find($item->course_id);
            }
        }
        catch (\Exception $e){
            $error = $e->getMessage();
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
            $data = DB::table('ge_courses_instructors')->where('instructor_id',Auth::user()->instructor->id)
                ->where('deleted_at',null)->where('course_type','App\Models\PrepareLessons\Course')
                ->orderBy('created_at','desc')->take(20)->get();
            foreach ($data as $key => $item){
                $object[$key] = \App\Models\PrepareLessons\Course::find($item->course_id);
            }
        }
        catch (\Exception $e){
            $error = $e->getMessage();
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
            $data = DB::table('ge_courses_instructors')->where('instructor_id',Auth::user()->instructor->id)
                ->where('deleted_at',null)->where('course_type','App\Models\PrepareExams\Course')
                ->orderBy('created_at','desc')->take(20)->get();
            foreach ($data as $key => $item){
                $object[$key] = \App\Models\PrepareExams\Course::find($item->course_id);
            }
        }
        catch (\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function performance($instructorId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = array();
            // eğitmen puanı
            $courses = DB::table('ge_courses_instructors')->where('instructor_id',$instructorId)
                ->where('deleted_at',null)->where('active',true)->get();
            $toplam = 0;
            foreach ($courses as $item){
                if($item->course_type == 'App\Models\GeneralEducation\Course'){
                    $course = Course::find($item->course_id);
                    if($course != null){
                        $puan = $course->point;
                        $toplam+=$puan;
                    }
                }
                else if($item->course_type == 'App\Models\PrepareLessons\Course'){
                    $course = \App\Models\PrepareLessons\Course::find($item->course_id);
                    if($course!=null){
                        $puan = $course->point;
                        $toplam+=$puan;
                    }
                }
            }
            if(count($courses) != 0)
                $ort = $toplam/count($courses);
            else
                $ort = 0;
            $object['instructorScore'] = $ort;

            // toplam öğrenci
            $totalStudent = 0;
            foreach ($courses as $item){
                if($item->course_type == 'App\Models\GeneralEducation\Course'){
                    $course = Entry::where('course_id',$item->course_id)->where('deleted_at',null)->where('course_type','App\Models\GeneralEducation\Course')->where('active',true)->get();
                    $totalStudent+=count($course);
                }
                else if($item->course_type == 'App\Models\PrepareLessons\Course'){
                    $course = Entry::where('course_id',$item->course_id)->where('deleted_at',null)->where('course_type','App\Models\PrepareLessons\Course')->where('active',true)->get();
                    $totalStudent+=count($course);
                }
            }
            $object['totalStudent'] = $totalStudent;

            // Kurs sayıları
            $geCount = 0;
            $plCount = 0;
            $peCount = 0; // prepare exams
            $praticExamsCount = 0;
            $qb = 0; // questions banks
            $homeWorkCount = 0;
            foreach ($courses as $item){
                if($item->course_type == 'App\Models\GeneralEducation\Course'){
                    $geCount++;
                }
                else if($item->course_type == 'App\Models\PrepareLessons\Course'){
                    $plCount++;
                }
            }
            $object['geCount'] = $geCount;
            $object['plCount'] = $plCount;
            $object['peCount'] = $peCount;
            $object['praticeExamsCount'] = $praticExamsCount;
            $object['qbCount'] = $qb;
            $object['homeworkCount'] = $homeWorkCount;

            // Toplam Kazanç
            $totalPay = 0;
            foreach ($courses as $item){
                if($item->course_type == 'App\Models\GeneralEducation\Course'){
                    $purchases = Purchase::where('course_id',$item->course_id)->where('deleted_at',null)->where('course_type','App\Models\GeneralEducation\Course')->where('confirmation',1)->get();
                    foreach ($purchases as $purchase){
                        $price=$purchase->price;
                        $pay = ($price*$item->percent)/100;
                        $totalPay+=$pay;
                    }
                }
                else if($item->course_type == 'App\Models\PrepareLessons\Course'){
                    $purchases = Purchase::where('course_id',$item->course_id)->where('deleted_at',null)->where('course_type','App\Models\PrepareLessons\Course')->where('confirmation',1)->get();
                    foreach ($purchases as $purchase){
                        $price=$purchase->price;
                        $pay = ($price*$item->percent)/100;
                        $totalPay+=$pay;
                    }
                }
            }
            // Bu ay toplam kazanç
            $totalMonthPay = 0;
            foreach ($courses as $item){
                $currentMonth = date('m');
                if($item->course_type == 'App\Models\GeneralEducation\Course'){
                    $purchases = DB::table('ge_purchases')->where('course_id',$item->course_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('confirmation',1)
                        ->whereRaw('MONTH(created_at) = ?',[$currentMonth])->get();
                }
                else if($item->course_type == 'App\Models\PrepareLessons\Course'){
                    $purchases = DB::table('ge_purchases')->where('course_id',$item->course_id)->where('course_type','App\Models\PrepareLessons\Course')
                        ->where('confirmation',1)
                        ->whereRaw('MONTH(created_at) = ?',[$currentMonth])->get();
                }

                foreach ($purchases as $purchase){
                    $price=$purchase->price;
                    $pay = ($price*$item->percent)/100;
                    $totalMonthPay+=$pay;
                }
            }

            // Bu yıl Toplam kazanç
            $totalYearPay = 0;
            foreach ($courses as $item){
                $currentMonth = date('y');
                if($item->course_type == 'App\Models\GeneralEducation\Course'){
                    $purchases = DB::table('ge_purchases')->where('course_id',$item->course_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('confirmation',1)
                        ->whereRaw('YEAR(created_at) = ?',[$currentMonth])->get();
                }
                else if($item->course_type == 'App\Models\PrepareLessons\Course'){
                    $purchases = DB::table('ge_purchases')->where('course_id',$item->course_id)->where('course_type','App\Models\PrepareLessons\Course')
                        ->where('confirmation',1)
                        ->whereRaw('YEAR(created_at) = ?',[$currentMonth])->get();
                }
                foreach ($purchases as $purchase){
                    $price=$purchase->price;
                    $pay = ($price*$item->percent)/100;
                    $totalYearPay+=$pay;
                }
            }

            $object['totalMonthPrice'] = $totalMonthPay;
            $object['totalYearPrice'] = $totalYearPay;
            $object['totalPrice'] = $totalPay;

            // Toplam Yorumlar
            $totalQuestions = 0;
            $notAnsweredQuestions = 0;
            foreach ($courses as $item){
                if($item->course_type == 'App\Models\GeneralEducation\Course'){
                    $sections = Section::where('course_id',$item->course_id)->where('deleted_at',null)->get();
                    foreach ($sections as $section){
                        $lessons = Lesson::where('section_id',$section->id)->where('deleted_at',null)->get();
                        foreach ($lessons as $lesson){
                            $questions = Question::where('lesson_id',$lesson->id)->where('deleted_at',null)->where('lesson_type','App\Models\GeneralEducation\Lesson')->get();
                            $totalQuestions+=count($questions);
                            foreach ($questions as $question){
                                $answers = Answer::where('question_id',$question->id)->where('deleted_at',null)->get();
                                if($answers==null or count($answers) == 0){
                                    $notAnsweredQuestions++;
                                }
                            }
                        }
                    }
                }
                else if($item->course_type == 'App\Models\PrepareLessons\Course'){
                    $sections = Section::where('course_id',$item->course_id)->where('deleted_at',null)->get();
                    foreach ($sections as $section){
                        $lessons = Lesson::where('section_id',$section->id)->where('deleted_at',null)->get();
                        foreach ($lessons as $lesson){
                            $questions = Question::where('lesson_id',$lesson->id)->where('deleted_at',null)->where('lesson_type','App\Models\PrepareLessons\Lesson')->get();
                            $totalQuestions+=count($questions);
                            foreach ($questions as $question){
                                $answers = Answer::where('question_id',$question->id)->where('deleted_at',null)->get();
                                if($answers==null or count($answers) == 0){
                                    $notAnsweredQuestions++;
                                }
                            }
                        }
                    }
                }
            }
            $object['totalQuestions'] = $totalQuestions;
            $object['notAnsweredQuestions'] = $notAnsweredQuestions;
        }
        catch (\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
}
