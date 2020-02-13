<?php

namespace App\Repositories\GeneralEducation;

use App\Events\GeneralEducation\ChangeLessonStatus;
use App\Models\GeneralEducation\Source;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use App\Models\GeneralEducation\Lesson;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Pbmedia\LaravelFFMpeg\FFMpegFacade as FFMpeg;

class LessonRepository implements IRepository{

    public function all()
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Lesson::all();
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
            $object = Lesson::find($id);
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
            DB::beginTransaction();
            $filePath = Storage::putFile('lessons', $data['document']);
            $media=FFMpeg::open($filePath);
            $long=$media->getDurationInSeconds();
            $object = new Lesson;
            $object->section_id = $data['section_id'];
            $object->is_video = $data['is_video'];
            $object->no = 1;
            $object->name = $data['name'];
            $object->long = $long;
            $object->preview = $data['is_preview'];
            $object->file_path = $filePath;
            $object->save();

            // add sources
            $lessons = Lesson::where('section_id',$data['section_id'])->get();
            $lesson = null;
            foreach ($lessons as $item){
                $lesson = $item;
            }
            foreach ($data['sources'] as $source){
                $filePath = Storage::putFile('sources', $source);
                $newSource = new Source;
                $newSource->lesson_id = $lesson->id;
                $newSource->lesson_type = get_class($lesson);
                $newSource->title = $source->getClientOriginalName();
                $newSource->file_path = $filePath;
                $newSource->save();
            }

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

    public function update($id, array $data)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Lesson::find($id);
            $object->section_id = $data['section_id'];
            $object->no = 1;
            $object->file_path = $data['file_path'];
            $object->name = $data['name'];
            $object->preview = $data['is_preview'];
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

    public function updateFile($id, array $data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $fileExtension = $data['file']->extension();
            $is_video = true;
            $object = Lesson::find($id);
            $filePath = Storage::putFile('lessons', $data['file']);
            Storage::delete($object->file_path);
            if($fileExtension == 'jpg' or $fileExtension == 'png'){
                $is_video = false;
            }
            $object->is_video = $is_video;
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
            $lesson = Lesson::find($id);
            Storage::delete($lesson->file_path);
            $lesson->delete();
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

    public function setActive($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Lesson::find($id);
            $object->active = true;
            $object->save();
            event(new ChangeLessonStatus($object));
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
            $object = Lesson::find($id);
            $object->active = false;
            $object->save();
            event(new ChangeLessonStatus($object));
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getSection($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $lesson = Lesson::find($id);
            $object = $lesson->section;
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getSources($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $lesson = Lesson::find($id);
            $object = $lesson->sources;
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getQuestions($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $lesson = Lesson::find($id);
            $object = $lesson->questions;
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getCompleted($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $lesson = Lesson::find($id);
            $object = $lesson->completed;
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
