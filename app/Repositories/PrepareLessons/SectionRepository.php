<?php

namespace App\Repositories\PrepareLessons;

use App\Models\PrepareLessons\Lesson;
use App\Models\PrepareLessons\Section;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;

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
            $object->subject_id = $data['subjectId'];
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
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Section::find($id);
            $object->name = $data['name'];
            $object->save();
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
            $section = Section::find($id);
            $lessons = Lesson::where('section_id',$id);
            foreach ($lessons as $lesson){
                $lesson->sources()->delete();
                $lesson->sources()->delete();
                $lesson->sources()->questions();
                $lesson->sources()->completed();
                $lesson->delete();
            }
            $section->delete();
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


    public function sectionUpdate($course_id,$sectionId,$data){

    }
}
