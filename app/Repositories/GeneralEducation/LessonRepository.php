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
            $my_lessons = Lesson::where('section_id',$data['section_id'])->get();
            $last_lesson = null;
            foreach ($my_lessons as $item){
                $last_lesson = $item;
            }
            $pathForFFMpeg = $data['document']->store('public/lessons');
            $filePath = Storage::url($pathForFFMpeg);
            $long = 0;
            if($data['is_video'] != 0){
                $media=FFMpeg::open($pathForFFMpeg);
                $long=$media->getDurationInSeconds();
            }
            $object = new Lesson;
            $object->section_id = $data['section_id'];
            $object->is_video = $data['is_video'];
            if($last_lesson!=null)
                $object->no = $last_lesson->no+1;
            else
                $object->no = 1;
            $object->name = $data['name'];
            $object->long = $long;
            $object->preview = $data['is_preview'];
            $object->file_path = $filePath;
            $object->save();

            if($data['sources']!=null){
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
            }


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
            $object->section_id = $data['sectionId'];
            $object->no = 1;
            //$object->file_path = $data['file_path'];
            $object->name = $data['name'];
            $object->preview = $data['is_preview'];
            # Yeni gelen source varsa onları ekle
            if(isset($data['newSource'])){
                foreach ($data['newSource'] as $item){
                    $filePath = Storage::putFile('sources', $item);
                    $newSource = new Source;
                    $newSource->lesson_id = $id;
                    $newSource->lesson_type = get_class($object);
                    $newSource->title = $item->getClientOriginalName();
                    $newSource->file_path = $filePath;
                    $newSource->save();
                }
            }
            $object->save();

            # Lesson üzerinde güncelleme yapıldığında o lesson'a ait olan ve aktifliği false olan source'ları sil.
            $lesson = Lesson::find($id);
            $sources = $lesson->sources;
            foreach ($sources as $source){
                if ($source->active == 0){
                    Storage::delete($source->file_path);
                    $source->delete();
                }
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

    public function lessonUp($course_id,$section_id,$lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $lessons = Lesson::where('section_id',$section_id)->orderBy('no','asc')->get();
            $before_lesson = null;
            foreach ($lessons as $key=> $lesson){
                if($lesson->id == $lesson_id){
                    $temp_no = $before_lesson->no;
                    $before_lesson->no = $lesson->no;
                    $before_lesson->save();

                    $lesson->no = $temp_no;
                    $lesson->save();
                    break;
                }
                $before_lesson = $lesson;
            }
            $object = Lesson::where('section_id',$section_id)->orderBy('no','asc')->get();
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function lessonDown($course_id,$section_id,$lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $lessons = Lesson::where('section_id',$section_id)->orderBy('no','asc')->get();
            $after_lesson = null;
            foreach ($lessons as $key=> $lesson){
                if($lesson->id == $lesson_id){
                    $after_lesson = $lessons[$key+1];

                    $temp_no = $after_lesson->no;
                    $after_lesson->no = $lesson->no;
                    $after_lesson->save();

                    $lesson->no = $temp_no;
                    $lesson->save();
                    break;
                }
            }
            $object = Lesson::where('section_id',$section_id)->orderBy('no','asc')->get();
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function completeLesson($lesson_id,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::table('ge_students_completed_lessons')->insert([
                'student_id' => $data['student_id'],
                'lesson_id' => $data['lesson_id'],
                'lesson_type' => 'App\Models\GeneralEducation\Lesson',
                'is_completed' => $data['is_completed']
            ]);

            $object = DB::table('ge_students_completed_lessons')->where('lesson_id',$lesson_id)->get();
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
