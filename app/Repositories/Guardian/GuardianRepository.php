<?php


namespace App\Repositories\Guardian;


use App\Models\Auth\Guardian;
use App\Models\Auth\GuardianUser;
use App\Models\Auth\Student;
use App\Models\Auth\User;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Entry;
use App\Models\GeneralEducation\Lesson;
use App\Models\GeneralEducation\Section;
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
            else{
                $user = User::find($id);
                $object['user'] = $user;
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

    public function addStudent($data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $student = Student::where('reference_code',$data['referenceCode'])->first();
            $guardian = Guardian::where('user_id',$data['guardianUserId'])->first();
            $object = new GuardianUser();
            $object->guardian_id = $guardian->id;
            $object->student_id = $student->id;
            $object->active = true;
            $object->save();
            DB::commit();
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

    public function deleteStudent($userId,$otherId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $guardian = Guardian::where('user_id',$userId)->first();
            $student = Student::where('user_id',$otherId)->first();
            $object = GuardianUser::where('guardian_id',$guardian->id)
                ->where('student_id',$student->id)->first();
            $object->delete();
            DB::commit();
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

    public function getStudents($userId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $guardian = Guardian::where('user_id',$userId)->first();
            $object = GuardianUser::where('guardian_id',$guardian->id)->where('deleted_at',null)->paginate(10);
           // $object = GuardianUser::where('guardian_id',$guardian->id)->get();
            foreach ($object as $key => $item){
                $student = Student::find($item->student_id);
                $user = User::find($student->user_id);
                $object[$key]['student'] = $student;
                $object[$key]['user'] = $user;
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

    public function getStudentsList($userId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $guardian = Guardian::where('user_id',$userId)->first();
            $object = GuardianUser::where('guardian_id',$guardian->id)->where('deleted_at',null)->get();
            // $object = GuardianUser::where('guardian_id',$guardian->id)->get();
            foreach ($object as $key => $item){
                $student = Student::find($item->student_id);
                $user = User::find($student->user_id);
                $object[$key]['student'] = $student;
                $object[$key]['user'] = $user;
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

    public function getStudent($userId,$otherId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Student::where('user_id',$otherId)->first();
            $user = User::find($otherId);
            $object['user'] =  $user;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getCourseInfo($userId,$otherId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $student = Student::where('user_id',$otherId)->first();
            $entries = Entry::where('student_id',$student->id)->where('active',true)
                ->where('deleted_at',null)->get();
            $userAllCourses = array();
            $userAllCourses['ge'] = array();
            $userAllCourses['pl'] = array();
            $userAllCourses['pe'] = array();

            $usersCompletedLessons = array();
            $usersCompletedLessons['ge'] = array();
            $usersCompletedLessons['pl'] = array();
            $usersCompletedLessons['pe'] = array();
            foreach ($entries as $keyEntry => $entry){
                if($entry->course_type == 'App\Models\GeneralEducation\Course'){
                    $tempCourse = Course::find($entry->course_id);
                    array_push( $userAllCourses['ge'],$tempCourse);

                    $sections = Section::where('course_id',$entry->course_id)
                        ->where('active',true)->where('deleted_at',null)->get();
                    foreach ($sections as $keySection => $section){
                        $lessons = Lesson::where('section_id',$section->id)->where('active',true)->where('deleted_at',null)->get();
                        foreach ($lessons as $keyLesson => $lesson){
                            $completedLesson = DB::table('ge_students_completed_lessons')
                                ->where('student_id',$student->id)
                                ->where('lesson_id',$lesson->id)
                                ->where('lesson_type','App\Models\GeneralEducation\Lesson')
                                ->where('deleted_at',null)->get()->toArray();
                            if($completedLesson != null and count($completedLesson)>0){
                                $lesson['course'] = Course::find($entry->course_id);
                                $lesson['section'] = $section;
                                array_push($usersCompletedLessons['ge'],$lesson);
                            }
                        }
                    }
                }
                else if($entry->course_type == 'App\Models\PrepareLessons\Course'){
                    $tempCourse = \App\Models\PrepareLessons\Course::find($entry->course_id);
                    array_push( $userAllCourses['pl'],$tempCourse);

                    $sections = \App\Models\PrepareLessons\Section::where('course_id',$entry->course_id)
                        ->where('active',true)->where('deleted_at',null)->get();
                    foreach ($sections as $keySection => $section){
                        $lessons = \App\Models\PrepareLessons\Lesson::where('section_id',$section->id)->where('active',true)->where('deleted_at',null)->get();
                        foreach ($lessons as $keyLesson => $lesson){
                            $completedLesson = DB::table('ge_students_completed_lessons')
                                ->where('student_id',$student->id)
                                ->where('lesson_id',$lesson->id)
                                ->where('lesson_type','App\Models\PrepareLessons\Lesson')
                                ->where('deleted_at',null)->get()->toArray();
                            if($completedLesson != null and count($completedLesson)>0){
                                $lesson['course'] = \App\Models\PrepareLessons\Course::find($entry->course_id);
                                $lesson['section'] = $section;
                                array_push($usersCompletedLessons['pl'],$lesson);
                            }
                        }
                    }
                }
                else if($entry->course_type == 'App\Models\PrepareExams\Course'){

                    $tempCourse = \App\Models\PrepareExams\Course::find($entry->course_id);
                    array_push( $userAllCourses['pe'],$tempCourse);

                    $sections = \App\Models\PrepareExams\Section::where('course_id',$entry->course_id)
                        ->where('active',true)->where('deleted_at',null)->get();
                    foreach ($sections as $keySection => $section){
                        $lessons = \App\Models\PrepareExams\Lesson::where('section_id',$section->id)->where('active',true)->where('deleted_at',null)->get();
                        foreach ($lessons as $keyLesson => $lesson){
                            $completedLesson = DB::table('ge_students_completed_lessons')
                                ->where('student_id',$student->id)
                                ->where('lesson_id',$lesson->id)
                                ->where('lesson_type','App\Models\PrepareExams\Lesson')
                                ->where('deleted_at',null)->get()->toArray();
                            if($completedLesson != null and count($completedLesson)>0){
                                $lesson['course'] = \App\Models\PrepareExams\Course::find($entry->course_id);
                                $lesson['section'] = $section;
                                array_push($usersCompletedLessons['pe'],$lesson);
                            }
                        }
                    }
                }
            }

            $tempGe = array_chunk($usersCompletedLessons['ge'],10);
            $tempPl = array_chunk($usersCompletedLessons['pl'],10);
            $tempPe = array_chunk($usersCompletedLessons['pe'],10);

          /*  $tempAllGe =  array_chunk($userAllCourses['ge'],10);
            $tempAllPl =  array_chunk($userAllCourses['pl'],10);
            $tempAllPe =  array_chunk($userAllCourses['pe'],10);*/

            $object = array();
         /*
            $object['ge'] = $tempGe;
            $object['pl'] = $tempPl;
            $object['pe'] = $tempPe;*/

            $object['allCourses'] = array();
            $object['allCourses']['ge'] = $userAllCourses['ge'];
            $object['allCourses']['pl'] = $userAllCourses['pl'];
            $object['allCourses']['pe'] = $userAllCourses['pe'];

        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getOneCourseInfo($userId,$otherId,$courseId,$courseType){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = null;
            $student = Student::where('user_id',$otherId)->first();
            if($courseType == 1){
                $course = Course::find($courseId);
                $sections = Section::where('course_id',$courseId)
                    ->where('active',true)->where('deleted_at',null)->get();
                foreach ($sections as $keySection => $section){
                    $course['sections'][$keySection] = $section;
                    $lessons = Lesson::where('section_id',$section->id)->where('active',true)->where('deleted_at',null)->get();
                    foreach ($lessons as $keyLesson => $lesson){
                        $completedLesson = DB::table('ge_students_completed_lessons')
                            ->where('student_id',$student->id)
                            ->where('lesson_id',$lesson->id)
                            ->where('lesson_type','App\Models\GeneralEducation\Lesson')
                            ->where('deleted_at',null)->get()->toArray();
                        if($completedLesson != null and count($completedLesson)>0){
                            $lesson['isCompleted'] = true;
                            $course['sections'][$keySection]['lessons'][$keyLesson] = $lesson;
                        }
                        else{
                            $lesson['isCompleted'] = false;
                            $course['sections'][$keySection]['lessons'][$keyLesson] = $lesson;
                        }
                    }
                }
            }
            else if($courseType == 2){
                $course = \App\Models\PrepareLessons\Course::find($courseId);
                $sections = \App\Models\PrepareLessons\Section::where('course_id',$courseId)
                    ->where('active',true)->where('deleted_at',null)->get();
                foreach ($sections as $keySection => $section){
                    $course['sections'][$keySection] = $section;
                    $lessons = \App\Models\PrepareLessons\Lesson::where('section_id',$section->id)->where('active',true)->where('deleted_at',null)->get();
                    foreach ($lessons as $keyLesson => $lesson){
                        $completedLesson = DB::table('ge_students_completed_lessons')
                            ->where('student_id',$student->id)
                            ->where('lesson_id',$lesson->id)
                            ->where('lesson_type','App\Models\PrepareLessons\Lesson')
                            ->where('deleted_at',null)->get()->toArray();
                        if($completedLesson != null and count($completedLesson)>0){
                            $lesson['isCompleted'] = true;
                            $course['sections'][$keySection]['lessons'][$keyLesson] = $lesson;
                        }
                        else{
                            $lesson['isCompleted'] = false;
                            $course['sections'][$keySection]['lessons'][$keyLesson] = $lesson;
                        }
                    }
                }
            }
            else if($courseType == 3){
                $course = \App\Models\PrepareExams\Course::find($courseId);
                $sections = \App\Models\PrepareExams\Section::where('course_id',$courseId)
                    ->where('active',true)->where('deleted_at',null)->get();
                foreach ($sections as $keySection => $section){
                    $course['sections'][$keySection] = $section;
                    $lessons = \App\Models\PrepareExams\Lesson::where('section_id',$section->id)->where('active',true)->where('deleted_at',null)->get();
                    foreach ($lessons as $keyLesson => $lesson){
                        $completedLesson = DB::table('ge_students_completed_lessons')
                            ->where('student_id',$student->id)
                            ->where('lesson_id',$lesson->id)
                            ->where('lesson_type','App\Models\PrepareExams\Lesson')
                            ->where('deleted_at',null)->get()->toArray();
                        if($completedLesson != null and count($completedLesson)>0){
                            $lesson['isCompleted'] = true;
                            $course['sections'][$keySection]['lessons'][$keyLesson] = $lesson;
                        }
                        else{
                            $lesson['isCompleted'] = false;
                            $course['sections'][$keySection]['lessons'][$keyLesson] = $lesson;
                        }
                    }
                }
            }

            $object = $course;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getflTestInfo($userId,$otherId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $student = Student::where('user_id',$otherId)->first();
            $entries = Entry::where('student_id',$student->id)->where('active',true)
                ->where('deleted_at',null)->get();
            $usersFLTestStatus = array();
            $usersFLTestStatus['ge'] = array();
            $usersFLTestStatus['pl'] = array();
            $usersFLTestStatus['pe'] = array();
            foreach ($entries as $keyEntry => $entry){
                if($entry->course_type == 'App\Models\GeneralEducation\Course'){
                    $sections = Section::where('course_id',$entry->course_id)
                        ->where('active',true)->where('deleted_at',null)->get();
                    foreach ($sections as $keySection => $section){
                        $flTestStatus = DB::table('qs_student_first_last_test_status')
                            ->where('studentId',$student->id)
                            ->where('sectionId',$section->id)
                            ->where('sectionType','App\Models\GeneralEducation\Section')->get()->toArray();
                        if($flTestStatus != null and count($flTestStatus)>0){
                            $flTestStatus['course'] = Course::find($entry->course_id)->get();
                            $flTestStatus['section'] = $section;
                            array_push($usersFLTestStatus['ge'],$flTestStatus);
                        }
                    }
                }
                else if($entry->course_type == 'App\Models\PrepareLessons\Course'){
                    $sections = \App\Models\PrepareLessons\Section::where('course_id',$entry->course_id)
                        ->where('active',true)->where('deleted_at',null)->get();
                    foreach ($sections as $keySection => $section){
                        $flTestStatus = DB::table('qs_student_first_last_test_status')
                            ->where('studentId',$student->id)
                            ->where('sectionId',$section->id)
                            ->where('sectionType','App\Models\PrepareLessons\Section')->get()->toArray();
                        if($flTestStatus != null and count($flTestStatus)>0){
                            $flTestStatus['course'] = Course::find($entry->course_id)->get();
                            $flTestStatus['section'] = $section;
                            array_push($usersFLTestStatus['pl'],$flTestStatus);
                        }
                    }
                }
                else if($entry->course_type == 'App\Models\PrepareExams\Course'){
                    $sections = \App\Models\PrepareLessons\Section::where('course_id',$entry->course_id)
                        ->where('active',true)->where('deleted_at',null)->get();
                    foreach ($sections as $keySection => $section){
                        $flTestStatus = DB::table('qs_student_first_last_test_status')
                            ->where('studentId',$student->id)
                            ->where('sectionId',$section->id)
                            ->where('sectionType','App\Models\PrepareExams\Section')->get()->toArray();
                        if($flTestStatus != null and count($flTestStatus)>0){
                            $flTestStatus['course'] = Course::find($entry->course_id)->get();
                            $flTestStatus['section'] = $section;
                            array_push($usersFLTestStatus['pe'],$flTestStatus);
                        }
                    }
                }
            }

            $tempGe = array_chunk($usersFLTestStatus['ge'],10);
            $tempPl = array_chunk($usersFLTestStatus['pl'],10);
            $tempPe = array_chunk($usersFLTestStatus['pe'],10);

            $object = array();
            $object['ge'] = $tempGe;
            $object['pl'] = $tempPl;
            $object['pe'] = $tempPe;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getOneflTestInfo($userId,$otherId,$courseId,$courseType){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $student = Student::where('user_id',$otherId);
            $usersFLTestStatus = array();
            if($courseType == 1){
                $sections = Section::where('course_id',$courseId)
                    ->where('active',true)->where('deleted_at',null)->get();
                foreach ($sections as $keySection => $section){
                    $flTestStatus = DB::table('qs_student_first_last_test_status')
                        ->where('studentId',$student->id)
                        ->where('sectionId',$section->id)
                        ->where('sectionType','App\Models\GeneralEducation\Section')->get()->toArray();
                    if($flTestStatus != null and count($flTestStatus)>0){
                        $flTestStatus['course'] = Course::find($courseId)->get();
                        $flTestStatus['section'] = $section;
                        array_push($usersFLTestStatus,$flTestStatus);
                    }
                }
            }
            else if($courseType == 2){
                $sections = \App\Models\PrepareLessons\Section::where('course_id',$courseId)
                    ->where('active',true)->where('deleted_at',null)->get();
                foreach ($sections as $keySection => $section){
                    $flTestStatus = DB::table('qs_student_first_last_test_status')
                        ->where('studentId',$student->id)
                        ->where('sectionId',$section->id)
                        ->where('sectionType','App\Models\PrepareLessons\Section')->get()->toArray();
                    if($flTestStatus != null and count($flTestStatus)>0){
                        $flTestStatus['course'] = Course::find($courseId)->get();
                        $flTestStatus['section'] = $section;
                        array_push($usersFLTestStatus,$flTestStatus);
                    }
                }
            }
            else if($courseType == 3){
                $sections = \App\Models\PrepareLessons\Section::where('course_id',$courseId)
                    ->where('active',true)->where('deleted_at',null)->get();
                foreach ($sections as $keySection => $section){
                    $flTestStatus = DB::table('qs_student_first_last_test_status')
                        ->where('studentId',$student->id)
                        ->where('sectionId',$section->id)
                        ->where('sectionType','App\Models\PrepareExams\Section')->get()->toArray();
                    if($flTestStatus != null and count($flTestStatus)>0){
                        $flTestStatus['course'] = Course::find($courseId)->get();
                        $flTestStatus['section'] = $section;
                        array_push($usersFLTestStatus,$flTestStatus);
                    }
                }
            }

            $object = $usersFLTestStatus;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

}
