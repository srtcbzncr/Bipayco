<?php


namespace App\Repositories\QuestionSource\Student;


use App\Models\Auth\Student;
use App\Models\PrepareLessons\Course;
use App\Models\PrepareLessons\Section;
use App\Models\QuestionSource\Student\FirstLastTestStatus;
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
            $userId = Auth::id();
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
            if($data['sectionType'] == "prepareLessons"){
                $section = Section::find($data['sectionId']);
                $course = Course::find($section->course_id);
                if($data['score'] >= $course->score){
                    $object->result = true;
                }
                else{
                    $object->result = false;
                }
            }
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

    public function calculateSingle($data){

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
