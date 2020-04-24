<?php


namespace App\Repositories\PrepareLessons;


use App\Models\Curriculum\Grade;
use App\Models\Curriculum\Lesson;
use App\Models\Curriculum\Subject;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;

class CurriculumRepository implements IRepository
{

    public function all()
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object['grade'] = Grade::all();
            $object['lesson'] = Lesson::all();
            $object['subject'] = Subject::all();
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

    public function showLessonCourses($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $lesson = Lesson::find($id);
            $object = $lesson->courses->where('active',true);
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
}
