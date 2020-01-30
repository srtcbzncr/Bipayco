<?php

namespace App\Repositories\GeneralEducation;

use App\Models\Auth\Instructor;
use App\Models\Auth\Student;
use App\Models\GeneralEducation\Achievement;
use App\Models\GeneralEducation\Comment;
use App\Models\GeneralEducation\Entry;
use App\Models\GeneralEducation\Lesson;
use App\Models\GeneralEducation\Requirement;
use App\Models\GeneralEducation\Section;
use App\Models\GeneralEducation\Tag;
use App\Repositories\IRepository;
use App\Models\GeneralEducation\Course;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class CourseRepository implements IRepository{

    public function all()
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::all();
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
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
                ->take(20)
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

    public function get($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::find($id);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByCategoryFilterByNewest($category_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('category_id', $category_id)
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

    public function getByCategoryFilterByOldest($category_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('category_id', $category_id)
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

    public function getByCategoryFilterByPriceASC($category_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('category_id', $category_id)
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

    public function getByCategoryFilterByPriceDESC($category_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('category_id', $category_id)
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

    public function getByCategoryFilterByPoint($category_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('category_id', $category_id)
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

    public function getByCategoryFilterByPurchases($category_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('category_id', $category_id)
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

    public function getByCategoryFilterByTrending($category_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('category_id', $category_id)
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

    public function getBySubCategoryFilterByNewest($sub_category_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('sub_category_id', $sub_category_id)
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

    public function getBySubCategoryFilterByOldest($sub_category_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('sub_category_id', $sub_category_id)
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

    public function getBySubCategoryFilterByPriceASC($sub_category_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('sub_category_id', $sub_category_id)
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

    public function getBySubCategoryFilterByPriceDESC($sub_category_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('sub_category_id', $sub_category_id)
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

    public function getBySubCategoryFilterByPoint($sub_category_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('sub_category_id', $sub_category_id)
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

    public function getBySubCategoryFilterByPurchases($sub_category_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('sub_category_id', $sub_category_id)
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

    public function getBySubCategoryFilterByTrending($sub_category_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('sub_category_id', $sub_category_id)
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
            $object = new Course;
            $object->category_id = $data['category_id'];
            $object->sub_category_id = $data['sub_category_id'];
            $object->image = $imagePath;
            $object->name = $data['name'];
            $object->description = $data['description'];
            $object->access_time = $data['access_time'];
            $object->certificate = $data['certificate'];
            $object->price = $data['price'];
            $object->price_with_discount = $data['price'];
            $object->save();
            $object->instructors()->save(Instructor::find($data['instructor_id']), ['is_manager' => true, 'percent' => 100]);
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
            $object = Course::find($id);
            if(array_key_exists('image', $data)){
                $imagePath = Storage::url($data['image']->store('public/images'));
                Storage::delete($object->image);
                $object->image = $imagePath;
            }
            $object->category_id = $data['category_id'];
            $object->sub_category_id = $data['sub_category_id'];
            $object->name = $data['name'];
            $object->description = $data['description'];
            $object->access_time = $data['access_time'];
            $object->certificate = $data['certificate'];
            $object->price = $data['price'];
            $discounts = $object->discounts;
            $price_with_discount = $data['price'];
            foreach ($discounts as $discount){
                $price_with_discount = ($price_with_discount * $discount->discount_rate) / 100;
            }
            $object->price_with_discount = $price_with_discount;
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
            $requirements = Requirement::where('course_id',$id)->get();
            foreach ($requirements as $item){
                $item->delete();
            }
            foreach ($data as $requirement){
                $newRequirement = new Requirement();
                $newRequirement->course_id = $id;
                $newRequirement->course_type = 'App\Models\GeneralEducation\Course';
                $newRequirement->content = $requirement;
                $newRequirement->save();
            }
            $object = Requirement::where('course_id',$id)->get();
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
            $achievements = Achievement::where('course_id',$id)->get();
            foreach ($achievements as $item){
                $item->delete();
            }

            foreach ($data as $achievement){
                $newAchievement = new Achievement();
                $newAchievement->course_id = $id;
                $newAchievement->course_type = 'App\Models\GeneralEducation\Course';
                $newAchievement->content = $achievement;
                $newAchievement->save();
            }
            $object = Achievement::where('course_id',$id)->get();
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
            $tags = Tag::where('course_id',$id)->get();
            foreach ($tags as $item){
                $item->delete();
            }
            foreach ($data as $tag){
                $newTag = new Tag();
                $newTag->course_id = $id;
                $newTag->course_type = 'App\Models\GeneralEducation\Course';
                $newTag->tag = $tag;
                $newTag->save();
            }
            $object = Tag::where('course_id',$id)->get();
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
            $achievements = Achievement::where('course_id',$id)->where('active',1)->get();
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
            $requierements = Requirement::where('course_id',$id)->where('active',1)->get();
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
            $tag = Tag::where('course_id',$id)->get();
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

        // Operations
        $isManagers = array();
        foreach ($data as $key => $item){
            $geCoursesInstructor = DB::select('select * from ge_courses_instructors where course_id = '.$course_id.' and instructor_id = '.$item['instructor_id']);
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
               /* DB::insert('insert into ge_courses_instructors (course_id,course_type,instructor_id,is_manager,percent) values (?,?,?,?,?)',
                    [$course_id,'App\Models\GeneralEducation\Course', $item['instructor_id'],$isManagers[$key],$item['percent']]);*/
                DB::table("ge_courses_instructors")->insert(array(
                    'course_id' => $course_id,
                    'course_type' => 'App\Models\GeneralEducation\Course',
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
            $object =  DB::table("ge_courses_instructors")->where('course_id',$id)->where('active',true)->get();
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

    public function delete($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Course::find($id);
            Storage::delete($object->image);
            $object->delete();
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
            $object = Course::find($id);
            if($object->sections->where('active', true) != null){
                $object->active = true;
                $object->save();
            }
            else {
                throw new \Exception(__('general_education.course_has_not_active_section'));
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

    public function setPassive($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::find($id);
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

    public function getInstructors($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->instructors;
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

    public function getAchievements($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->achievements->where('active', true);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getRequirements($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->requirements->where('active', true);
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

    public function getTags($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->tags->where('active', true);
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
            $object = Entry::where('course_id', $id)->where('course_type', 'App\Models\GeneralEducation\Course')->where('active', true)->orderBy('created_at', 'desc')->take(3)->get();
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }



    public function getSubCategory($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->subCategory;
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getCategory($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->category;
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
