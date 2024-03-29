<?php


namespace App\Repositories\Curriculum;


use App\Models\Curriculum\Exam;
use App\Repositories\IRepository;
use App\Repositories\PrepareLessons\CurriculumRepository;
use App\Repositories\RepositoryResponse;

class ExamRepository implements IRepository{

    public function all()
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Exam::all();
            $repoCourse = new CurriculumRepository();
            foreach ($object as $key => $item){
                $resp = $repoCourse->showExamCourses($item->id);
                $data = $resp->getData();
                $object[$key]['courseCount'] = count($data->where('active',true)->where('deleted_at',null));
            }

        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function get($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Exam::find($id);
            $repoCourse = new CurriculumRepository();
            $resp = $repoCourse->showExamCourses($id);
            $data = $resp->getData();
            $object['courseCount'] = count($data->where('active',true)->where('deleted_at',null));
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
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
}
