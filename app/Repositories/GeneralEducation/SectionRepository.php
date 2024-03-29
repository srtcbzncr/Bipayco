<?php

namespace App\Repositories\GeneralEducation;

use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Lesson;
use App\Models\GeneralEducation\SubCategory;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use App\Repositories\GeneralEducation\LessonRepository;
use App\Models\GeneralEducation\Section;
use Illuminate\Support\Facades\DB;

class SectionRepository implements IRepository{

    public function all()
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Section::all();
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
            $object = Section::find($id);
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
            $object = new Section;
            $sections = Section::where('course_id',$data['courseId'])->where('deleted_at',null)->orderBy('no','asc')->get();
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
            $object->active = false;
            $object->save();
            DB::commit();
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
            DB::rollBack();
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
            $section = Section::find($id);
            $course_id = $section->course_id;
            $lessons = Lesson::where('section_id',$id)->where('deleted_at',null)->get();
            foreach ($lessons as $lesson){
                $lesson->sources()->delete();
                $lesson->sources()->delete();
                $lesson->sources()->questions();
                $lesson->sources()->completed();
                $lesson->delete();
            }
            $section->delete();

            // bu kursa ait aktif kurs olup olmadığını kontrol et.
            $flag = false;
            $counter = 0;
            $sections = Section::where('course_id',$course_id)->where('deleted_at',null)->get();
            if($sections == null or count($sections) == 0){
                $course = Course::find($course_id);
                $course->active = false;
                $course->save();
            }
            else{
                foreach ($sections as $section){
                    if($section->active==true){
                        $flag = false;
                        break;
                    }
                    else{
                        $counter++;
                    }
                    if($counter == count($sections)){
                        $flag = true;
                        break;
                    }
                }
            }
            if($flag == true){
                $course = Course::find($course_id);
                $course->active = false;
                $course->save();
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

    public function setActive($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Section::find($id);
            if($object->lessons->where('active', true) != null){
                $object->active = true;
                $object->save();
            }
            else{
                throw new \Exception(__('general_education.section_has_not_active_lesson'));
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

    public function setPassive($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Section::find($id);
            $object->active = false;
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

    public function getCourse($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $section = Section::find($id);
            $object = $section->course;

            $subcategory = SubCategory::find($object->sub_category_id);
            $object['subCategory'] = $subcategory;
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getLessons($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $section = Section::find($id);
            $object = $section->lessons->where('active', true);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function sectionUp($course_id,$section_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $sections = Section::where('course_id',$course_id)->where('deleted_at',null)->orderBy('no','asc')->get();
            $before_section = null;
            foreach ($sections as $section){
                if($section->id == $section_id){
                    $temp_no = $before_section->no;
                    $before_section->no = $section->no;
                    $before_section->save();

                    $section->no = $temp_no;
                    $section->save();
                    break;
                }
                $before_section = $section;
            }
           // $object = Section::where('course_id',$course_id)->where('active',true)->get();
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
    public function sectionDown($course_id,$section_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $sections = Section::where('course_id',$course_id)->where('deleted_at',null)->orderBy('no','asc')->get();
            $after_section = null;
            foreach ($sections as $key => $section){
                if($section->id == $section_id){
                    $after_section = $sections[$key+1];

                    $temp_no = $after_section->no;
                    $after_section->no = $section->no;
                    $after_section->save();

                    $section->no = $temp_no;
                    $section->save();
                    break;
                }
            }
            //$object =  Section::where('course_id',$course_id)->where('active',true)->get();
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
}
