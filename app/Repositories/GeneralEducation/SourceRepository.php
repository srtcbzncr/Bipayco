<?php

namespace App\Repositories\GeneralEducation;

use App\Models\GeneralEducation\Lesson;
use App\Models\GeneralEducation\Source;
use App\Repositories\RepositoryResponse;
use App\Repositories\IRepository;use Illuminate\Support\Facades\DB;use Illuminate\Support\Facades\Storage;

class SourceRepository implements IRepository{

    public function all()
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Source::all();
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
            $object = Source::find($id);
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
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $sources = explode(',',$data['source']);
            foreach ($sources as $source){
                $filePath = Storage::putFile('sources', $source);
                $object = new Source;
                $object->lesson_id = $data['lesson']->id;
                $object->lesson_type = get_class($data['lesson']);
                $object->title = $data['title'];
                $object->file_path = $filePath;
                $object->save();
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

    public function update($id, array $data)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Source::find($id);
            $object->title = $data['title'];
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

    public function updateFile($id, array $data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $filePath = Storage::putFile('sources', $data['file']);
            $object = Source::find($id);
            Storage::delete($object->file_path);
            $object->file_path = $filePath;
            $object->save();
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e;
            $result = false;
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
            $object = Source::find($id);
            $object->active = false;
            //Storage::delete($object->file_path);
            //$object->delete();
            $object->save();
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function setActive($lesson_id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $lesson = Lesson::find($lesson_id);
            $sources = $lesson->sources;
            foreach ($sources as $source){
                $source->active = true;
                $source->save();
            }
            $resp_sources = Source::where('lesson_id',$lesson->id)->where('lesson_type','App\Models\GeneralEducation\Lesson')->where('active',true)->get();
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
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Source::find($id);
            $object->active = false;
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

    public function getLesson($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $source = Source::find($id);
            $object = $source->lesson;
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
}
