<?php


namespace App\Repositories\Learn\GeneralEducation;


use App\Models\Auth\User;
use App\Models\GeneralEducation\Answer;
use App\Models\GeneralEducation\Lesson;
use App\Models\GeneralEducation\Question;
use App\Models\GeneralEducation\Section;
use App\Models\GeneralEducation\Source;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
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

    public function getCourse($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        try{
            DB::beginTransaction();

            $object = array();
            $sections = Section::where('course_id',$id)->where('active',true)->orderBy('no','asc')->get();
            $object['sections'] = $sections;
            foreach ($sections as $key => $section){
                $lessons = Lesson::where('section_id',$section->id)->where('active',true)->orderBy('no','asc')->get();
                $object['sections'][$key]['lessons'] = $lessons;
            }

            DB::commit();
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getLesson($lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        try{
            DB::beginTransaction();

            $lesson = Lesson::find($lesson_id);
            $object = $lesson;

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
            $error = $e;
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

