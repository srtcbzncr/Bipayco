<?php


namespace App\Repositories\QuestionSource;


use App\Models\Auth\Instructor;
use App\Models\Auth\User;
use App\Models\QuestionSource\GapFilling;
use App\Models\QuestionSource\MultiChoice;
use App\Models\QuestionSource\Question;
use App\Models\QuestionSource\SingleChoice;
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
            else if($data['type'] == 'multiChoice')
                $object->type = 'App\Models\QuestionSource\MultiChoice';
            else if($data['type'] == 'fillBlank'){
                $totalQuestion = null;
                foreach ($data['answers'] as $key => $answer){
                    $totalQuestion+="_"+explode(':',explode(',',$answer)[0])[1];
                }

            }
            $object->crLessonId = $data['crLessonId'];
            $object->crSubjectId = $data['crSubjectId'];
            $object->instructorId = $data['instructorId'];
            $object->isConfirm = false;
            $object->save();

            // answer'ları tabloya ekle.
            $objectAnswer = null;
            if($data['type'] == 'singleChoice'){
                $type = null;
                foreach ($data['answers'] as $key=> $answer){
                    if($key == count($data['answers'])-1){
                        $objectAnswer = new SingleChoice();
                        $objectAnswer->questionId = $object->id;
                        $objectAnswer->content = explode(':',explode(',',$answer)[0])[1];
                        $objectAnswer->isTrue = true;
                        $objectAnswer->type = $type;
                        $objectAnswer->save();
                    }
                    else{
                        $type = explode(':',explode(',',$answer)[1])[1];
                        $objectAnswer = new SingleChoice();
                        $objectAnswer->questionId = $object->id;
                        $objectAnswer->content = explode(':',explode(',',$answer)[0])[1];
                        $objectAnswer->isTrue = explode(':',explode(',',$answer)[2])[1];
                        $objectAnswer->type = explode(':',explode(',',$answer)[1])[1];
                        $objectAnswer->save();
                    }
                }
            }
            else if($data['type'] == 'multiChoice'){
                foreach ($data['answers'] as $answer){
                    $objectAnswer = new MultiChoice();
                    $objectAnswer->questionId = $object->id;
                    $objectAnswer->content = explode(':',explode(',',$answer)[0])[1];
                    if(explode(':',explode(',',$answer)[1])[1] == "true")
                        $objectAnswer->isTrue = true;
                    else
                        $objectAnswer->isTrue = false;
                    $objectAnswer->type = explode('}',explode(':',explode(',',$answer)[2])[1])[0];
                    $objectAnswer->save();
                }
            }
            else if($data['type'] == 'fillBlank'){
                $totalQuestion = null;
                foreach ($data['answers'] as $key => $answer){
                    $objectAnswer = new GapFilling();
                    $objectAnswer->questionId = $object->id;
                    $objectAnswer->no = $key;
                    $objectAnswer->content = explode(':',explode(',',$answer)[0])[0];
                    $totalQuestion+="_"+explode(':',explode(',',$answer)[0])[1];
                    $objectAnswer->type = "text";
                    $objectAnswer->save();
                }
            }

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
