<?php

namespace App\Repositories\GeneralEducation;

use App\Models\Auth\Student;
use App\Models\GeneralEducation\Comment;
use App\Models\GeneralEducation\Entry;
use App\Models\GeneralEducation\Section;
use App\Repositories\IRepository;
use App\Models\GeneralEducation\Course;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;
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
            $imagePath = $data['image']->store('public/images');
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
            $object = Entry::where('course_id', $id)->where('active', true)->orderBy('created_at', 'desc')->take(3)->get();
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
            $object = DB::select('SELECT * FROM ge_students_completed_lessons WHERE student_id='.$student->id.' AND lesson_id IN (SELECT id FROM ge_lessons WHERE section_id IN (SELECT id FROM ge_sections WHERE course_id='.$course_id.'))');
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
