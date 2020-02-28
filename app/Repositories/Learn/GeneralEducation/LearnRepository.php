<?php


namespace App\Repositories\Learn\GeneralEducation;


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

    public function getSources($course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        try{
            DB::beginTransaction();


            $sections = Section::where('course_id',$course_id)->where('active',true)->orderBy('no','asc')->get();
            $object['sections'] = $sections;
            foreach ($sections as  $sectionKey => $section){
                $lessons = Lesson::where('section_id',$section->id)->where('active',true)->orderBy('no','asc')->get();
                $object['sections'][$sectionKey]['lessons'] = $lessons;
                foreach ($lessons as $lessonKey => $lesson){
                    $sources = Source::where('lesson_id',$lesson->id)->where('active',true)->get();
                    $object['sections'][$sectionKey]['lessons'][$lessonKey]['sources'] = $sources;
                }
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

    public function getDiscussion($lesson_id){
        // initialization
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations

        try{
            DB::beginTransaction();

            $questions = Question::where('lesson_id',$lesson_id)->get();
            $object['questions'] = $questions;
            foreach ($questions as $key => $question){
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

            $user = auth('api')->user();
            $question = new Question();
            $question->lesson_id = $lesson_id;
            $question->lesson_type = 'App\Models\GeneralEducation\Course';
            $question->user_id = $user->id;
            $question->title = $data->title;
            $question->content = $data->content;
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

