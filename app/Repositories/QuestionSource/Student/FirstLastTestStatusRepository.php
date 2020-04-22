<?php


namespace App\Repositories\QuestionSource\Student;


use App\Models\Auth\Student;
use App\Models\PrepareLessons\Course;
use App\Models\PrepareLessons\Lesson;
use App\Models\PrepareLessons\Section;
use App\Models\QuestionSource\GapFilling;
use App\Models\QuestionSource\MultiChoice;
use App\Models\QuestionSource\Order;
use App\Models\QuestionSource\Question;
use App\Models\QuestionSource\SingleChoice;
use App\Models\QuestionSource\Student\FirstLastTestAnswers;
use App\Models\QuestionSource\Student\FirstLastTestStatus;
use App\Models\QuestionSource\TrueFalse;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FirstLastTestStatusRepository implements IRepository
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
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $userId = $data['userId'];
            $student = Student::where('user_id',$userId)->first();

            // var olan eski status verilerini sil
            $sectionType = null;
            if($data['sectionType'] == "prepareLessons"){
                $sectionType = Section::class;
            }
            $flTestStatus = FirstLastTestStatus::where('studentId',$student->id)
                ->where('sectionId',$data['sectionId'])
                ->where('sectionType',$sectionType)
                ->where('testType',$data['testType'])->first();
            if($flTestStatus!=null)
                $flTestStatus->delete();

            // yeni status verilerini ekle
            $object = new FirstLastTestStatus();
            $object->studentId = $student->id;
            $object->sectionId = $data['sectionId'];
            $object->sectionType = $sectionType;
            $object->testType = $data['testType'];

            // calculate result
            $correctCount = 0;
            foreach ($data['answers'] as $answer){
                $que = Question::find($answer['questionId']);
                if($que->type == "App\Models\QuestionSource\SingleChoice"){
                    if($this->calculateSingle($student->id,$answer)){
                        $correctCount++;
                    }
                }
                else if($que->type == "App\Models\QuestionSource\MultiChoice"){
                    if($this->calculateMulti($student->id,$answer)){
                        $correctCount++;
                    }
                }
                else if($que->type == "App\Models\QuestionSource\GapFilling"){
                    if($this->calculateGap($student->id,$answer)){
                        $correctCount++;
                    }
                }
                else if($que->type == "App\Models\QuestionSource\TrueFalse"){
                    if($this->calculateTrueFalse($student->id,$answer)){
                        $correctCount++;
                    }
                }
                else if($que->type == "App\Models\QuestionSource\Match"){
                    if($this->calculateMatch($student->id,$answer)){
                        $correctCount++;
                    }
                }
                else if($que->type == "App\Models\QuestionSource\Order"){
                    if($this->calculateOrder($student->id,$answer)){
                        $correctCount++;
                    }
                }
            }

            $point = ($correctCount/count($data['answers']))*100;
            $point = intval($point);

            if($data['sectionType'] == "prepareLessons"){
                $section = Section::find($data['sectionId']);
                $course = Course::find($section->course_id);
                if($point >= $course->score){
                    $object->result = true;
                }
                else{
                    $object->result = false;
                }
                $object->score = $point;
            }
            $object->save();

            // bir sonraki lesson id'yi gönder(eğer varsa ve bu test geçilmişş)
            if($point >= $course->score){
                $nextSection= null;
                $nextLessonId = null;
                $section = Section::find($data['sectionId']);
                $sections = Section::where('course_id',$section->course_id)->where('active',true)->orderBy('no', 'asc')->get()->toArray();
                foreach ($sections as $key => $item){
                    if($item['id'] == $section->id){
                        if(isset($sections[$key+1])){
                            $nextSection = $sections[$key+1];
                        }
                        break;
                    }
                }
                if($nextSection!=null){
                    $lessons = Lesson::where('section_id',$nextSection->id)->where('active',true)->orderBy('no', 'asc')->get()->toArray();
                    $nextLessonId = $lessons[0]['id'];
                }
            }
            $object['nextLessonId'] = $nextLessonId;
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

    public function calculateSingle($studentId,$data){
        $isCorrect = false;
        $control = SingleChoice::find($data['answer']);
        if($control->isTrue == true)
            $isCorrect = true;
        else
            $isCorrect = false;
        // flTestAnswer tablosuna ekle
        $flTestAnswer = new FirstLastTestAnswers();
        $flTestAnswer->result = $isCorrect;
        $flTestAnswer->questionId = $data['questionId'];
        $flTestAnswer->studentId = $studentId;
        $flTestAnswer->save();
        return $isCorrect;
    }
    public function calculateMulti($studentId,$data){
        $isCorrect = false;

        $dbAnswers = MultiChoice::where('questionId',$data['questionId'])->get()->toArray();
        $correctAnswers = array();
        foreach ($dbAnswers as $key => $answer){
            if($answer['isTrue'] == true)
                $correctAnswers[$key] = $answer['id'];
        }
        if(count($correctAnswers) == count($data['answer'])){
            foreach ($data['answer'] as $item){
                $isCorrect = false;
                foreach ($correctAnswers as $answer){
                    if($answer == $item){
                        $isCorrect = true;
                        break;
                    }
                }
                if($isCorrect == false){
                    break;
                }
            }
        }
        else{
            $isCorrect  = false;
        }
        // flTestAnswer tablosuna ekle
        $flTestAnswer = new FirstLastTestAnswers();
        $flTestAnswer->result = $isCorrect;
        $flTestAnswer->questionId = $data['questionId'];
        $flTestAnswer->studentId = $studentId;
        $flTestAnswer->save();
        return $isCorrect;
    }
    public function calculateGap($studentId,$data){
        $isCorrect = false;
        $answers = GapFilling::where('questionId',$data['questionId'])->get()->toArray();
        foreach ($answers as $key => $answer){
            if($data['answer'][$key]['content'] == null or $answer['content'] != $data['answer'][$key]['content']){
                $isCorrect = false;
                break;
            }
            else{
                $isCorrect = true;
            }
        }
        // flTestAnswer tablosuna ekle
        $flTestAnswer = new FirstLastTestAnswers();
        $flTestAnswer->result = $isCorrect;
        $flTestAnswer->questionId = $data['questionId'];
        $flTestAnswer->studentId = $studentId;
        $flTestAnswer->save();
        return $isCorrect;
    }
    public function calculateTrueFalse($studentId,$data){
        $isTrue = false;
        $answer = TrueFalse::where('questionId',$data['questionId'])->get()->toArray();
        // 1 tane veri dönecek herzaman yinede foreach'e yazdım
        foreach ($answer as $item){
            if($item['content'] == $data['answer']){
                $isTrue = true;
            }
        }
        // flTestAnswer tablosuna ekle
        $flTestAnswer = new FirstLastTestAnswers();
        $flTestAnswer->result = $isTrue;
        $flTestAnswer->questionId = $data['questionId'];
        $flTestAnswer->studentId = $studentId;
        $flTestAnswer->save();
        return $isTrue;
    }
    public function calculateMatch($studentId,$data){
        $isCorrect = false;
        foreach ($data['answer'] as $item){
            if($item['id'] != null and $item['id'] == $item['content']['id']){
                $isCorrect = true;
            }
            else{
                $isCorrect = false;
                break;
            }
        }
        // flTestAnswer tablosuna ekle
        $flTestAnswer = new FirstLastTestAnswers();
        $flTestAnswer->result = $isCorrect;
        $flTestAnswer->questionId = $data['questionId'];
        $flTestAnswer->studentId = $studentId;
        $flTestAnswer->save();
        return $isCorrect;
    }
    public function calculateOrder($studentId,$data){
        $isCorrect = false;
        $numaralar = array();
        foreach ($data['answer'] as $key => $item){
            $temp = Order::find($item);
            $numaralar[$key] = $temp->no;
        }
        foreach ($numaralar as $key => $numara){
            if(isset($numaralar[$key+1])){
                if($numara < $numaralar[$key+1]){
                    $isCorrect = true;
                }
                else{
                    $isCorrect = false;
                    break;
                }
            }

        }
        // flTestAnswer tablosuna ekle
        $flTestAnswer = new FirstLastTestAnswers();
        $flTestAnswer->result = $isCorrect;
        $flTestAnswer->questionId = $data['questionId'];
        $flTestAnswer->studentId = $studentId;
        $flTestAnswer->save();
        return $isCorrect;
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
}
