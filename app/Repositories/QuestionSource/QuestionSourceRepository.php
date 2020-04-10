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
            $questions = Question::where('instructorId',$instructor->id)->get();

            // subject ve lesson bilgisinide getir
            foreach ($questions as $key=> $question){
                $subject = Subject::find($question->crSubjectId);
                $lesson = Lesson::find($question->crLessonId);
                $questions[$key]['lesson'] = $lesson;
                $questions[$key]['subject'] = $subject;
            }

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
            if($question->type == 'App\Models\QuestionSource\SingleChoice'){
                $question['type'] = "singleChoice";
                $answers = SingleChoice::where('questionId',$id)->get();
                $question['answers'] = $answers;
            }
            else if($question->type == 'App\Models\QuestionSource\GapFilling'){
                $question['type'] = "fillBlank";
                $answers = GapFilling::where('questionId',$id)->get();
                $question['answers'] = $answers;
            }
            else if($question->type == 'App\Models\QuestionSource\Match'){
                $question['type'] = "match";
                $answers = Match::where('questionId',$id)->get();
                $question['answers'] = $answers;
            }
            else if($question->type == 'App\Models\QuestionSource\MultiChoice') {
                $question['type'] = "multiChoice";
                $answers = MultiChoice::where('questionId',$id)->get();
                $question['answers'] = $answers;
            }
            else if($question->type == 'App\Models\QuestionSource\Order'){
                $question['type'] = "order";
                $answers = Order::where('questionId',$id)->get();
                $question['answers'] = $answers;
            }
            else if($question->type == 'App\Models\QuestionSource\TrueFalse'){
                $question['type'] = "trueFalse";
                $answers = TrueFalse::where('questionId',$id)->get();
                $question['answers'] = $answers;
            }

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
            if($data['type'] == 'singleChoice' or $data['type'] == 'multiChoice'){
                $control = false;
                if(isset($data['text']) or $data['text'] != null){
                    $object->text = $data['text'];
                    $control = true;
                }
                if(isset($data['imgUrl']) and $data['imgUrl'] != null and file_exists($data['imgUrl'])){
                    $path = $data['imgUrl']->store('public/questionSource');
                    $accessPath=Storage::url($path);
                    $object->imgUrl = $accessPath;
                    $control = true;
                }
                else{
                    $object->imgUrl = null;
                }

                if($control == false){
                    $sonuc = 1/0;
                }


                $object->level = $data['level'];
                if($data['type'] == 'singleChoice')
                    $object->type = 'App\Models\QuestionSource\SingleChoice';
                else if($data['type'] == 'multiChoice')
                    $object->type = 'App\Models\QuestionSource\MultiChoice';
                $object->crLessonId = $data['crLessonId'];
                $object->crSubjectId = $data['crSubjectId'];
                $object->instructorId = $data['instructorId'];
                $object->isConfirm = false;
                $object->save();

                $objectAnswer = null;
                if($data['type'] == 'singleChoice'){
                    $type = null;
                    if(explode(':',explode(',',$data['answers'][0])[1])[1]=="\"text\""){
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
                    else{
                        $i=0;
                        foreach ($data['answersContent'] as $key=> $answer){
                            if($key == count($data['answersContent'])-1){
                                $objectAnswer = new SingleChoice();
                                $objectAnswer->questionId = $object->id;
                                $path = $answer->store('public/questionSource');
                                $accessPath=Storage::url($path);
                                $objectAnswer->content = $accessPath;
                                $objectAnswer->isTrue = true;
                                $objectAnswer->type = explode('}',explode(':',explode(',',$data['answers'][$i])[2])[1])[0];
                                $objectAnswer->save();
                            }
                            else{
                                $objectAnswer = new SingleChoice();
                                $objectAnswer->questionId = $object->id;
                                $path = $answer->store('public/questionSource');
                                $accessPath=Storage::url($path);
                                $objectAnswer->content = $accessPath;
                                $objectAnswer->isTrue = false;
                                $objectAnswer->type = explode(':',explode(',',$data['answers'][$i])[1])[1];
                                $objectAnswer->save();
                            }
                            $i++;
                        }
                    }
                }
                else if($data['type'] == 'multiChoice'){
                    if(explode('}',explode(':',explode(',',$data['answers'][0])[2])[1])[0]=="\"text\""){
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
                    else{
                        $i=0;
                        foreach ($data['answersContent'] as $answer){
                            $objectAnswer = new MultiChoice();
                            $objectAnswer->questionId = $object->id;
                            $path = $answer->store('public/questionSource');
                            $accessPath=Storage::url($path);
                            $objectAnswer->content = $accessPath;
                            if(explode(':',explode(',',$data['answers'][$i])[1])[1] == "true")
                                $objectAnswer->isTrue = true;
                            else
                                $objectAnswer->isTrue = false;
                            $objectAnswer->type =  explode('}',explode(':',explode(',',$data['answers'][$i])[2])[1])[0];
                            $objectAnswer->save();
                            $i++;
                        }
                    }
                }
            }
            else if($data['type'] == 'fillBlank'){
                $control = false;
                if(isset($data['imgUrl']) and $data['imgUrl'] != null and file_exists($data['imgUrl'])){
                    $path = $data['imgUrl']->store('public/questionSource');
                    $accessPath=Storage::url($path);
                    $object->imgUrl = $accessPath;
                    $control = true;
                }
                if(isset($data['beginningOfSentence'])){
                    $object->text = $data['beginningOfSentence'];
                    $control = true;
                }

                if($control == false){
                    $sonuc = 1/0;
                }

                $object->level = $data['level'];
                $object->crLessonId = $data['crLessonId'];
                $object->crSubjectId = $data['crSubjectId'];
                $object->instructorId = $data['instructorId'];
                $object->type = 'App\Models\QuestionSource\GapFilling';
                $object->isConfirm = false;
                $object->save();

                // answer'ları tabloya ekle.
                if($data['type'] == 'fillBlank'){
                    $totalQuestion = null;
                    foreach ($data['answers'] as $key => $answer){
                        $objectAnswer = new GapFilling();
                        $objectAnswer->questionId = $object->id;
                        $objectAnswer->no = $key;
                        $objectAnswer->content = $answer;
                        $objectAnswer->type = "\"text\"";
                        $objectAnswer->save();
                    }
                }
            }
            else if($data['type'] == 'trueFalse'){
                $control = false;
                if(isset($data['imgUrl']) and $data['imgUrl']!=null and file_exists($data['imgUrl'])){
                    $path = $data['imgUrl']->store('public/questionSource');
                    $accessPath=Storage::url($path);
                    $object->imgUrl = $accessPath;
                    $control = true;
                }
                if(isset($data['content']) and $data['content']!=null){
                    $object->text = $data['content'];
                    $control = true;
                }

                if($control == false){
                    $sonuc = 1/0;
                }

                $object->level = $data['level'];
                $object->type = 'App\Models\QuestionSource\TrueFalse';
                $object->crLessonId = $data['crLessonId'];
                $object->crSubjectId = $data['crSubjectId'];
                $object->instructorId = $data['instructorId'];
                $object->isConfirm = false;
                $object->save();

                // answer ekle.
                $objectAnswer = new TrueFalse();
                $objectAnswer->questionId = $object->id;
                $objectAnswer->content = $data['isCorrect'];
                $objectAnswer->save();
            }
            else if($data['type'] == 'order'){
                $control = false;
                if(isset($data['imgUrl']) and $data['imgUrl']!=null and file_exists($data['imgUrl'])){
                    $path = $data['imgUrl']->store('public/questionSource');
                    $accessPath=Storage::url($path);
                    $object->imgUrl = $accessPath;
                    $control = true;
                }
                if(isset($data['content']) and $data['content']!=null){
                    $object->text = $data['text'];
                    $control = true;
                }

                if($control == false){
                    $sonuc = 1/0;
                }

                $object->level = $data['level'];
                $object->type = 'App\Models\QuestionSource\Order';
                $object->crLessonId = $data['crLessonId'];
                $object->crSubjectId = $data['crSubjectId'];
                $object->instructorId = $data['instructorId'];
                $object->isConfirm = false;
                $object->save();

                // answers ekle
                foreach ($data['content'] as $key=> $item){
                    $objectAnswer = new Order();
                    $objectAnswer->questionId = $object->id;
                    $objectAnswer->content = $item;
                    $objectAnswer->no = $key;
                    $objectAnswer->save();
                }
            }
            else if($data['type'] == 'match'){
                $control = false;
                if(isset($data['imgUrl']) and $data['imgUrl']!=null and file_exists($data['imgUrl'])){
                    $path = $data['imgUrl']->store('public/questionSource');
                    $accessPath=Storage::url($path);
                    $object->imgUrl = $accessPath;
                    $control = true;
                }
                if(isset($data['text']) and $data['text']!=null){
                    $object->text = $data['text'];
                    $control = true;
                }

                if($control == false){
                   $sonuc = 1/0;
                }

                $object->level = $data['level'];
                $object->type = 'App\Models\QuestionSource\Match';
                $object->crLessonId = $data['crLessonId'];
                $object->crSubjectId = $data['crSubjectId'];
                $object->instructorId = $data['instructorId'];
                $object->isConfirm = false;
                $object->save();

                // add answers
                $type=null;
                $i=0;
                foreach ($data['answers'] as $answers){
                    $keyler= array_keys($answers);
                    foreach ($keyler as $index => $key){
                        if($key == '\'type\''){
                           foreach ($answers as $answer){
                                if($i==$index){
                                    $type=$answer;
                                    break;
                                }
                                else{
                                    $i++;
                                }
                           }
                            break;
                        }
                    }
                    break;
                }
                $i=0;
                foreach ($data['answers'] as $answers){
                    $objectAnswer = new Match();
                    if($type=="text"){
                        foreach ($answers as $answer){
                            $objectAnswer->questionId = $object->id;
                            $objectAnswer->type = $type;
                            if($i==0){
                                $objectAnswer->content = $answer;
                            }
                            else if($i==1) {
                                $objectAnswer->answer = $answer;
                            }
                            $i++;
                        }
                        $i=0;
                        $objectAnswer->save();
                    }
                    else{
                        foreach ($answers as $answer){
                            $objectAnswer->questionId = $object->id;
                            $objectAnswer->type = $type;
                            if($i==1){
                                $filePath = $answer->store('public/questionSource');
                                $accessPath=Storage::url($filePath);
                                $objectAnswer->content = $accessPath;
                            }
                            else if($i==2) {
                                $filePath = $answer->store('public/questionSource');
                                $accessPath=Storage::url($filePath);
                                $objectAnswer->answer = $accessPath;
                            }
                            $i++;
                        }
                        $i=0;
                        $objectAnswer->save();
                    }
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
            // var olan soruyu ve cevapları sil
            $findedQue = Question::find($id);
            if($findedQue->type == "App\Models\QuestionSource\SingleChoice"){
                $findedAns = SingleChoice::where('questionId',$id)->get();
                foreach ($findedAns as $item){
                    $temp = SingleChoice::find($item->id);
                    $temp->delete();
                }
                $findedQue->delete();
            }
            else if($findedQue->type == "App\Models\QuestionSource\MultiChoice"){
                $findedAns = MultiChoice::where('questionId',$id)->get();
                foreach ($findedAns as $item){
                    $temp = MultiChoice::find($item->id);
                    $temp->delete();
                }
                $findedQue->delete();
            }
            else if($findedQue->type == "App\Models\QuestionSource\GapFilling"){
                $findedAns = GapFilling::where('questionId',$id)->get();
                foreach ($findedAns as $item){
                    $temp = GapFilling::find($item->id);
                    $temp->delete();
                }
                $findedQue->delete();
            }
            else if($findedQue->type == "App\Models\QuestionSource\Order"){
                $findedAns = Order::where('questionId',$id)->get();
                foreach ($findedAns as $item){
                    $temp = Order::find($item->id);
                    $temp->delete();
                }
                $findedQue->delete();
            }
            else if($findedQue->type == "App\Models\QuestionSource\TrueFalse"){
                $findedAns = TrueFalse::where('questionId',$id)->get();
                foreach ($findedAns as $item){
                    $temp = TrueFalse::find($item->id);
                    $temp->delete();
                }
                $findedQue->delete();
            }
            else if($findedQue->type == "App\Models\QuestionSource\Match"){
                $findedAns = Match::where('questionId',$id)->get();
                foreach ($findedAns as $item){
                    $temp = Match::find($item->id);
                    $temp->delete();
                }
                $findedQue->delete();
            }

            // yeni soru ve cevapları ekle.
            $object = new Question();
            if($data['type'] == 'singleChoice' or $data['type'] == 'multiChoice'){
                $control = false;
                if(isset($data['text']) or $data['text'] != null){
                    $object->text = $data['text'];
                    $control = true;
                }
                if(isset($data['imgUrl']) and $data['imgUrl'] != null and file_exists($data['imgUrl'])){
                    $path = $data['imgUrl']->store('public/questionSource');
                    $accessPath=Storage::url($path);
                    $object->imgUrl = $accessPath;
                    $control = true;
                }
                else{
                    $object->imgUrl = null;
                }

                if($control == false){
                    $sonuc = 1/0;
                }


                $object->level = $data['level'];
                if($data['type'] == 'singleChoice')
                    $object->type = 'App\Models\QuestionSource\SingleChoice';
                else if($data['type'] == 'multiChoice')
                    $object->type = 'App\Models\QuestionSource\MultiChoice';
                $object->crLessonId = $data['crLessonId'];
                $object->crSubjectId = $data['crSubjectId'];
                $object->instructorId = $data['instructorId'];
                $object->isConfirm = false;
                $object->save();

                $objectAnswer = null;
                if($data['type'] == 'singleChoice'){
                    $type = null;
                    if(explode(':',explode(',',$data['answers'][0])[1])[1]=="\"text\""){
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
                    else{
                        $i=0;
                        foreach ($data['answersContent'] as $key=> $answer){
                            if($key == count($data['answersContent'])-1){
                                $objectAnswer = new SingleChoice();
                                $objectAnswer->questionId = $object->id;
                                $path = $answer->store('public/questionSource');
                                $accessPath=Storage::url($path);
                                $objectAnswer->content = $accessPath;
                                $objectAnswer->isTrue = true;
                                $objectAnswer->type = explode('}',explode(':',explode(',',$data['answers'][$i])[2])[1])[0];
                                $objectAnswer->save();
                            }
                            else{
                                $objectAnswer = new SingleChoice();
                                $objectAnswer->questionId = $object->id;
                                $path = $answer->store('public/questionSource');
                                $accessPath=Storage::url($path);
                                $objectAnswer->content = $accessPath;
                                $objectAnswer->isTrue = false;
                                $objectAnswer->type = explode(':',explode(',',$data['answers'][$i])[1])[1];
                                $objectAnswer->save();
                            }
                            $i++;
                        }
                    }
                }
                else if($data['type'] == 'multiChoice'){
                    if(explode('}',explode(':',explode(',',$data['answers'][0])[2])[1])[0]=="\"text\""){
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
                    else{
                        $i=0;
                        foreach ($data['answersContent'] as $answer){
                            $objectAnswer = new MultiChoice();
                            $objectAnswer->questionId = $object->id;
                            $path = $answer->store('public/questionSource');
                            $accessPath=Storage::url($path);
                            $objectAnswer->content = $accessPath;
                            if(explode(':',explode(',',$data['answers'][$i])[1])[1] == "true")
                                $objectAnswer->isTrue = true;
                            else
                                $objectAnswer->isTrue = false;
                            $objectAnswer->type =  explode('}',explode(':',explode(',',$data['answers'][$i])[2])[1])[0];
                            $objectAnswer->save();
                            $i++;
                        }
                    }
                }
            }
            else if($data['type'] == 'fillBlank'){
                $control = false;
                if(isset($data['imgUrl']) and $data['imgUrl'] != null and file_exists($data['imgUrl'])){
                    $path = $data['imgUrl']->store('public/questionSource');
                    $accessPath=Storage::url($path);
                    $object->imgUrl = $accessPath;
                    $control = true;
                }
                if(isset($data['beginningOfSentence'])){
                    $object->text = $data['beginningOfSentence'];
                    $control = true;
                }

                if($control == false){
                    $sonuc = 1/0;
                }

                $object->level = $data['level'];
                $object->crLessonId = $data['crLessonId'];
                $object->crSubjectId = $data['crSubjectId'];
                $object->instructorId = $data['instructorId'];
                $object->type = 'App\Models\QuestionSource\GapFilling';
                $object->isConfirm = false;
                $object->save();

                // answer'ları tabloya ekle.
                if($data['type'] == 'fillBlank'){
                    $totalQuestion = null;
                    foreach ($data['answers'] as $key => $answer){
                        $objectAnswer = new GapFilling();
                        $objectAnswer->questionId = $object->id;
                        $objectAnswer->no = $key;
                        $objectAnswer->content = $answer;
                        $objectAnswer->type = "\"text\"";
                        $objectAnswer->save();
                    }
                }
            }
            else if($data['type'] == 'trueFalse'){
                $control = false;
                if(isset($data['imgUrl']) and $data['imgUrl']!=null and file_exists($data['imgUrl'])){
                    $path = $data['imgUrl']->store('public/questionSource');
                    $accessPath=Storage::url($path);
                    $object->imgUrl = $accessPath;
                    $control = true;
                }
                if(isset($data['content']) and $data['content']!=null){
                    $object->text = $data['content'];
                    $control = true;
                }

                if($control == false){
                    $sonuc = 1/0;
                }

                $object->level = $data['level'];
                $object->type = 'App\Models\QuestionSource\TrueFalse';
                $object->crLessonId = $data['crLessonId'];
                $object->crSubjectId = $data['crSubjectId'];
                $object->instructorId = $data['instructorId'];
                $object->isConfirm = false;
                $object->save();

                // answer ekle.
                $objectAnswer = new TrueFalse();
                $objectAnswer->questionId = $object->id;
                $objectAnswer->content = $data['isCorrect'];
                $objectAnswer->save();
            }
            else if($data['type'] == 'order'){
                $control = false;
                if(isset($data['imgUrl']) and $data['imgUrl']!=null and file_exists($data['imgUrl'])){
                    $path = $data['imgUrl']->store('public/questionSource');
                    $accessPath=Storage::url($path);
                    $object->imgUrl = $accessPath;
                    $control = true;
                }
                if(isset($data['content']) and $data['content']!=null){
                    $object->text = $data['text'];
                    $control = true;
                }

                if($control == false){
                    $sonuc = 1/0;
                }

                $object->level = $data['level'];
                $object->type = 'App\Models\QuestionSource\Order';
                $object->crLessonId = $data['crLessonId'];
                $object->crSubjectId = $data['crSubjectId'];
                $object->instructorId = $data['instructorId'];
                $object->isConfirm = false;
                $object->save();

                // answers ekle
                foreach ($data['content'] as $key=> $item){
                    $objectAnswer = new Order();
                    $objectAnswer->questionId = $object->id;
                    $objectAnswer->content = $item;
                    $objectAnswer->no = $key;
                    $objectAnswer->save();
                }
            }
            else if($data['type'] == 'match'){
                $control = false;
                if(isset($data['imgUrl']) and $data['imgUrl']!=null and file_exists($data['imgUrl'])){
                    $path = $data['imgUrl']->store('public/questionSource');
                    $accessPath=Storage::url($path);
                    $object->imgUrl = $accessPath;
                    $control = true;
                }
                if(isset($data['text']) and $data['text']!=null){
                    $object->text = $data['text'];
                    $control = true;
                }

                if($control == false){
                    $sonuc = 1/0;
                }

                $object->level = $data['level'];
                $object->type = 'App\Models\QuestionSource\Match';
                $object->crLessonId = $data['crLessonId'];
                $object->crSubjectId = $data['crSubjectId'];
                $object->instructorId = $data['instructorId'];
                $object->isConfirm = false;
                $object->save();

                // add answers
                $type=null;
                $i=0;
                foreach ($data['answers'] as $answers){
                    $keyler= array_keys($answers);
                    foreach ($keyler as $index => $key){
                        if($key == '\'type\''){
                            foreach ($answers as $answer){
                                if($i==$index){
                                    $type=$answer;
                                    break;
                                }
                                else{
                                    $i++;
                                }
                            }
                            break;
                        }
                    }
                    break;
                }
                $i=0;
                foreach ($data['answers'] as $answers){
                    $objectAnswer = new Match();
                    if($type=="text"){
                        foreach ($answers as $answer){
                            $objectAnswer->questionId = $object->id;
                            $objectAnswer->type = $type;
                            if($i==0){
                                $objectAnswer->content = $answer;
                            }
                            else if($i==1) {
                                $objectAnswer->answer = $answer;
                            }
                            $i++;
                        }
                        $i=0;
                        $objectAnswer->save();
                    }
                    else{
                        foreach ($answers as $answer){
                            $objectAnswer->questionId = $object->id;
                            $objectAnswer->type = $type;
                            if($i==1){
                                $filePath = $answer->store('public/questionSource');
                                $accessPath=Storage::url($filePath);
                                $objectAnswer->content = $accessPath;
                            }
                            else if($i==2) {
                                $filePath = $answer->store('public/questionSource');
                                $accessPath=Storage::url($filePath);
                                $objectAnswer->answer = $accessPath;
                            }
                            $i++;
                        }
                        $i=0;
                        $objectAnswer->save();
                    }
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
