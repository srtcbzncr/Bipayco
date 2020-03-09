<?php

namespace App\Repositories\PrepareLessons;

use App\Models\Auth\Student;
use App\Models\GeneralEducation\Achievement;
use App\Models\GeneralEducation\Comment;
use App\Models\GeneralEducation\Entry;
use App\Models\GeneralEducation\Requirement;
use App\Models\GeneralEducation\Tag;
use App\Models\PrepareLessons\Course;
use App\Models\PrepareLessons\Lesson;
use App\Models\PrepareLessons\Section;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class CourseRepository implements IRepository{

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

            $imagePath = Storage::url($data['image']->store('public/images'));
            $course = new Course();
            $course->lesson_id = $data['lesson_id'];
            $course->grade_id = $data['grade_id'];
            $course->image = $imagePath;
            $course->name = $data['name'];
            $course->description = $data['description'];
            $course->access_time = $data['access_time'];
            $course->certificate = $data['certificate'];
            $course->long = 0;
            $course->price = $data['price'];
            $course->price_with_discount = $data['price'];
            $course->save();

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

    public function update($id, array $data)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {
            DB::beginTransaction();

            $object = Course::find($id);
            if(array_key_exists('image', $data)){
                $imagePath = Storage::url($data['image']->store('public/images'));
                Storage::delete($object->image);
                $object->image = $imagePath;
            }
            $object->lesson_id = $data['lesson_id'];
            $object->grade_id = $data['grade_id'];
            $object->image = $imagePath;
            $object->name = $data['name'];
            $object->description = $data['description'];
            $object->access_time = $data['access_time'];
            $object->certificate = $data['certificate'];
            $object->long = $data['long'];
            $object->price = $data['price'];
            $object->price_with_discount = $data['price'];
            $object->save();

            DB::commit();

        }catch(\Exception $e){
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

    public function getPopularCourses(){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('active', true)
                ->where('point', '>=', 2.0)
                ->orderBy('purchase_count', 'desc')
                ->orderBy('point', 'desc')
                ->take(12)
                ->get();
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByLessonFilterByNewest($lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('lesson_id', $lesson_id)
                ->where('active', true)
                ->latest()
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByLessonFilterByOldest($lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('lesson_id', $lesson_id)
                ->where('active', true)
                ->oldest()
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByLessonFilterByPriceASC($lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('lesson_id', $lesson_id)
                ->where('active', true)
                ->orderBy('price_with_discount', 'asc')
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByLessonFilterByPriceDESC($lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('lesson_id', $lesson_id)
                ->where('active', true)
                ->orderBy('price_with_discount', 'desc')
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByLessonFilterByPoint($lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('lesson_id', $lesson_id)
                ->where('active', true)
                ->orderBy('point', 'desc')
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByLessonFilterByPurchases($lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('lesson_id', $lesson_id)
                ->where('active', true)
                ->orderBy('purchase_count', 'desc')
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByLessonFilterByTrending($lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('lesson_id', $lesson_id)
                ->where('active', true)
                ->orderBy('purchase_count', 'desc')
                ->orderBy('point','desc')
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByGradeFilterByNewest($grade_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('grade_id', $grade_id)
                ->where('active', true)
                ->latest()
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByGradeFilterByOldest($grade_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('grade_id', $grade_id)
                ->where('active', true)
                ->oldest()
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByGradeFilterByPriceASC($grade_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('grade_id', $grade_id)
                ->where('active', true)
                ->orderBy('price_with_discount', 'asc')
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByGradeFilterByPriceDESC($grade_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('grade_id', $grade_id)
                ->where('active', true)
                ->orderBy('price_with_discount', 'desc')
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByGradeFilterByPoint($grade_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('grade_id', $grade_id)
                ->where('active', true)
                ->orderBy('point', 'desc')
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByGradeFilterByPurchases($grade_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('grade_id', $grade_id)
                ->where('active', true)
                ->orderBy('purchase_count', 'desc')
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByGradeFilterByTrending($grade_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('grade_id', $grade_id)
                ->where('active', true)
                ->orderBy('purchase_count', 'desc')
                ->orderBy('point','desc')
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function syncRequirements($id, array $data){
        // data empty control
        if(count($data) == 0){
            $object = array();
            $error = false;
            $result = true;
            $resp = new RepositoryResponse($result, $object, $error);
            return $resp;
        }
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $requirements = Requirement::where('course_id',$id)->where('course_type','App\Models\PrepareLessons\Course')->get();
            foreach ($requirements as $item){
                $item->delete();
            }
            foreach ($data as $requirement){
                $newRequirement = new Requirement();
                $newRequirement->course_id = $id;
                $newRequirement->course_type = 'App\Models\PrepareLessons\Course';
                $newRequirement->content = $requirement;
                $newRequirement->save();
            }
            $object = Requirement::where('course_id',$id)->where('course_type','App\Models\PrepareLessons\Course')->get();
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

    public function syncAchievements($id, array $data){
        // data empty control
        if(count($data) == 0){
            $object = array();
            $error = false;
            $result = true;
            $resp = new RepositoryResponse($result, $object, $error);
            return $resp;
        }
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $achievements = Achievement::where('course_id',$id)->where('course_type','App\Models\PrepareLessons\Course')->get();
            foreach ($achievements as $item){
                $item->delete();
            }

            foreach ($data as $achievement){
                $newAchievement = new Achievement();
                $newAchievement->course_id = $id;
                $newAchievement->course_type = 'App\Models\PrepareLessons\Course';
                $newAchievement->content = $achievement;
                $newAchievement->save();
            }
            $object = Achievement::where('course_id',$id)->where('course_type','App\Models\PrepareLessons\Course')->get();
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

    public function syncTags($id, array $data){
        // data empty control
        if(count($data) == 0){
            $object = array();
            $error = false;
            $result = true;
            $resp = new RepositoryResponse($result, $object, $error);
            return $resp;
        }
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $tags = Tag::where('course_id',$id)->where('course_type','App\Models\PrepareLessons\Course')->get();
            foreach ($tags as $item){
                $item->delete();
            }
            foreach ($data as $tag){
                $newTag = new Tag();
                $newTag->course_id = $id;
                $newTag->course_type = 'App\Models\PrepareLessons\Course';
                $newTag->tag = $tag;
                $newTag->save();
            }
            $object = Tag::where('course_id',$id)->where('course_type','App\Models\PrepareLessons\Course')->get();
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
    public function syncAchievementGet($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $achievements = Achievement::where('course_id',$id)->where('course_type','App\Models\PrepareLessons\Course')->where('active',1)->get();
            $object = $achievements;
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $object = array();
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function syncRequierementGet($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $requierements = Requirement::where('course_id',$id)->where('course_type','App\Models\PrepareLessons\Course')->where('active',1)->get();
            $object = $requierements;
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $object = array();
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function syncTagGet($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $tag = Tag::where('course_id',$id)->where('course_type','App\Models\PrepareLessons\Course')->get();
            $object = $tag;
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $object = array();
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function syncSections($id, array $data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $course = Course::find($id);
            $sections = Section::where('course_id',$id)->get();
            // var olan sectionları ve lessonsları sil
            foreach ($sections as $item){
                $lessons = Lesson::where('section_id',$item->id)->get();
                foreach ($lessons as $lesson){
                    $lesson->delete();
                }
                $item->delete();
            }

            // yeni sectionları ekle
            foreach ($data as $key => $section){
                $newSection = new Section();
                $newSection->course_id = $id;
                $newSection->no = $key;
                $newSection->name = $section['name'];
                $newSection->save();
            }
            $object = $course->sections;
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
    public function syncLesson($id, array $data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $course = Course::find($id);
            $sections = $course->sections;
            // yeni lessons ekle
            foreach ($data as $key => $section){
                foreach($section['lessons'] as $key_lesson => $lesson){
                    $objLesson = new Lesson();
                    $objLesson->section_id = $sections[$key]->id;
                    $objLesson->is_video = $lesson['is_video'];
                    $objLesson->no = $key_lesson;
                    $objLesson->long = 1;
                    $file = Request::file($lesson['file']);
                    $filename = $file->getClientOriginalName();
                    $path = public_path().'/storage/app/lessons';
                    $objLesson->file_path = $file->move($path, $filename);
                    //$videoPath = Storage::url($data['image']->store('public/videos'));
                    //$objLesson->file_path = "boş";
                    $objLesson->preview = $lesson['is_preview'];
                    $objLesson->name = $lesson['name'];
                    $objLesson->save();
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
    public function syncSource($id,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $course = Course::find($id);
            $sections = $course->sections;
            $myLessons = $sections->lessons;

            // yeni source ekle
            foreach ($data as $key => $section){
                foreach($section['lessons'] as $key_lesson => $lesson){
                    $objLesson = new Lesson();
                    $objLesson->section_id = $sections[$key]->id;
                    $objLesson->is_video = $lesson['isVideo'];
                    $objLesson->no = $key_lesson;
                    $objLesson->long = 1;
                    $videoPath = Storage::url($data['image']->store('public/videos'));
                    $objLesson->file_path = $videoPath;
                    $objLesson->preview = $lesson['isPreview'];
                    $objLesson->name = $lesson['name'];
                    $objLesson->save();
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

    public function syncSectionGet($id){
        // section->lessonsları çek

        // Response variables
        $result = true;
        $error = null;
        $object = null;

        try{
            DB::beginTransaction();

            $object = array();
            $course = Course::find($id);
            $sections = $course->sections->where('active', true);
            $object['sections'] = $sections;
            foreach ($sections as $key => $section){
                $lessons = $section->lessons;
                $object['sections'][$key]['lessons'] = $lessons;
                foreach ($lessons as $keyLesson => $lesson){
                    $sources = $lesson->sources;
                    $object['sections'][$key]['lessons'][$keyLesson]['sources'] = $sources;
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
    public function syncInstructor($course_id,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;
        $course_type = 'App\Models\PrepareLessons\Course';

        // Operations
        $isManagers = array();
        foreach ($data as $key => $item){
            $geCoursesInstructor = DB::select('select * from ge_courses_instructors where course_id = '.$course_id.' and instructor_id = '.$item['instructor_id'].' and course_type = '.$course_type);
            try {
                if($geCoursesInstructor[0]->is_manager == 1){
                    $isManagers[$key] = 1;
                }
                else{
                    $isManagers[$key] = 0;
                }
            } catch(\Exception $e){
                $isManagers[$key] = 0;
            }
        }

        try{
            DB::beginTransaction();
            $course = Course::find($course_id);
            DB::table("ge_courses_instructors")->where('course_id',$course_id)->delete();
            foreach ($data as $key => $item){
                DB::table("ge_courses_instructors")->insert(array(
                    'course_id' => $course_id,
                    'course_type' => 'App\Models\PrepareLessons\Course',
                    'instructor_id' => $item['instructor_id'],
                    'is_manager' => $isManagers[$key],
                    'percent' => $item['percent'],
                    'user'=>"0"
                ));
            }
            $object = $course->instructors;
            DB::commit();
        }
        catch(\Exception $e){
            print_r($e->getMessage());
            DB::rollBack();
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function syncInstructorGet($id){
        // Response variables
        $result = true;
        $error = null;
        $object = array();

        // Operations
        try{
            DB::beginTransaction();
            $object =  DB::table("ge_courses_instructors")->where('course_id',$id)->where('course_type','App\Models\PrepareLessons\Course')->where('active',true)->get();
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

    public function updateImage($id, array $data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Course::find($id);
            $imagePath = $data['image']->store('public/images');
            Storage::delete($object->image);
            $object->imagePath = $imagePath;
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

    public function getSections($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->sections->where('active', true);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getManagerInstructor($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = DB::select('SELECT * FROM auth_instructors WHERE id=(SELECT instructor_id FROM ge_courses_instructors WHERE course_id='.$id.' AND is_manager=1 LIMIT 1)');
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getCoursesFromInstructors($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = DB::select('SELECT * FROM ge_courses WHERE id NOT IN( '.$id.' ) AND id IN (SELECT course_id FROM ge_courses_instructors WHERE instructor_id IN (SELECT instructor_id FROM ge_courses_instructors WHERE course_id='.$id.')) ORDER BY point DESC LIMIT 10');
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getSimilarCourses($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $courses = Course::all();
            $object = $courses->random(2);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getComments($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->comments->where('active', true)->orderBy('created_at', 'desc');
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getCommentsWithPaginate($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = Comment::where('course_id', $id)->where('active', true)->orderBy('created_at', 'desc')->paginate(10);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getDiscounts($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->discounts->where('active', true);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getNotices($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->notices->where('active', true);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getFavorites($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->favorites;
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getPurchases($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->purchases;
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getEntries($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->entries->where('active', true);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getStudents($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Entry::where('course_id', $id)->where('course_type', 'App\Models\PrepareLessons\Course')->where('active', true)->orderBy('created_at', 'desc')->take(3)->get();
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getGrade($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->grade;
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
            $course = Course::find($id);
            $object = $course->lesson;
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function calculateProgress($course_id, $student_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $lessonsArray = array();
            $course = Course::find($course_id);
            $sections = $course->sections;
            $student = Student::find($student_id);
            $completedArray = array();
            foreach ($sections as $section){
                $lessons = $section->lessons;
                foreach ($lessons as $lesson){
                    array_push($lessonsArray, $lesson->id);
                }
            }
            $lessonCount = count($lessonsArray);
            $completedCount = 0;
            foreach ($student->geCompleted as $completed){
                if($completed->pivot->is_completed == true){
                    array_push($completedArray, $completed->id);
                }
            }
            foreach ($lessonsArray as $lesson_id){
                if(in_array($lesson_id, $completedArray)){
                    $completedCount = $completedCount + 1;
                }
            }
            $progressPercent = number_format($completedCount * (100/$lessonCount), 0);
            $object = $progressPercent;
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getCompletedLessons($course_id, $user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $student = Student::where('user_id', $user_id)->first();
            $lessons = DB::select('SELECT lesson_id FROM ge_students_completed_lessons WHERE is_completed=1 AND student_id='.$student->id.' AND lesson_id IN (SELECT id FROM ge_lessons WHERE section_id IN (SELECT id FROM ge_sections WHERE course_id='.$course_id.'))');
            $object = array();
            foreach ($lessons as $lesson){
                array_push($object, $lesson->lesson_id);
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
}
