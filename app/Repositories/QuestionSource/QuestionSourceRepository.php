<?php


namespace App\Repositories\QuestionSource;


use App\Models\Auth\Instructor;
use App\Models\Auth\User;
use App\Models\QuestionSource\Question;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class QuestionSourceRepository implements IRepository
{

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function get($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $user = User::find($id);
            $instructor = Instructor::where('user_id',$user->id)->first();
            $questions = Question::where('instructorId',$instructor->id)->get();
            $object = $questions;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function getQuestion($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $question = Question::find($id);
            $object = $question;
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
            DB::beginTransaction();
            $object = new Question();
            if(isset($data['text']))
                $object->text = $data['text'];
            if(isset($data['img_url'])){
                $path = $data['questionImage']->store('public\questionSource');
                $accessPath=Storage::url($path);
                $object->imgUrl = $accessPath;
            }
            $object->level = $data['level'];
            if($data['type'] == 'singleChoice')
                $object->type = 'App\Models\QuestionSource\SingleChoice';
            $object->crLessonId = $data['crLessonId'];
            $object->crSubjectId = $data['crSubjectId'];
            $object->instructorId = $data['instructorId'];
            $object->isConfirm = false;
            DB::commit();
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
            DB::rollBack();
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
            DB::beginTransaction();
            $object = Question::find($id);
            if(isset($data['text']))
                $object->text = $data['text'];
            if(isset($data['img_url'])){
                $path = $data['questionImage']->store('public\questionSource');
                $accessPath=Storage::url($path);
                $object->imgUrl = $accessPath;
            }
            $object->level = $data['level'];
            if($data['type'] == 'singleChoice')
                $object->type = 'App\Models\QuestionSource\SingleChoice';
            $object->crLessonId = $data['crLessonId'];
            $object->crSubjectId = $data['crSubjectId'];
            $object->instructorId = $data['instructorId'];
            $object->isConfirm = false;
            DB::commit();
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
            DB::rollBack();
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
            DB::beginTransaction();
            $question = Question::find($id);
            $question->delete();
            DB::commit();
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
            DB::rollBack();
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
}
