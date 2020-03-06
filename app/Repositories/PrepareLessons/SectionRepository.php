<?php

namespace App\Repositories\PrepareLessons;

use App\Models\PrepareLessons\Section;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;

class SectionRepository implements IRepository{

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
            $object = new Section;
            $sections = Section::where('course_id',$data['courseId'])->orderBy('no','asc')->get();
            $last_section = null;
            foreach ($sections as $item){
                $last_section = $item;
            }
            $object->course_id = $data['courseId'];
            if($last_section !=null)
                $object->no = $last_section->no+1;
            else
                $object->no = 1;
            $object->name = $data['name'];
            $object->active = true;
            $object->save();
        }
        catch(\Exception $e){
            $error = $e;
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
