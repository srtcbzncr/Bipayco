<?php


namespace App\Repositories\Admin;


use App\Models\Curriculum\Lesson;
use App\Models\Curriculum\Subject;
use App\Models\PrepareLessons\Course;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LessonRepository implements IRepository
{

    public function all()
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = DB::table('cr_lessons')->where('deleted_at',null)->paginate(10);
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
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Lesson::find($id);
            $subjects = Subject::where('lesson_id',$id)->get();
            $object['subjects'] = $subjects;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
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
            $object = new Lesson();
            $object->name = $data['name'];
            $object->symbol = $data['symbol'];
            if(isset($data['image']) and file_exists($data['image'])){
                $filePath = $data['image']->store('public/images');
                $accessPath = Storage::url($filePath);
                $object->image = $accessPath;
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
            $object->name = $data['name'];
            $object->symbol = $data['symbol'];
            if(isset($data['image']) and file_exists($data['image'])){
                $filePath = $data['image']->store('public/images');
                $accessPath = Storage::url($filePath);
                $object->image = $accessPath;
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

    public function delete($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Lesson::find($id);
            $courses = Course::where('lesson_id',$id)->get();
            if($courses == null or count($courses) == 0){
                $subjects = Subject::where('lesson_id',$id)->get();
                foreach ($subjects as $subject){
                    $tempSubject = Subject::find($subject->id);
                    $tempSubject->delete();
                }
                $object->delete();
            }
            else{
                $error = "Derse ait kurslar bulunmaktadır.";
                $result = false;
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

    public function setActive($id)
    {
        // TODO: Implement setActive() method.
    }

    public function setPassive($id)
    {
        // TODO: Implement setPassive() method.
    }

    public function getSubjectsOfLesson($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = DB::table('cr_subjects')->where('lesson_id',$id)->where('deleted_at',null)->paginate(10);
            //$object = Subject::where('lesson_id',$id)->get();
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
