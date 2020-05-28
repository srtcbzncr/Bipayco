<?php


namespace App\Repositories\Learn\QuestionAnswer;


use App\Models\Auth\Instructor;
use App\Models\Auth\User;
use App\Models\GeneralEducation\Answer;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Lesson;
use App\Models\GeneralEducation\Question;
use App\Models\GeneralEducation\Section;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;

class QuestionAnswerRepository implements IRepository
{

    public function all()
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

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
        // TODO: Implement get() method.
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update($id, array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function setActive($id)
    {
        // TODO: Implement setActive() method.
    }

    public function setPassive($id)
    {
        // TODO: Implement setPassive() method.
    }

    public function getNotAnsweredQuestions($userId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        try{
            $instructor = Instructor::where('user_id',$userId)->where('active',true)->where('deleted_at',null)->first();
            $object = DB::table('ge_courses_instructors')->where('instructor_id',$instructor->id)
                ->where('active',true)->where('deleted_at',null)->get(); // şu anda elimde eğitmenin kursları var.
            $notAnsweredQuestions = array();
            foreach ($object as $keyCourse => $item){
                if($item->course_type == 'App\Models\GeneralEducation\Course'){
                    $course = Course::find($item->course_id);
                    //$object[$keyCourse] = $course;

                    $sections = Section::where('course_id',$course->id)->where('active',true)->where('deleted_at',null)->get();
                    foreach ($sections as $keySection => $section){
                        //$object[$keyCourse]['sections'][$keySection] = $section;

                        $lessons = Lesson::where('section_id',$section->id)->where('active',true)->where('deleted_at',null)->get();
                        foreach ($lessons as $keyLesson => $lesson){ // şu an eğitmenenin her bir kursunun dersleri elimde
                           // $object[$keyCourse]['sections'][$keySection]['lessons'][$keyLesson] = $lesson;

                            $questions = Question::where('lesson_id',$lesson->id)->where('lesson_type','App\Models\GeneralEducation\Lesson')
                                ->where('active',true)->where('deleted_at',null)->get();
                            foreach ($questions as $keyQue => $question){
                                $answer = Answer::where('question_id',$question->id)->where('active',true)->where('deleted_at',null)->get();
                                if($answer!=null and count($answer)>0){
                                    // cevap verilmiş bir sorudur.
                                }
                                else{

                                    // cevap verilmemiş bir sorudur.
                                   // $object[$keyCourse]['sections'][$keySection]['lessons'][$keyLesson]['questions'][$keyQue] = $question;
                                    $user = User::find($question->user_id);
                                    //$object[$keyCourse]['sections'][$keySection]['lessons'][$keyLesson]['questions'][$keyQue]['user'] = $user;

                                    $tempQuestion = $question;
                                    $tempQuestion['user'] = $user;
                                    $tempQuestion['course'] = $course;
                                    $tempQuestion['section'] = $section;
                                    $tempQuestion['lesson'] = $lesson;
                                    array_push($notAnsweredQuestions,$tempQuestion);
                                }

                            }
                        }
                    }

                }
                else if($item->course_type == 'App\Models\PrepareLessons\Course'){
                    $course = \App\Models\PrepareLessons\Course::find($item->course_id);
                    //$object[$keyCourse] = $course;

                    $sections = \App\Models\PrepareLessons\Section::where('course_id',$course->id)->where('active',true)->where('deleted_at',null)->get();
                    foreach ($sections as $keySection => $section){
                        //$object[$keyCourse]['sections'][$keySection] = $section;

                        $lessons = \App\Models\PrepareLessons\Lesson::where('section_id',$section->id)->where('active',true)->where('deleted_at',null)->get();
                        foreach ($lessons as $keyLesson => $lesson){ // şu an eğitmenenin her bir kursunun dersleri elimde
                            //$object[$keyCourse]['sections'][$keySection]['lessons'][$keyLesson] = $lesson;

                            $questions = Question::where('lesson_id',$lesson->id)->where('lesson_type','App\Models\PrepareLessons\Lesson')
                                ->where('active',true)->where('deleted_at',null)->get();
                            foreach ($questions as $keyQue => $question){
                                $answer = Answer::where('question_id',$question->id)->where('active',true)->where('deleted_at',null)->get();
                                if($answer!=null and count($answer)>0){
                                    // cevap verilmiş bir sorudur.
                                }
                                else{

                                    // cevap verilmemiş bir sorudur.
                                    //$object[$keyCourse]['sections'][$keySection]['lessons'][$keyLesson]['questions'][$keyQue] = $question;
                                    $user = User::find($question->user_id);
                                    //$object[$keyCourse]['sections'][$keySection]['lessons'][$keyLesson]['questions'][$keyQue]['user'] = $user;
                                    $tempQuestion = $question;
                                    $tempQuestion['user'] = $user;
                                    $tempQuestion['course'] = $course;
                                    $tempQuestion['section'] = $section;
                                    $tempQuestion['lesson'] = $lesson;
                                    array_push($notAnsweredQuestions,$tempQuestion);
                                }

                            }
                        }
                    }
                }
                else if($item->course_type == 'App\Models\PrepareExams\Course'){
                    $course = \App\Models\PrepareExams\Course::find($item->course_id);
                    //$object[$keyCourse] = $course;

                    $sections = \App\Models\PrepareExams\Section::where('course_id',$course->id)->where('active',true)->where('deleted_at',null)->get();
                    foreach ($sections as $keySection => $section){
                        //$object[$keyCourse]['sections'][$keySection] = $section;

                        $lessons = \App\Models\PrepareExams\Lesson::where('section_id',$section->id)->where('active',true)->where('deleted_at',null)->get();
                        foreach ($lessons as $keyLesson => $lesson){ // şu an eğitmenenin her bir kursunun dersleri elimde
                           // $object[$keyCourse]['sections'][$keySection]['lessons'][$keyLesson] = $lesson;

                            $questions = Question::where('lesson_id',$lesson->id)->where('lesson_type','App\Models\PrepareExams\Lesson')
                                ->where('active',true)->where('deleted_at',null)->get();
                            foreach ($questions as $keyQue => $question){
                                $answer = Answer::where('question_id',$question->id)->where('active',true)->where('deleted_at',null)->get();
                                if($answer!=null and count($answer)>0){
                                    // cevap verilmiş bir sorudur.
                                }
                                else{

                                    // cevap verilmemiş bir sorudur.
                                  //  $object[$keyCourse]['sections'][$keySection]['lessons'][$keyLesson]['questions'][$keyQue] = $question;
                                    $user = User::find($question->user_id);
                                    //$object[$keyCourse]['sections'][$keySection]['lessons'][$keyLesson]['questions'][$keyQue]['user'] = $user;

                                    $tempQuestion = $question;
                                    $tempQuestion['user'] = $user;
                                    $tempQuestion['course'] = $course;
                                    $tempQuestion['section'] = $section;
                                    $tempQuestion['lesson'] = $lesson;
                                    array_push($notAnsweredQuestions,$tempQuestion);
                                }

                            }
                        }
                    }
                }
            }

            $arrchunk = array_chunk($notAnsweredQuestions,10);
            $object = $arrchunk;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getAnsweredQuestions($userId){
// Response variables
        $result = true;
        $error = null;
        $object = null;

        try{
            $instructor = Instructor::where('user_id',$userId)->where('active',true)->where('deleted_at',null)->first();
            $object = DB::table('ge_courses_instructors')->where('instructor_id',$instructor->id)
                ->where('active',true)->where('deleted_at',null)->paginate(10); // şu anda elimde eğitmenin kursları var.
            foreach ($object as $keyCourse => $item){
                if($item->course_type == 'App\Models\GeneralEducation\Course'){
                    $course = Course::find($item->course_id);
                    $object[$keyCourse] = $course;

                    $sections = Section::where('course_id',$course->id)->where('active',true)->where('deleted_at',null)->get();
                    foreach ($sections as $keySection => $section){
                        $object[$keyCourse]['sections'][$keySection] = $section;

                        $lessons = Lesson::where('section_id',$section->id)->where('active',true)->where('deleted_at',null)->get();
                        foreach ($lessons as $keyLesson => $lesson){ // şu an eğitmenenin her bir kursunun dersleri elimde
                            $object[$keyCourse]['sections'][$keySection]['lessons'][$keyLesson] = $lesson;

                            $questions = Question::where('lesson_id',$lesson->id)->where('lesson_type','App\Models\GeneralEducation\Lesson')
                                ->where('active',true)->where('deleted_at',null)->get();
                            foreach ($questions as $keyQue => $question){
                                $answer = Answer::where('question_id',$question->id)->where('active',true)->where('deleted_at',null)->get();
                                if($answer!=null and count($answer)>0){
                                    // cevap verilmiş bir sorudur.
                                    $object[$keyCourse]['sections'][$keySection]['lessons'][$keyLesson]['questions'][$keyQue] = $question;
                                    foreach ($answer as $ansKey => $itemAns){
                                        $object[$keyCourse]['sections'][$keySection]['lessons'][$keyLesson]['questions'][$keyQue]['answers'][$ansKey] = $itemAns;
                                    }
                                }
                                else{

                                    // cevap verilmemiş bir sorudur.
                                }

                            }
                        }
                    }

                }
                else if($item->course_type == 'App\Models\PrepareLessons\Course'){
                    $course = \App\Models\PrepareLessons\Course::find($item->course_id);
                    $object[$keyCourse] = $course;

                    $sections = \App\Models\PrepareLessons\Section::where('course_id',$course->id)->where('active',true)->where('deleted_at',null)->get();
                    foreach ($sections as $keySection => $section){
                        $object[$keyCourse]['sections'][$keySection] = $section;

                        $lessons = \App\Models\PrepareLessons\Lesson::where('section_id',$section->id)->where('active',true)->where('deleted_at',null)->get();
                        foreach ($lessons as $keyLesson => $lesson){ // şu an eğitmenenin her bir kursunun dersleri elimde
                            $object[$keyCourse]['sections'][$keySection]['lessons'][$keyLesson] = $lesson;

                            $questions = Question::where('lesson_id',$lesson->id)->where('lesson_type','App\Models\PrepareLessons\Lesson')
                                ->where('active',true)->where('deleted_at',null)->get();
                            foreach ($questions as $keyQue => $question){
                                $answer = Answer::where('question_id',$question->id)->where('active',true)->where('deleted_at',null)->get();
                                if($answer!=null and count($answer)>0){
                                    // cevap verilmiş bir sorudur.
                                    $object[$keyCourse]['sections'][$keySection]['lessons'][$keyLesson]['questions'][$keyQue] = $question;
                                    foreach ($answer as $ansKey => $itemAns){
                                        $object[$keyCourse]['sections'][$keySection]['lessons'][$keyLesson]['questions'][$keyQue]['answers'][$ansKey] = $itemAns;
                                    }
                                }
                                else{

                                    // cevap verilmemiş bir sorudur.
                                }

                            }
                        }
                    }
                }
                else if($item->course_type == 'App\Models\PrepareExams\Course'){
                    $course = \App\Models\PrepareExams\Course::find($item->course_id);
                    $object[$keyCourse] = $course;

                    $sections = \App\Models\PrepareExams\Section::where('course_id',$course->id)->where('active',true)->where('deleted_at',null)->get();
                    foreach ($sections as $keySection => $section){
                        $object[$keyCourse]['sections'][$keySection] = $section;

                        $lessons = \App\Models\PrepareExams\Lesson::where('section_id',$section->id)->where('active',true)->where('deleted_at',null)->get();
                        foreach ($lessons as $keyLesson => $lesson){ // şu an eğitmenenin her bir kursunun dersleri elimde
                            $object[$keyCourse]['sections'][$keySection]['lessons'][$keyLesson] = $lesson;

                            $questions = Question::where('lesson_id',$lesson->id)->where('lesson_type','App\Models\PrepareExams\Lesson')
                                ->where('active',true)->where('deleted_at',null)->get();
                            foreach ($questions as $keyQue => $question){
                                $answer = Answer::where('question_id',$question->id)->where('active',true)->where('deleted_at',null)->get();
                                if($answer!=null and count($answer)>0){
                                    // cevap verilmiş bir sorudur.
                                    $object[$keyCourse]['sections'][$keySection]['lessons'][$keyLesson]['questions'][$keyQue] = $question;
                                    foreach ($answer as $ansKey => $itemAns){
                                        $object[$keyCourse]['sections'][$keySection]['lessons'][$keyLesson]['questions'][$keyQue]['answers'][$ansKey] = $itemAns;
                                    }
                                }
                                else{

                                    // cevap verilmemiş bir sorudur.
                                }

                            }
                        }
                    }
                }
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

    public function deleteAnswer($answerId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        try{
            DB::beginTransaction();
            $object = Answer::find($answerId);
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

    public function updateAnswer($answerId,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        try{
            DB::beginTransaction();
            $object = Answer::find($answerId);
            $object->content  = $data['content'];
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
}
