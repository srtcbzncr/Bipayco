<?php


namespace App\Repositories\Learn\GeneralEducation;


use App\Models\Auth\Student;
use App\Models\Auth\User;
use App\Models\GeneralEducation\Answer;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Lesson;
use App\Models\GeneralEducation\Question;
use App\Models\GeneralEducation\Section;
use App\Models\GeneralEducation\Source;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LearnRepository implements IRepository
{

    public function all()
    {
        // TODO: Implement all() method.
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

    public function getCourse($id,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        try{
            DB::beginTransaction();

            $course = Course::find($id);
            $student = Student::where('user_id',$user_id)->first();
            $sections = Section::where('course_id',$id)->where('active',true)->orderBy('no','asc')->get();

            // sections,lessons ve source verileri
            $object = $course;
            $object['sections'] = $sections;
            foreach ($sections as $key => $section){
                $lessons = Lesson::where('section_id',$section->id)->where('active',true)->orderBy('no','asc')->get();
                $object['sections'][$key]['lessons'] = $lessons;
                foreach ($lessons as $keyLesson => $lesson){
                    $sources = $lesson->sources;
                    $object['sections'][$key]['lessons'][$keyLesson]['sources'] = $sources;
                    $control = DB::table("ge_students_completed_lessons")->where('student_id',$student->id)->where('lesson_id',$lesson->id)
                        ->where('lesson_type','App\Models\GeneralEducation\Lesson')->first();
                    if($control == null){
                        $object['sections'][$key]['lessons'][$keyLesson]['is_completed'] = false;
                    }
                    else{
                        $object['sections'][$key]['lessons'][$keyLesson]['is_completed'] = true;
                    }
                }
            }


            // tamamlanmamış ilk dersi al.Bir sonraki dersi getir.
            # 1. derslerin hepsinin tamamlanıp tamamlanmadığını kontrol et.
            # 2. Eğer hepsi tamamlanmışsa ilk dersi selected olarak göster
            # 3. Eğer tamamlanmayan varsa o tamamlanmayan ilk dersi selected olarak göster.
            foreach ($sections as $keySection=>$section){
                $lessons = null;
                $lessons = Lesson::where('section_id',$section->id)->where('active',true)->orderBy('no','asc')->get();
                $flag = false;
                $notCompletedLesson = null;
                $nextLesson = null;
                foreach ($lessons as $keyLesson=>$lesson){
                    $control = DB::table('ge_students_completed_lessons')
                        ->where('student_id',$student->id)
                        ->where('lesson_id',$lesson->id)
                        ->where('lesson_type','App\Models\GeneralEducation\Lesson')->get();
                    if($control == null or count($control)==0){
                        $flag = true;
                        $notCompletedLesson = $lesson;
                        if($keyLesson+1 <= count($lessons)-1){
                            $nextLesson = $lessons[$keyLesson+1];
                        }
                        else if($keySection+1 <= count($sections)-1){
                            if(isset($sections[$keySection+1]['lessons'][0])){
                                $nextLesson = $sections[$keySection+1]['lessons'][0];
                            }
                            else{
                                $nextLesson = null;
                            }
                        }
                        else{
                            $nextLesson = null;
                        }
                        break;
                    }
                }
                if($flag == true){
                    $object['selectedLesson'] = $notCompletedLesson;
                    if($nextLesson!=null)
                        $object['nextLessonId'] = $nextLesson->id;
                    else
                        $object['nextLessonId'] = null;
                    $object['selectedLesson']['is_completed'] = false;
                    $sources = null;
                    $sources = Source::where('lesson_id',$object['selectedLesson']->id)->where('lesson_type','App\Models\GeneralEducation\Lesson')->where('active',true)->get();
                    $object['selectedLesson']['sources'] = $sources;
                    break;
                }
                else if($keySection == count($sections)-1){
                    $object['selectedLesson'] = $sections[0]['lessons'][0];
                    $object['selectedLesson']['is_completed'] = true;
                    $sources = null;
                    $sources = Source::where('lesson_id',$object['selectedLesson']->id)->where('lesson_type','App\Models\GeneralEducation\Lesson')->where('active',true)->get();
                    $object['selectedLesson']['sources'] = $sources;
                    if(isset($sections[0]['lessons'][1])){
                        $object['nextLessonId'] = $sections[0]['lessons'][1]->id;
                    }
                    else{
                        if(isset($sections[1]['lessons'][0])){
                            $object['nextLessonId'] = $sections[1]['lessons'][0]->id;
                        }
                        else
                            $object['nextLessonId'] = null;
                    }
                }
            }

            DB::commit();
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getLesson($course_id,$lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        try{

            $user_id = Auth::user()->id;
            $course = Course::find($course_id);
            $student = Student::where('user_id',$user_id)->first();
            $sections = Section::where('course_id',$course_id)->where('active',true)->orderBy('no','asc')->get();

            // course,sections,lesson ve source verileri
            $object = $course;
            $object['sections'] = $sections;
            foreach ($sections as $key => $section){
                $lessons = Lesson::where('section_id',$section->id)->where('active',true)->orderBy('no','asc')->get();
                $object['sections'][$key]['lessons'] = $lessons;
                foreach ($lessons as $keyLesson => $lesson){
                    $sources = $lesson->sources;
                    $object['sections'][$key]['lessons'][$keyLesson]['sources'] = $sources;
                    $control = DB::table("ge_students_completed_lessons")->where('student_id',$student->id)->where('lesson_id',$lesson->id)
                        ->where('lesson_type','App\Models\GeneralEducation\Lesson')->first();
                    if($control == null){
                        $object['sections'][$key]['lessons'][$keyLesson]['is_completed'] = false;
                    }
                    else{
                        $object['sections'][$key]['lessons'][$keyLesson]['is_completed'] = true;
                    }
                }
            }

            // selected ve bir sonraki lesson dersleri
            $selectedLesson = Lesson::find($lesson_id);
            $object['selectedLesson'] = $selectedLesson;
            $control = DB::table("ge_students_completed_lessons")->where('student_id',$student->id)->where('lesson_id',$selectedLesson->id)
                ->where('lesson_type','App\Models\GeneralEducation\Lesson')->first();
            if($control == null){
                $object['selectedLesson']['is_completed'] = false;
            }
            else{
                $object['selectedLesson']['is_completed'] = true;
            }
            $sources = $lesson->sources;
            $object['selectedLesson']['sources'] = $sources;

            $nextLesson = null;
            $flag = false;
            foreach ($sections as $keySection => $section){
                $lessons = null;
                $lessons = Lesson::where('section_id',$section->id)->where('active',true)->orderBy('no','asc')->get();
                foreach ($lessons as $keyLesson=> $lesson){
                    if($lesson->id == $selectedLesson->id){
                        if($keyLesson+1 <= count($lessons)-1){
                            $nextLesson = $lessons[$keyLesson+1];
                            $flag = true;
                            break;
                        }
                        else if($keySection+1 <= count($sections)-1){
                            $nextLesson = $sections[$keySection+1]['lessons'][0];
                            $flag = true;
                            break;
                        }
                    }
                }
                if($flag == true){
                    break;
                }
            }
            if($nextLesson != null)
                $object['nextLessonId'] = $nextLesson->id;
            else
                $object['nextLessonId'] = null;
        }
        catch (\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getSources($lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        try{
            DB::beginTransaction();

            $lesson = Lesson::find($lesson_id);
            $sources = $lesson->sources;
            $object = $sources;

            DB::commit();
        }
        catch (\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getDiscussion($lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();

            $questions = Question::where('lesson_id',$lesson_id)->where('lesson_type','App\Models\GeneralEducation\Lesson')->get();
            $object['questions'] = $questions;
            // 10'ar 10'ar bölme işlemi yapmamız gerekiyor.
            if(count($questions) > 10){
                $myQuestions = array();
                $counter = 0;
                $index = 0;
                foreach ($questions as $key => $item){
                    $myQuestions[$index][$counter] = $item;
                    $counter++;
                    if($counter == 10){
                        $counter = 0;
                        $index++;
                    }
                }
                $object['questions'] = $myQuestions;
                foreach ($myQuestions as $key1=> $item){
                    foreach ($item as $key2 => $value){
                        $user = User::find($value->user_id);
                        $object['questions'][$key1][$key2]['user'] = $user;
                        $answers = $value->answers;
                        $object['questions'][$key1][$key2]['answers'] = $answers;
                    }
                }
            }
            else{
                $object['questions'] = array();
                foreach ($questions as $key => $question){
                    $object['questions'][0][$key]['question'] = $question;
                    $user = User::find($question->user_id);
                    $object['questions'][0][$key]['user'] = $user;
                    $answers = $question->answers;
                    $object['questions'][0][$key]['answers'] = $answers;
                }
            }
            //
            /*$object['questions'] = $questions;
            foreach ($questions as $key => $question){
                $user = User::find($question->user_id);
                $object['questions'][$key]['user'] = $user;
                $answers = $question->answers;
                $object['questions'][$key]['answers'] = $answers;
            }*/

            DB::commit();
        }
        catch (\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function next($lesson_id,$lastLessonId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();

            $myQuestions = Question::where('lesson_id',$lesson_id)->get();
            $index = 0;
            foreach ($myQuestions as $question){
                $index++;
                if($question->lesson_id == $lastLessonId){
                    break;
                }
            }
            $questions = array();
            $arrayIndex = 0;
            for ($i=$index;$i<$index+10;$i++){
                if(isset($myQuestions[$i]))
                    $questions[$arrayIndex] = $myQuestions[$i];
            }

            $object['questions'] = $questions;
            foreach ($questions as $key => $question){
                $user = User::find($question->user_id);
                $object['questions'][$key]['user'] = $user;
                $answers = $question->answers;
                $object['questions'][$key]['answers'] = $answers;
            }

            DB::commit();
        }
        catch (\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function back($lesson_id,$firstLessonId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();

            $myQuestions = Question::where('lesson_id',$lesson_id)->get();
            $index = 0;
            foreach ($myQuestions as $question){
                $index++;
                if($question->lesson_id == $firstLessonId){
                    break;
                }
            }
            $questions = array();
            $arrayIndex = 0;
            for ($i=$index-1;$i>=$index-10;$i--){
                if(isset($myQuestions[$i]))
                    $questions[$arrayIndex] = $myQuestions[$i];
            }

            $object['questions'] = $questions;
            foreach ($questions as $key => $question){
                $user = User::find($question->user_id);
                $object['questions'][$key]['user'] = $user;
                $answers = $question->answers;
                $object['questions'][$key]['answers'] = $answers;
            }

            DB::commit();
        }
        catch (\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function askQuestion($lesson_id,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations

        try{
            DB::beginTransaction();

            $question = new Question();
            $question->lesson_id = $lesson_id;
            $question->lesson_type = 'App\Models\GeneralEducation\Lesson';
            $question->user_id = $data['userId'];
            $question->title = $data['title'];
            $question->content = $data['content'];
            $question->save();

            DB::commit();
        }
        catch (\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function answerQuestion($question_id,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations

        try{
            DB::beginTransaction();

            $user = auth('api')->user();
            $answer = new Answer();
            $answer->question_id = $question_id;
            $answer->user_id = $user->id;
            $answer->content = $data->content;
            $answer->save();

            DB::commit();
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

