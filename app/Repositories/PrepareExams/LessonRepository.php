<?php


namespace App\Repositories\PrepareExams;


use App\Events\Instructor\CourseActiveEvent;
use App\Events\Instructor\SectionActiveEvent;
use App\Models\Auth\Student;
use App\Models\GeneralEducation\Source;
use App\Models\PrepareExams\Course;
use App\Models\PrepareExams\Lesson;
use App\Models\PrepareExams\Section;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Pbmedia\LaravelFFMpeg\FFMpegFacade as FFMpeg;

class LessonRepository implements IRepository{

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
            DB::beginTransaction();
            $tempSection = Section::find($data['section_id']);
            $course_id = $tempSection->course_id;
            $my_lessons = Lesson::where('section_id',$data['section_id'])->where('deleted_at',null)->get();
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
            $object = new Lesson();
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
                $lessons = Lesson::where('section_id',$data['section_id'])->where('deleted_at',null)->get();
                $lesson = null;
                foreach ($lessons as $item){
                    $lesson = $item;
                }
                foreach ($data['sources'] as $source){
                    $localPath = $source->store('public/sources');
                    $accessPath = Storage::url($localPath);
                    // $filePath = Storage::putFile('sources', $source);
                    $newSource = new Source;
                    $newSource->lesson_id = $lesson->id;
                    $newSource->lesson_type = get_class($lesson);
                    $newSource->title = $source->getClientOriginalName();
                    $newSource->file_path = $accessPath;
                    $newSource->save();
                }
            }


            $sectionEventData = array();
            $sectionEventData['section_id'] = $data['section_id'];
            $sectionEventData['education'] = 3;
            event(new SectionActiveEvent($sectionEventData));
            $lessonEventData = array();
            $lessonEventData['course_id'] = $course_id;
            $lessonEventData['education'] = 3;
            event(new CourseActiveEvent($lessonEventData));

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
            $lesson = Lesson::find($id);
            $section_id = $lesson->section_id;
            Storage::delete($lesson->file_path);
            $lesson->delete();

            // bu sectiona ait başka lesson olup olamdığını kontrol et.
            $section = Section::find($section_id);
            $course_id = $section->course_id;
            $lessons = $section->lessons;
            if($lessons == null or count($lessons) == 0){
                $section->active = false;
                $section->save();
            }

            // bu kursa ait aktif section olup olmadığını kontrol et.
            $sections = Section::where('course_id',$course_id)->where('deleted_at',null)->get();
            $flag = false;
            $counter = 0;
            if($sections == null or count($sections) == 0){
                $course = Course::find($course_id);
                $course->active = false;
                $course->save();
            }
            else{
                foreach ($sections as $section){
                    if($section->active == true){
                        $flag == false;
                        break;
                    }
                    else{
                        $counter++;
                    }

                    if($counter == count($sections))
                        $flag = true;
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
        // TODO: Implement setActive() method.
    }

    public function setPassive($id)
    {
        // TODO: Implement setPassive() method.
    }

    public function lessonUp($course_id,$section_id,$lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $lessons = Lesson::where('section_id',$section_id)->where('deleted_at',null)->orderBy('no','asc')->get();
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
            // $object = Lesson::where('section_id',$section_id)->orderBy('no','asc')->get();
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
            $lessons = Lesson::where('section_id',$section_id)->where('deleted_at',null)->orderBy('no','asc')->get();
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
            //$object = Lesson::where('section_id',$section_id)->orderBy('no','asc')->get();
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
            $student = Student::where('user_id',$data['user_id'])->first();
            DB::table('ge_students_completed_lessons')->insert([
                'student_id' => $student->id,
                'lesson_id' => $lesson_id,
                'lesson_type' => 'App\Models\PrepareLessons\Lesson',
                'is_completed' => true
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

    public function getDefaultLesson($course_id,$user_id,$lesson_type){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{

            $object = array();
            $student = Student::where('user_id',$user_id)->first();
            $student_id = $student->id;

            $sections = Section::where('course_id',$course_id)->where('deleted_at',null)->where('active',true)->orderBy('no','asc')->get();
            $myLessons = array();
            $i=0;
            foreach ($sections as $key => $section){
                $lessons = Lesson::where('section_id',$section->id)->where('deleted_at',null)->where('active',true)->orderBy('no','asc')->get();
                foreach ($lessons as $lesson){
                    $myLessons[$i] = $lesson;
                    $i++;
                }
            }

            $completedLessons = null;
            if($lesson_type == "App\Models\GeneralEducation\Lesson"){
                $completedLessons = DB::table('ge_students_completed_lessons')->where('student_id',$student_id)->where('lesson_type','App\Models\GeneralEducation\Lesson')->get();
            }
            else if($lesson_type == "App\Models\PrepareLessons\Lesson"){
                $completedLessons = DB::table('ge_students_completed_lessons')->where('student_id',$student_id)->where('lesson_type','App\Models\PrepareLessons\Lesson')->get();

            }
            $b = false;
            $default_lesson = null;
            foreach ($myLessons as $lesson){
                foreach ($completedLessons as $completedLesson){
                    if($lesson->id != $completedLesson->id){
                        $default_lesson = $lesson;
                        $b = true;
                        break;
                    }
                }
                if($b == true){
                    break;
                }
            }
            if($default_lesson == null){
                // ilk videoyu gönder
                $default_lesson = $myLessons[0];
            }

            $object = $default_lesson;
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
