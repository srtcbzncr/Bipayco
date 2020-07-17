<?php


namespace App\Repositories\Search;


use App\Models\Curriculum\Exam;
use App\Models\Curriculum\Grade;
use App\Models\Curriculum\Lesson;
use App\Models\GeneralEducation\Category;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\SubCategory;
use App\Models\GeneralEducation\Tag;
use App\Models\UsersOperations\Basket;
use App\Models\UsersOperations\Favorite;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;

class SearchRepository implements IRepository
{

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
        // TODO: Implement create() method.
    }

    public function update($id, array $data)
    {
        // TODO: Implement update() method.
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

    public function search($tags,$userId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // operations
        try{
            $geTags = Tag::where('deleted_at',null)->whereIn('tag',$tags)->get();

            //$geTags = Tag::where('deleted_at',null)->whereIn('tag',$tags)->paginate(10);
            $tempCourses = array();
            $tempTypes = array();
            foreach ($geTags as $key => $item){
                if($item->course_type == "App\Models\GeneralEducation\Course"){
                    // yeni item zaten geTags'in içindemi kontrolü yap
                    $flag = true;
                    for ($i = 0; $i< count($tempCourses); $i++){
                        if($tempCourses[$i] == $item->course_id and $tempTypes[$i] == 'ge'){
                            $flag = false;
                            break;
                        }
                    }
                    if($flag){
                        $course = Course::find($item->course_id);
                        $course['type'] = "generalEducation";
                        $course['category'] = Category::find($course->category_id);
                        $course['subCategory'] = SubCategory::find($course->sub_category_id);
                        if($userId != null){
                            $controlBasket = Basket::where('user_id',$userId)->where('course_id',$course->id)->where('course_type','App\Models\GeneralEducation\Course')->get();
                            if($controlBasket != null and count($controlBasket)>0){
                                $course['inBasket'] = true;
                            }
                            else{
                                $course['inBasket'] = false;
                            }
                            $controlFavorite= Favorite::where('user_id',$userId)->where('course_id',$course->id)->where('course_type','App\Models\GeneralEducation\Course')->get();
                            if($controlFavorite != null and count($controlFavorite)>0){
                                $course['inFavorite'] = true;
                            }
                            else{
                                $course['inFavorite'] = false;
                            }
                        }
                        else{
                            $course['inBasket'] = null;
                            $course['inFavorite'] = null;
                        }

                        $geTags[$key] = $course;
                        array_push($tempCourses,$course->id);
                        array_push($tempTypes,'ge');
                    }
                    else{
                        unset($geTags[$key]);
                    }
                }
                else if($item->course_type == "App\Models\PrepareLessons\Course"){
                    // yeni item zaten geTags'in içindemi kontrolü yap
                    $flag = true;
                    for ($i = 0; $i< count($tempCourses); $i++){
                        if($tempCourses[$i] == $item->course_id and $tempTypes[$i] == 'pl'){
                            $flag = false;
                            break;
                        }
                    }
                    if($flag){
                        $course = \App\Models\PrepareLessons\Course::find($item->course_id);
                        $course['type'] = "prepareLessons";
                        $course['lesson'] = Lesson::find($course->lesson_id);
                        $course['grade'] = Grade::find($course->grade_id);
                        if($userId != null){
                            $controlBasket = Basket::where('user_id',$userId)->where('course_id',$course->id)->where('course_type','App\Models\PrepareLessons\Course')->get();
                            if($controlBasket != null and count($controlBasket)>0){
                                $course['inBasket'] = true;
                            }
                            else{
                                $course['inBasket'] = false;
                            }
                            $controlFavorite= Favorite::where('user_id',$userId)->where('course_id',$course->id)->where('course_type','App\Models\PrepareLessons\Course')->get();
                            if($controlFavorite != null and count($controlFavorite)>0){
                                $course['inFavorite'] = true;
                            }
                            else{
                                $course['inFavorite'] = false;
                            }
                        }
                        else{
                            $course['inBasket'] = null;
                            $course['inFavorite'] = null;
                        }

                        $geTags[$key] = $course;
                        array_push($tempCourses,$course->id);
                        array_push($tempTypes,'pl');
                    }
                    else{
                        unset($geTags[$key]);
                    }
                }
                else if($item->course_type == "App\Models\PrepareExams\Course"){
                    // yeni item zaten geTags'in içindemi kontrolü yap
                    $flag = true;
                    for ($i = 0; $i< count($tempCourses); $i++){
                        if($tempCourses[$i] == $item->course_id and $tempTypes[$i] == 'pe'){
                            $flag = false;
                            break;
                        }
                    }
                    if($flag){
                        $course = \App\Models\PrepareExams\Course::find($item->course_id);
                        $course['type'] = "prepareExams";
                        $course['exam'] = Exam::find($course->exam_id);
                        if($userId != null){
                            $controlBasket = Basket::where('user_id',$userId)->where('course_id',$course->id)->where('course_type','App\Models\PrepareExams\Course')->get();
                            if($controlBasket != null and count($controlBasket)>0){
                                $course['inBasket'] = true;
                            }
                            else{
                                $course['inBasket'] = false;
                            }
                            $controlFavorite= Favorite::where('user_id',$userId)->where('course_id',$course->id)->where('course_type','App\Models\PrepareExams\Course')->get();
                            if($controlFavorite != null and count($controlFavorite)>0){
                                $course['inFavorite'] = true;
                            }
                            else{
                                $course['inFavorite'] = false;
                            }
                        }
                        else{
                            $course['inBasket'] = null;
                            $course['inFavorite'] = null;
                        }

                        $geTags[$key] = $course;
                        array_push($tempCourses,$course->id);
                        array_push($tempTypes,'pe');
                    }
                    else{
                        unset($geTags[$key]);
                    }
                }
                else if($item->course_type == "App\Models\Live\Course"){
                    // yeni item zaten geTags'in içindemi kontrolü yap
                    $flag = true;
                    for ($i = 0; $i< count($tempCourses); $i++){
                        if($tempCourses[$i] == $item->course_id and $tempTypes[$i] == 'live'){
                            $flag = false;
                            break;
                        }
                    }
                    if($flag){
                        $course = \App\Models\Live\Course::find($item->course_id);
                        $course['type'] = "live";
                        if($userId != null){
                            $controlBasket = Basket::where('user_id',$userId)->where('course_id',$course->id)->where('course_type','App\Models\Live\Course')->get();
                            if($controlBasket != null and count($controlBasket)>0){
                                $course['inBasket'] = true;
                            }
                            else{
                                $course['inBasket'] = false;
                            }
                            $controlFavorite= Favorite::where('user_id',$userId)->where('course_id',$course->id)->where('course_type','App\Models\Live\Course')->get();
                            if($controlFavorite != null and count($controlFavorite)>0){
                                $course['inFavorite'] = true;
                            }
                            else{
                                $course['inFavorite'] = false;
                            }
                        }
                        else{
                            $course['inBasket'] = null;
                            $course['inFavorite'] = null;
                        }

                        $geTags[$key] = $course;
                        array_push($tempCourses,$course->id);
                        array_push($tempTypes,'live');
                    }
                    else{
                        unset($geTags[$key]);
                    }
                }
            }

            $object = array_chunk($geTags->toArray(),10);
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
