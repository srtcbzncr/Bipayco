<?php


namespace App\Repositories\QuestionSource;


use App\Models\Auth\Instructor;
use App\Models\Auth\User;
use App\Models\Curriculum\Lesson;
use App\Models\Curriculum\Subject;
use App\Models\QuestionSource\GapFilling;
use App\Models\QuestionSource\Match;
use App\Models\QuestionSource\MultiChoice;
use App\Models\QuestionSource\Order;
use App\Models\QuestionSource\Question;
use App\Models\QuestionSource\SingleChoice;
use App\Models\QuestionSource\TrueFalse;
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
            $questions = Question::where('instructorId',$instructor->id)->get()->toArray();


            if(count($questions) > 0 and  count($questions) <= 10){
                // subject ve lesson bilgisinide getir
                $chunkArray = array_chunk($questions,10);
                foreach ($chunkArray as $keyChunk => $chunk){
                    foreach ($chunk as $keyQue => $question){
                        $subject = Subject::find($question['crSubjectId']);
                        $lesson = Lesson::find($question['crLessonId']);
                        $chunkArray[$keyChunk][$keyQue]['lesson'] = $lesson;
                        $chunkArray[$keyChunk][$keyQue]['subject'] = $subject;
                    }
                }
                $object = $chunkArray;
            }
            else if(count($questions) > 10){
                $chunkArray = array_chunk($questions,10);
                // subject ve lesson bilgisinide getir
                foreach ($chunkArray as $keyChunk => $chunk){
                    foreach ($chunk as $keyQue => $question){
                        $subject = Subject::find($question['crSubjectId']);
                        $lesson = Lesson::find($question['crLessonId']);
                        $chunkArray[$keyChunk][$keyQue]['lesson'] = $lesson;
                        $chunkArray[$keyChunk][$keyQue]['subject'] = $subject;
                    }
                }
                $object = $chunkArray;
            }
            else{
                $object = array();
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

    public function createSingle($data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = new Question();
            if(isset($data['text']) and $data['text']!=null){
                $object->text = $data['text'];
            }
            if(isset($data['imgUrl']) and file_exists($data['imgUrl'])){
                $path = $data['imgUrl']->store('public/questionSource');
                $accessPath=Storage::url($path);
                $object->imgUrl = $accessPath;
            }
            $object->level = $data['level'];
            $object->type = SingleChoice::class;
            $object->crLessonId = $data['crLessonId'];
            $object->crSubjectId = $data['crSubjectId'];
            $object->instructorId = $data['instructorId'];
            $object->isConfirm = false;
            $object->save();

            // add answers
            if(isset($data['answersContent']) and count($data['answersContent'])>0){
                foreach ($data['answers'] as $key=> $answer){
                    $jsonAnswer = json_decode($answer,true);
                    $single = new SingleChoice();
                    $single->questionId = $object->id;

                    $path = $data['answersContent'][$key]->store('public/questionSource');
                    $accessPath=Storage::url($path);
                    $single->content = $accessPath;

                    if(strval($jsonAnswer['isCorrect']) == 'true' or strval($jsonAnswer['isCorrect']) == '1')
                        $single->isTrue = true;
                    else
                        $single->isTrue = false;
                    $single->type = $jsonAnswer['type'];
                    $single->save();
                }
            }
            else{
                foreach ($data['answers'] as $answer){
                    $jsonAnswer = json_decode($answer,true);
                    $single = new SingleChoice();
                    $single->questionId = $object->id;
                    $single->content = $jsonAnswer['content'];
                    if(strval($jsonAnswer['isCorrect']) == 'true' or strval($jsonAnswer['isCorrect']) == '1')
                        $single->isTrue = true;
                    else
                        $single->isTrue = false;
                    $single->type = $jsonAnswer['type'];
                    $single->save();
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
    public function createMulti($data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = new Question();
            if(isset($data['text']) and $data['text']!=null){
                $object->text = $data['text'];
            }
            if(isset($data['imgUrl']) and file_exists($data['imgUrl'])){
                $path = $data['imgUrl']->store('public/questionSource');
                $accessPath=Storage::url($path);
                $object->imgUrl = $accessPath;
            }
            $object->level = $data['level'];
            $object->type = MultiChoice::class;
            $object->crLessonId = $data['crLessonId'];
            $object->crSubjectId = $data['crSubjectId'];
            $object->instructorId = $data['instructorId'];
            $object->isConfirm = false;
            $object->save();

            // add answers
            if(isset($data['answersContent']) and count($data['answersContent'])>0){
                foreach ($data['answers'] as $key=> $answer){
                    $jsonAnswer = json_decode($answer,true);
                    $single = new MultiChoice();
                    $single->questionId = $object->id;

                    $path = $data['answersContent'][$key]->store('public/questionSource');
                    $accessPath=Storage::url($path);
                    $single->content = $accessPath;

                    if(strval($jsonAnswer['isCorrect']) == 'true' or strval($jsonAnswer['isCorrect']) == '1')
                        $single->isTrue = true;
                    else
                        $single->isTrue = false;
                    $single->type = $jsonAnswer['type'];
                    $single->save();
                }
            }
            else{
                foreach ($data['answers'] as $answer){
                    $jsonAnswer = json_decode($answer,true);
                    $single = new MultiChoice();
                    $single->questionId = $object->id;
                    $single->content = $jsonAnswer['content'];
                    if(strval($jsonAnswer['isCorrect'])=='true' or strval($jsonAnswer['isCorrect']) == '1')
                        $single->isTrue = true;
                    else
                        $single->isTrue = false;
                    $single->type = $jsonAnswer['type'];
                    $single->save();
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
    public function createGap($data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = new Question();
            if(isset($data['beginningOfSentence']) and $data['beginningOfSentence']!=null){
                $object->text = $data['beginningOfSentence'];
            }
            if(isset($data['imgUrl']) and file_exists($data['imgUrl'])){
                $path = $data['imgUrl']->store('public/questionSource');
                $accessPath=Storage::url($path);
                $object->imgUrl = $accessPath;
            }
            $object->level = $data['level'];
            $object->type = GapFilling::class;
            $object->crLessonId = $data['crLessonId'];
            $object->crSubjectId = $data['crSubjectId'];
            $object->instructorId = $data['instructorId'];
            $object->isConfirm = false;
            $object->save();

            // add answers
            foreach ($data['answers'] as $key => $answer){
                $jsonAnswer = json_decode($answer,true);
                $single = new GapFilling();
                $single->questionId = $object->id;
                $single->content = $jsonAnswer['answer'];
                $single->after = $jsonAnswer['after'];
                $single->no = $key;
                $single->type = "text";
                $single->save();
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
    public function createTrueFalse($data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = new Question();
            if(isset($data['content']) and $data['content']!=null){
                $object->text = $data['content'];
            }
            if(isset($data['imgUrl']) and file_exists($data['imgUrl'])){
                $path = $data['imgUrl']->store('public/questionSource');
                $accessPath=Storage::url($path);
                $object->imgUrl = $accessPath;
            }
            $object->level = $data['level'];
            $object->type = TrueFalse::class;
            $object->crLessonId = $data['crLessonId'];
            $object->crSubjectId = $data['crSubjectId'];
            $object->instructorId = $data['instructorId'];
            $object->isConfirm = false;
            $object->save();

            // add answers
            $answer = new TrueFalse();
            $answer->questionId = $object->id;
            if(strval($data['isCorrect']) == '1' or strval($data['isCorrect']) == 'true'){
                $answer->content = true;
            }
            else{
                $answer->content = false;
            }
            $answer->save();
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function createMatch($data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = new Question();
            if(isset($data['text']) and $data['text']!=null){
                $object->text = $data['text'];
            }
            if(isset($data['imgUrl']) and file_exists($data['imgUrl'])){
                $path = $data['imgUrl']->store('public/questionSource');
                $accessPath=Storage::url($path);
                $object->imgUrl = $accessPath;
            }
            $object->level = $data['level'];
            $object->type = Match::class;
            $object->crLessonId = $data['crLessonId'];
            $object->crSubjectId = $data['crSubjectId'];
            $object->instructorId = $data['instructorId'];
            $object->isConfirm = false;
            $object->save();

            // add answers
            if(isset($data['answersContent']) and count($data['answersContent'])>0 and isset($data['answersAnswer']) and count($data['answersAnswer'])>0){
                foreach ($data['answers'] as $key=> $answer){
                    $jsonAnswer = json_decode($answer,true);
                    $match = new Match();
                    $match->questionId = $object->id;

                    $path = $data['answersContent'][$key]->store('public/questionSource');
                    $accessPath=Storage::url($path);
                    $match->content = $accessPath;

                    $path = $data['answersAnswer'][$key]->store('public/questionSource');
                    $accessPath=Storage::url($path);
                    $match->answer = $accessPath;

                    $match->type = $jsonAnswer['type'];
                    $match->save();
                }
            }
            else{
                foreach ($data['answers'] as $answer){
                    $jsonAnswer = json_decode($answer,true);
                    $match = new Match();
                    $match->questionId = $object->id;
                    $match->content = $jsonAnswer['first'];
                    $match->type = $jsonAnswer['type'];
                    $match->answer = $jsonAnswer['second'];
                    $match->save();
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
    public function createOrder($data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = new Question();
            if(isset($data['text']) and $data['text']!=null){
                $object->text = $data['text'];
            }
            if(isset($data['imgUrl']) and file_exists($data['imgUrl'])){
                $path = $data['imgUrl']->store('public/questionSource');
                $accessPath=Storage::url($path);
                $object->imgUrl = $accessPath;
            }
            $object->level = $data['level'];
            $object->type = Order::class;
            $object->crLessonId = $data['crLessonId'];
            $object->crSubjectId = $data['crSubjectId'];
            $object->instructorId = $data['instructorId'];
            $object->isConfirm = false;
            $object->save();

            // add answers
            foreach ($data['content'] as $key=> $content){
                $order = new Order();
                $order->questionId = $object->id;
                $order->content = $content;
                $order->no = $key;
                $order->save();
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

    public function updateSingle($id, $data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Question::find($id);
            $answers = SingleChoice::where('questionId',$id)->get();
            foreach ($answers as $answer){
                $temp = SingleChoice::find($answer->id);
                $temp->delete();
            }
            $object->delete();

            // yeni single sorusu oluştur.
            $object = new Question();
            if(isset($data['text']) and $data['text']!=null){
                $object->text = $data['text'];
            }
            if(isset($data['imgUrl']) and file_exists($data['imgUrl'])){
                $path = $data['imgUrl']->store('public/questionSource');
                $accessPath=Storage::url($path);
                $object->imgUrl = $accessPath;
            }
            else{
                if(isset($data['imgUrl']))
                    $object->imgUrl = $data['imgUrl'];
                else
                    $object->imgUrl = null;
            }
            $object->level = $data['level'];
            $object->type = SingleChoice::class;
            $object->crLessonId = $data['crLessonId'];
            $object->crSubjectId = $data['crSubjectId'];
            $object->instructorId = $data['instructorId'];
            $object->isConfirm = false;
            $object->save();

            // add answers
            if(isset($data['answersContent']) and count($data['answersContent'])>0){
                foreach ($data['answers'] as $key=> $answer){
                    $jsonAnswer = json_decode($answer,true);
                    $single = new SingleChoice();
                    $single->questionId = $object->id;

                    if(is_string($data['answersContent'][$key]) and !file_exists($data['answersContent'][$key])){
                        $single->content = $data['answersContent'][$key];
                    }
                    else{
                        $path = $data['answersContent'][$key]->store('public/questionSource');
                        $accessPath=Storage::url($path);
                        $single->content = $accessPath;
                    }

                    if(strval($jsonAnswer['isCorrect']) == 'true' or strval($jsonAnswer['isCorrect']) == '1')
                        $single->isTrue = true;
                    else
                        $single->isTrue = false;
                    $single->type = $jsonAnswer['type'];
                    $single->save();
                }
            }
            else{
                foreach ($data['answers'] as $answer){
                    $jsonAnswer = json_decode($answer,true);
                    $single = new SingleChoice();
                    $single->questionId = $object->id;
                    $single->content = $jsonAnswer['content'];
                    if(strval($jsonAnswer['isCorrect']) == 'true' or strval($jsonAnswer['isCorrect']) == '1')
                        $single->isTrue = true;
                    else
                        $single->isTrue = false;
                    $single->type = $jsonAnswer['type'];
                    $single->save();
                }
            }
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
    public function updateMulti($id,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();

            $object = Question::find($id);
            $answers = MultiChoice::where('questionId',$id)->get();
            foreach ($answers as $answer){
                $temp = SingleChoice::find($answer->id);
                $temp->delete();
            }
            $object->delete();

            // yeni soru oluştur.
            $object = new Question();
            if(isset($data['text']) and $data['text']!=null){
                $object->text = $data['text'];
            }
            if(isset($data['imgUrl']) and file_exists($data['imgUrl'])){
                $path = $data['imgUrl']->store('public/questionSource');
                $accessPath=Storage::url($path);
                $object->imgUrl = $accessPath;
            }
            else{
                if(isset($data['imgUrl'])){
                    $object->imgUrl = $data['imgUrl'];
                }
                else{
                    $object->imgUrl = null;
                }
            }

            $object->level = $data['level'];
            $object->type = MultiChoice::class;
            $object->crLessonId = $data['crLessonId'];
            $object->crSubjectId = $data['crSubjectId'];
            $object->instructorId = $data['instructorId'];
            $object->isConfirm = false;
            $object->save();

            // add answers
            if(isset($data['answersContent']) and count($data['answersContent'])>0){
                foreach ($data['answers'] as $key=> $answer){
                    $jsonAnswer = json_decode($answer,true);
                    $single = new MultiChoice();
                    $single->questionId = $object->id;

                    if(!is_string($data['answersContent'][$key]) and file_exists($data['answersContent'][$key])){
                        $path = $data['answersContent'][$key]->store('public/questionSource');
                        $accessPath=Storage::url($path);
                        $single->content = $accessPath;
                    }
                    else{
                        $single->content = $data['answersContent'][$key];
                    }

                    if(strval($jsonAnswer['isCorrect']) == 'true' or strval($jsonAnswer['isCorrect']) == '1')
                        $single->isTrue = true;
                    else
                        $single->isTrue = false;
                    $single->type = $jsonAnswer['type'];
                    $single->save();
                }
            }
            else{
                foreach ($data['answers'] as $answer){
                    $jsonAnswer = json_decode($answer,true);
                    $single = new MultiChoice();
                    $single->questionId = $object->id;
                    $single->content = $jsonAnswer['content'];
                    if(strval($jsonAnswer['isCorrect'])=='true' or strval($jsonAnswer['isCorrect']) == '1')
                        $single->isTrue = true;
                    else
                        $single->isTrue = false;
                    $single->type = $jsonAnswer['type'];
                    $single->save();
                }
            }

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
    public function updateGap($id,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Question::find($id);
            $answers = MultiChoice::where('questionId',$id)->get();
            foreach ($answers as $answer){
                $temp = SingleChoice::find($answer->id);
                $temp->delete();
            }
            $object->delete();

            // yeni soru oluştur.
            $object = new Question();
            if(isset($data['beginningOfSentence']) and $data['beginningOfSentence']!=null){
                $object->text = $data['beginningOfSentence'];
            }
            if(isset($data['imgUrl']) and file_exists($data['imgUrl'])){
                $path = $data['imgUrl']->store('public/questionSource');
                $accessPath=Storage::url($path);
                $object->imgUrl = $accessPath;
            }
            else{
                if(isset($data['imgUrl'])){
                    $object->imgUrl = $data['imgUrl'];
                }
                else{
                    $object->imgUrl = null;
                }
            }
            $object->level = $data['level'];
            $object->type = GapFilling::class;
            $object->crLessonId = $data['crLessonId'];
            $object->crSubjectId = $data['crSubjectId'];
            $object->instructorId = $data['instructorId'];
            $object->isConfirm = false;
            $object->save();

            // add answers
            foreach ($data['answers'] as $key => $answer){
                $jsonAnswer = json_decode($answer,true);
                $single = new GapFilling();
                $single->questionId = $object->id;
                $single->content = $jsonAnswer['answer'];
                $single->after = $jsonAnswer['after'];
                $single->no = $key;
                $single->type = "text";
                $single->save();
            }

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
    public function updateMatch($id,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Question::find($id);
            $answers = MultiChoice::where('questionId',$id)->get();
            foreach ($answers as $answer){
                $temp = SingleChoice::find($answer->id);
                $temp->delete();
            }
            $object->delete();

            // yeni soru oluştur.
            $object = new Question();
            if(isset($data['text']) and $data['text']!=null){
                $object->text = $data['text'];
            }
            if(isset($data['imgUrl']) and file_exists($data['imgUrl'])){
                $path = $data['imgUrl']->store('public/questionSource');
                $accessPath=Storage::url($path);
                $object->imgUrl = $accessPath;
            }
            else{
                if(isset($data['imgUrl'])){
                    $object->imgUrl = $data['imgUrl'];
                }
                else{
                    $object->imgUrl = null;
                }
            }

            $object->level = $data['level'];
            $object->type = Match::class;
            $object->crLessonId = $data['crLessonId'];
            $object->crSubjectId = $data['crSubjectId'];
            $object->instructorId = $data['instructorId'];
            $object->isConfirm = false;
            $object->save();

            // add answers
            if(isset($data['answersContent']) and count($data['answersContent'])>0 and isset($data['answersAnswer']) and count($data['answersAnswer'])>0){
                foreach ($data['answers'] as $key=> $answer){
                    $jsonAnswer = json_decode($answer,true);
                    $match = new Match();
                    $match->questionId = $object->id;

                    if(!is_string($data['answersContent'][$key]) and file_exists($data['answersContent'][$key])){
                        $path = $data['answersContent'][$key]->store('public/questionSource');
                        $accessPath=Storage::url($path);
                        $match->content = $accessPath;
                    }
                    else{
                        $match->content = $data['answersContent'][$key];
                    }

                    if(!is_string($data['answersAnswer'][$key]) and file_exists($data['answersAnswer'][$key])){
                        $path = $data['answersAnswer'][$key]->store('public/questionSource');
                        $accessPath=Storage::url($path);
                        $match->answer = $accessPath;
                    }
                    else{
                        $match->answer = $data['answersAnswer'][$key];
                    }

                    $match->type = $jsonAnswer['type'];
                    $match->save();
                }
            }
            else{
                foreach ($data['answers'] as $answer){
                    $jsonAnswer = json_decode($answer,true);
                    $match = new Match();
                    $match->questionId = $object->id;
                    $match->content = $jsonAnswer['first'];
                    $match->type = $jsonAnswer['type'];
                    $match->answer = $jsonAnswer['second'];
                    $match->save();
                }
            }

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
    public function updateOrder($id,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Question::find($id);
            $answers = MultiChoice::where('questionId',$id)->get();
            foreach ($answers as $answer){
                $temp = SingleChoice::find($answer->id);
                $temp->delete();
            }
            $object->delete();

            // yeni soru oluştur.
            $object = new Question();
            if(isset($data['text']) and $data['text']!=null){
                $object->text = $data['text'];
            }
            if(isset($data['imgUrl']) and file_exists($data['imgUrl'])){
                $path = $data['imgUrl']->store('public/questionSource');
                $accessPath=Storage::url($path);
                $object->imgUrl = $accessPath;
            }
            else{
                if(isset($data['imgUrl'])){
                    $object->imgUrl = $data['imgUrl'];
                }
                else{
                    $object->imgUrl = null;
                }
            }
            $object->level = $data['level'];
            $object->type = Order::class;
            $object->crLessonId = $data['crLessonId'];
            $object->crSubjectId = $data['crSubjectId'];
            $object->instructorId = $data['instructorId'];
            $object->isConfirm = false;
            $object->save();

            // add answers
            foreach ($data['content'] as $key=> $content){
                $order = new Order();
                $order->questionId = $object->id;
                $order->content = $content;
                $order->no = $key;
                $order->save();
            }

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

    public function getSingle($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Question::find($id);
            $object['type'] = "singleChoice";
            $answers = SingleChoice::where('questionId',$id)->get()->toArray();
            $object['answers'] = $answers;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function getMulti($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Question::find($id);
            $object['type'] = "multiChoice";
            $answers = MultiChoice::where('questionId',$id)->get()->toArray();
            $object['answers'] = $answers;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function getGap($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Question::find($id);
            $object['type'] = "fillBlank";
            $answers = GapFilling::where('questionId',$id)->get()->toArray();
            $object['answers'] = $answers;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function getTrueFalse($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Question::find($id);
            $object['type'] = "trueFalse";
            $answers = TrueFalse::where('questionId',$id)->get()->toArray();
            $object['answers'] = $answers;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function getMatch($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Question::find($id);
            $object['type'] = "match";
            $answers = Match::where('questionId',$id)->get()->toArray();
            $object['answers'] = $answers;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function getOrder($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Question::find($id);
            $object['type'] = "order";
            $answers = Order::where('questionId',$id)->get()->toArray();
            $object['answers'] = $answers;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function update($id, array $data)
    {
        // TODO: Implement update() method.
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
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
