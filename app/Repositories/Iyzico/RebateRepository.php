<?php


namespace App\Repositories\Iyzico;


use App\Models\Auth\Student;
use App\Models\GeneralEducation\Lesson;
use App\Models\GeneralEducation\Section;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;

class RebateRepository implements IRepository
{

    public function all()
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
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
        // iade oluşturacağız
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            // coursun iade olabilme şartını kontrol et.
            $user_id = $data['user_id']
            $student = Student::where('user_id',$user_id)->first();
            $sections = Section::where('course_id',$course_id)->where('deleted_at',null)->where('active',true)->get()->toArray();

            $lessons = array();
            foreach ($sections as $section){
                $tempLessons = Lesson::where('section_id',$section['id'])->where('deleted_at',null)->where('active',true)->get()->toArray();
                foreach ($tempLessons as $lesson){
                    array_push($lessons,$lesson);
                }

            }

            // tamamlanmış dersleri al
            $completedLessons = DB::table('ge_students_completed_lessons')
                ->where('student_id',$student->id)
                ->where('lesson_type','App\Models\GeneralEducation\Lesson')->get();
            $completeCount = 0;
            foreach ($lessons as $lesson){
                foreach ($completedLessons as $completedLessonn){
                    if($lesson['id'] == $completedLessonn->lesson_id){;
                        $completeCount = $completeCount + 1;
                        break;
                    }
                }
            }

            $progress = 0;
            $progress = ($completeCount/count($lessons))*100;
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
