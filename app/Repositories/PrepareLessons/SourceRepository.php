<?php


namespace App\Repositories\PrepareLessons;


use App\Models\GeneralEducation\Source;
use App\Models\PrepareLessons\Lesson;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;

class SourceRepository implements IRepository
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
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $lesson = Lesson::find($id);
            $sources = $lesson->sources;
            foreach ($sources as $source){
                $source->active = true;
                $source->save();
            }
            $resp_sources = Source::where('lesson_id',$lesson->id)->where('deleted_at',null)->where('lesson_type','App\Models\PrepareLessons\Lesson')->where('active',true)->get();
            $object = $resp_sources;
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function setPassive($id)
    {
        // TODO: Implement setPassive() method.
    }
}
