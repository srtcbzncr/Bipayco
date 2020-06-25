<?php

namespace App\Repositories\GeneralEducation;

use App\Models\Auth\Instructor;
use App\Models\Auth\Student;
use App\Models\Auth\User;
use App\Models\GeneralEducation\Achievement;
use App\Models\GeneralEducation\Category;
use App\Models\GeneralEducation\Comment;
use App\Models\GeneralEducation\Entry;
use App\Models\GeneralEducation\Lesson;
use App\Models\GeneralEducation\Purchase;
use App\Models\GeneralEducation\Requirement;
use App\Models\GeneralEducation\Section;
use App\Models\GeneralEducation\Source;
use App\Models\GeneralEducation\SubCategory;
use App\Models\GeneralEducation\Tag;
use App\Models\UsersOperations\Basket;
use App\Models\UsersOperations\Favorite;
use App\Repositories\IRepository;
use App\Models\GeneralEducation\Course;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\Auth;
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

    public function getPopularCourses($user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('active', true)
                ->where('point', '>=', 0.0)
                ->where('deleted_at',null)
                ->orderBy('purchase_count', 'desc')
                ->orderBy('point', 'desc')
                ->take(12)
                ->get();

            foreach ($object as $key=>$item){
                $subcategory = SubCategory::find($item->sub_category_id);
                $object[$key]['subCategory'] = $subcategory;
            }

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){
                    $student = Student::where('user_id',$user_id)->first();
                    $controlEntry = Entry::where('student_id',$student->id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->where('deleted_at',null)->get();
                    if($controlEntry != null and count($controlEntry)>0){
                        $object[$key]['inEntry'] = true;
                    }
                    else{
                        $object[$key]['inEntry'] = false;
                    }

                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                    $object[$key]['inEntry'] = null;
                }
            }

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
            $user = Auth::user();
            if($user == null){
                $object = Course::find($id);
            }
            else{
                $student = Student::where('user_id',$user->id)->first();
                $object = Course::find($id);

                $controlEntry = Entry::where('student_id',$student->id)->where('course_type','App\Models\GeneralEducation\Course')
                    ->where('course_id',$id)->where('deleted_at',null)->get();
                if($controlEntry != null and count($controlEntry)>0){
                    $object['inEntry'] = true;
                }
                else{
                    $object['inEntry'] = false;
                }

                $controlBasket = Basket::where('user_id',$user->id)->where('course_id',$id)->where('course_type','App\Models\GeneralEducation\Course')->get();
                if($controlBasket != null and count($controlBasket) > 0){
                    $object['inBasket'] = true;
                }
                else{
                    $object['inBasket'] = false;
                }
                $controlFav = Favorite::where('user_id',$user->id)->where('course_id',$id)->where('course_type','App\Models\GeneralEducation\Course')->get();
                if($controlFav != null and count($controlFav) > 0){
                    $object['inFavorite'] = true;
                }
                else{
                    $object['inFavorite'] = false;
                }

                // proggress verisi gönder.
                $sections = $object->sections;
                $counter = 0;
                $totalLesson = 0;
                foreach ($sections as $section){
                    $lessons = $section->lessons;
                    $totalLesson+=count($lessons);
                    foreach ($lessons as $lesson){
                        $controlComplete = DB::table('ge_students_completed_lessons')
                            ->where('student_id',$student->id)
                            ->where('lesson_id',$lesson->id)
                            ->where('lesson_type','App\Models\GeneralEducation\Lesson')->get();
                        if($controlComplete != null and count($controlComplete) > 0){
                            $counter++;
                        }
                    }
                }
                if($totalLesson == 0){
                    $object['progress'] = 0;
                }
                else{
                    $progress = ($counter/$totalLesson)*100;
                    $object['progress'] = $progress;
                }
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

    public function get_api($id,$user_id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $user = null;
            if($user_id != null){
                $user = User::find($user_id);
                $student = Student::where('user_id',$user->id)->first();
            }

            if($user == null){
                $object = Course::find($id);
            }
            else{
                $object = Course::find($id);
                $course = Course::find($id);

                $student = Student::where('user_id',$user_id)->first();
                $controlEntry = Entry::where('student_id',$student->id)->where('course_type','App\Models\GeneralEducation\Course')
                    ->where('course_id',$course->id)->where('deleted_at',null)->get();
                if($controlEntry != null and count($controlEntry)>0){
                    $object['inEntry'] = true;
                }
                else{
                    $object['inEntry'] = false;
                }

                $controlBasket = Basket::where('user_id',$user->id)->where('course_id',$id)->where('course_type','App\Models\GeneralEducation\Course')->get();
                if($controlBasket != null and count($controlBasket) > 0){
                    $object['inBasket'] = true;
                }
                else{
                    $object['inBasket'] = false;
                }
                $controlFav = Favorite::where('user_id',$user->id)->where('course_id',$id)->where('course_type','App\Models\GeneralEducation\Course')->get();
                if($controlFav != null and count($controlFav) > 0){
                    $object['inFavorite'] = true;
                }
                else{
                    $object['inFavorite'] = false;
                }

                // proggress verisi gönder.
                $sections = $course->sections;
                $counter = 0;
                $totalLesson = 0;
                foreach ($sections as $section){
                    $lessons = $section->lessons;
                    $totalLesson+=count($lessons);
                    foreach ($lessons as $lesson){
                        $controlComplete = DB::table('ge_students_completed_lessons')
                            ->where('student_id',$student->id)
                            ->where('lesson_id',$lesson->id)
                            ->where('lesson_type','App\Models\GeneralEducation\Lesson')->get();
                        if($controlComplete != null and count($controlComplete) > 0){
                            $counter++;
                        }
                    }
                }
                if($totalLesson == 0){
                    $object['progress'] = 0;
                }
                else{
                    $progress = ($counter/$totalLesson)*100;
                    $object['progress'] = $progress;
                }
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

    public function getByCategoryFilterByNewest($category_id,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('category_id', $category_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->latest()
                ->paginate(9);

            foreach ($object as $key=>$item){
                $subcategory = SubCategory::find($item->sub_category_id);
                $object[$key]['subCategory'] = $subcategory;
            }

             # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){

                    $student = Student::where('user_id',$user_id)->first();
                    $controlEntry = Entry::where('student_id',$student->id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->where('deleted_at',null)->get();
                    if($controlEntry != null and count($controlEntry)>0){
                        $object[$key]['inEntry'] = true;
                    }
                    else{
                        $object[$key]['inEntry'] = false;
                    }

                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                    ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                    $object[$key]['inEntry'] = null;
                }
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

    public function getByCategoryFilterByOldest($category_id,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('category_id', $category_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->oldest()
                ->paginate(9);

            foreach ($object as $key=>$item){
                $subcategory = SubCategory::find($item->sub_category_id);
                $object[$key]['subCategory'] = $subcategory;
            }

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){

                    $student = Student::where('user_id',$user_id)->first();
                    $controlEntry = Entry::where('student_id',$student->id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->where('deleted_at',null)->get();
                    if($controlEntry != null and count($controlEntry)>0){
                        $object[$key]['inEntry'] = true;
                    }
                    else{
                        $object[$key]['inEntry'] = false;
                    }

                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                    $object[$key]['inEntry'] = null;
                }
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

    public function getByCategoryFilterByPriceASC($category_id,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('category_id', $category_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('price_with_discount', 'asc')
                ->paginate(9);

            foreach ($object as $key=>$item){
                $subcategory = SubCategory::find($item->sub_category_id);
                $object[$key]['subCategory'] = $subcategory;
            }

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){

                    $student = Student::where('user_id',$user_id)->first();
                    $controlEntry = Entry::where('student_id',$student->id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->where('deleted_at',null)->get();
                    if($controlEntry != null and count($controlEntry)>0){
                        $object[$key]['inEntry'] = true;
                    }
                    else{
                        $object[$key]['inEntry'] = false;
                    }

                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                    $object[$key]['inEntry'] = null;
                }
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

    public function getByCategoryFilterByPriceDESC($category_id,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('category_id', $category_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('price_with_discount', 'desc')
                ->paginate(9);

            foreach ($object as $key=>$item){
                $subcategory = SubCategory::find($item->sub_category_id);
                $object[$key]['subCategory'] = $subcategory;
            }

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){

                    $student = Student::where('user_id',$user_id)->first();
                    $controlEntry = Entry::where('student_id',$student->id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->where('deleted_at',null)->get();
                    if($controlEntry != null and count($controlEntry)>0){
                        $object[$key]['inEntry'] = true;
                    }
                    else{
                        $object[$key]['inEntry'] = false;
                    }

                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                    $object[$key]['inEntry'] = null;
                }
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

    public function getByCategoryFilterByPoint($category_id,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('category_id', $category_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('point', 'desc')
                ->paginate(9);

            foreach ($object as $key=>$item){
                $subcategory = SubCategory::find($item->sub_category_id);
                $object[$key]['subCategory'] = $subcategory;
            }

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){

                    $student = Student::where('user_id',$user_id)->first();
                    $controlEntry = Entry::where('student_id',$student->id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->where('deleted_at',null)->get();
                    if($controlEntry != null and count($controlEntry)>0){
                        $object[$key]['inEntry'] = true;
                    }
                    else{
                        $object[$key]['inEntry'] = false;
                    }

                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                    $object[$key]['inEntry'] = null;
                }
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

    public function getByCategoryFilterByPurchases($category_id,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('category_id', $category_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('purchase_count', 'desc')
                ->paginate(9);

            foreach ($object as $key=>$item){
                $subcategory = SubCategory::find($item->sub_category_id);
                $object[$key]['subCategory'] = $subcategory;
            }

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){

                    $student = Student::where('user_id',$user_id)->first();
                    $controlEntry = Entry::where('student_id',$student->id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->where('deleted_at',null)->get();
                    if($controlEntry != null and count($controlEntry)>0){
                        $object[$key]['inEntry'] = true;
                    }
                    else{
                        $object[$key]['inEntry'] = false;
                    }

                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                    $object[$key]['inEntry'] = null;

                }
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

    public function getByCategoryFilterByTrending($category_id,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('category_id', $category_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('purchase_count', 'desc')
                ->orderBy('point','desc')
                ->paginate(9);

            foreach ($object as $key=>$item){
                $subcategory = SubCategory::find($item->sub_category_id);
                $object[$key]['subCategory'] = $subcategory;
            }

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){

                    $student = Student::where('user_id',$user_id)->first();
                    $controlEntry = Entry::where('student_id',$student->id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->where('deleted_at',null)->get();
                    if($controlEntry != null and count($controlEntry)>0){
                        $object[$key]['inEntry'] = true;
                    }
                    else{
                        $object[$key]['inEntry'] = false;
                    }

                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                    $object[$key]['inEntry'] = null;
                }
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

    public function getBySubCategoryFilterByNewest($sub_category_id,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('sub_category_id', $sub_category_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->latest()
                ->paginate(9);

            foreach ($object as $key=>$item){
                $subcategory = SubCategory::find($item->sub_category_id);
                $object[$key]['subCategory'] = $subcategory;
            }

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){
                    $student = Student::where('user_id',$user_id)->first();
                    $controlEntry = Entry::where('student_id',$student->id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->where('deleted_at',null)->get();
                    if($controlEntry != null and count($controlEntry)>0){
                        $object[$key]['inEntry'] = true;
                    }
                    else{
                        $object[$key]['inEntry'] = false;
                    }

                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                    $object[$key]['inEntry'] = null;
                }
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

    public function getBySubCategoryFilterByOldest($sub_category_id,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('sub_category_id', $sub_category_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->oldest()
                ->paginate(9);

            foreach ($object as $key=>$item){
                $subcategory = SubCategory::find($item->sub_category_id);
                $object[$key]['subCategory'] = $subcategory;
            }

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){

                    $student = Student::where('user_id',$user_id)->first();
                    $controlEntry = Entry::where('student_id',$student->id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->where('deleted_at',null)->get();
                    if($controlEntry != null and count($controlEntry)>0){
                        $object[$key]['inEntry'] = true;
                    }
                    else{
                        $object[$key]['inEntry'] = false;
                    }

                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                    $object[$key]['inEntry'] = null;
                }
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

    public function getBySubCategoryFilterByPriceASC($sub_category_id,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('sub_category_id', $sub_category_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('price_with_discount', 'asc')
                ->paginate(9);

            foreach ($object as $key=>$item){
                $subcategory = SubCategory::find($item->sub_category_id);
                $object[$key]['subCategory'] = $subcategory;
            }

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){

                    $student = Student::where('user_id',$user_id)->first();
                    $controlEntry = Entry::where('student_id',$student->id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->where('deleted_at',null)->get();
                    if($controlEntry != null and count($controlEntry)>0){
                        $object[$key]['inEntry'] = true;
                    }
                    else{
                        $object[$key]['inEntry'] = false;
                    }

                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                    $object[$key]['inEntry'] = null;
                }
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

    public function getBySubCategoryFilterByPriceDESC($sub_category_id,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('sub_category_id', $sub_category_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('price_with_discount', 'desc')
                ->paginate(9);

            foreach ($object as $key=>$item){
                $subcategory = SubCategory::find($item->sub_category_id);
                $object[$key]['subCategory'] = $subcategory;
            }

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){

                    $student = Student::where('user_id',$user_id)->first();
                    $controlEntry = Entry::where('student_id',$student->id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->where('deleted_at',null)->get();
                    if($controlEntry != null and count($controlEntry)>0){
                        $object[$key]['inEntry'] = true;
                    }
                    else{
                        $object[$key]['inEntry'] = false;
                    }

                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                    $object[$key]['inEntry'] = null;
                }
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

    public function getBySubCategoryFilterByPoint($sub_category_id,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('sub_category_id', $sub_category_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('point', 'desc')
                ->paginate(9);

            foreach ($object as $key=>$item){
                $subcategory = SubCategory::find($item->sub_category_id);
                $object[$key]['subCategory'] = $subcategory;
            }

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){

                    $student = Student::where('user_id',$user_id)->first();
                    $controlEntry = Entry::where('student_id',$student->id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->where('deleted_at',null)->get();
                    if($controlEntry != null and count($controlEntry)>0){
                        $object[$key]['inEntry'] = true;
                    }
                    else{
                        $object[$key]['inEntry'] = false;
                    }

                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                    $object[$key]['inEntry'] = null;
                }
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

    public function getBySubCategoryFilterByPurchases($sub_category_id,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('sub_category_id', $sub_category_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('purchase_count', 'desc')
                ->paginate(9);

            foreach ($object as $key=>$item){
                $subcategory = SubCategory::find($item->sub_category_id);
                $object[$key]['subCategory'] = $subcategory;
            }

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){

                    $student = Student::where('user_id',$user_id)->first();
                    $controlEntry = Entry::where('student_id',$student->id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->where('deleted_at',null)->get();
                    if($controlEntry != null and count($controlEntry)>0){
                        $object[$key]['inEntry'] = true;
                    }
                    else{
                        $object[$key]['inEntry'] = false;
                    }

                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                    $object[$key]['inEntry'] = null;
                }
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

    public function getBySubCategoryFilterByTrending($sub_category_id,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('sub_category_id', $sub_category_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('purchase_count', 'desc')
                ->orderBy('point','desc')
                ->paginate(9);

            foreach ($object as $key=>$item){
                $subcategory = SubCategory::find($item->sub_category_id);
                $object[$key]['subCategory'] = $subcategory;
            }

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){

                    $student = Student::where('user_id',$user_id)->first();
                    $controlEntry = Entry::where('student_id',$student->id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->where('deleted_at',null)->get();
                    if($controlEntry != null and count($controlEntry)>0){
                        $object[$key]['inEntry'] = true;
                    }
                    else{
                        $object[$key]['inEntry'] = false;
                    }

                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                    $object[$key]['inEntry'] = null;
                }
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
            $object->instructors()->save(Instructor::find($data['instructor_id']), ['is_manager' => true, 'percent' => 100, 'active' => true]);
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
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
            $requirements = Requirement::where('course_id',$id)->where('course_type','App\Models\GeneralEducation\Course')->get();
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
            $object = Requirement::where('course_id',$id)->where('course_type','App\Models\GeneralEducation\Course')->get();
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
            $achievements = Achievement::where('course_id',$id)->where('course_type','App\Models\GeneralEducation\Course')->get();
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
            $object = Achievement::where('course_id',$id)->where('course_type','App\Models\GeneralEducation\Course')->get();
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
            $tags = Tag::where('course_id',$id)->where('course_type','App\Models\GeneralEducation\Course')->get();
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
            $object = Tag::where('course_id',$id)->where('course_type','App\Models\GeneralEducation\Course')->get();
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
            $achievements = Achievement::where('course_id',$id)->where('course_type','App\Models\GeneralEducation\Course')->where('active',1)->get();
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
            $requierements = Requirement::where('course_id',$id)->where('course_type','App\Models\GeneralEducation\Course')->where('active',1)->get();
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
            $tag = Tag::where('course_id',$id)->where('course_type','App\Models\GeneralEducation\Course')->get();
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
            $sections = Section::where('course_id',$id)->where('deleted_at',null)->get();
            // var olan sectionları ve lessonsları sil
            foreach ($sections as $item){
                $lessons = Lesson::where('section_id',$item->id)->where('deleted_at',null)->get();
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
            $sections = Section::where('course_id',$id)->where('deleted_at',null)->orderBy('no','asc')->get();
           // $sections = $course->sections->getQuery()->where('active', true)->sortBy('no');
            $object['sections'] = $sections;
            foreach ($sections as $key => $section){
                $lessons = Lesson::where('section_id',$section->id)->where('deleted_at',null)->where('active',true)->orderBy('no','asc')->get();
                //$lessons = $section->lessons->sortBy('no');
                $object['sections'][$key]['lessons'] = $lessons;
                foreach ($lessons as $keyLesson => $lesson){
                    $sources = Source::where('lesson_id',$lesson->id)->where('deleted_at',null)->where('active',true)->get();
                    //$sources = $lesson->sources->where('active',true);
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
      //  $course_type = 'App\Models\GeneralEducation\Course';

        // Operations
        $isManagers = array();
        foreach ($data as $key => $item){
            $geCoursesInstructor = DB::table('ge_courses_instructors')->where('course_id',$course_id)
                ->where('deleted_at',null)->where('instructor_id',$item['instructor_id'])
                ->where('course_type','App\Models\GeneralEducation\Course')->get();
           // $geCoursesInstructor = DB::select('select * from ge_courses_instructors where course_id = '.$course_id.' and instructor_id = '.$item['instructor_id'].' and course_type = '.$course_type);
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
            DB::table("ge_courses_instructors")->where('course_id',$course_id)
                ->where('course_type','App\Models\GeneralEducation\Course')->delete();
            foreach ($data as $key => $item){
                DB::table("ge_courses_instructors")->insert(array(
                    'course_id' => $course_id,
                    'course_type' => 'App\Models\GeneralEducation\Course',
                    'instructor_id' => $item['instructor_id'],
                    'is_manager' => $isManagers[$key],
                    'percent' => $item['percent'],
                    'active' => true
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
            $geCourseInstructor =  DB::table("ge_courses_instructors")->where('course_id',$id)->where('course_type','App\Models\GeneralEducation\Course')->where('active',true)->get();
            foreach ($geCourseInstructor as $key => $item){
                if($item->is_manager == true){
                    $temp = $geCourseInstructor[0];
                    $geCourseInstructor[0] = $item;
                    $geCourseInstructor[$key] = $temp;
                    break;
                }
            }
            $object = array();
            foreach ($geCourseInstructor as $key => $item){
                if($item->is_manager == true){
                    $object[$key] = Instructor::find($item->instructor_id);
                    $object[$key]['is_manager'] = true;
                    $object[$key]['percent'] = $item->percent;
                }
                else{
                    $object[$key] = Instructor::find($item->instructor_id);
                    $object[$key]['is_manager'] = false;
                    $object[$key]['percent'] = $item->percent;
                }
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
            $object = Course::find($id);
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

    public function getSimilarCourses($id,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);

            $ge_tag = Tag::where('course_id',$id)->where('course_type','App\Models\GeneralEducation\Course')->where('deleted_at',null)->get();
            $tags = array();
            foreach ($ge_tag as $item){
                array_push($tags,$item->tag);
            }
            $courses_tag = Tag::where('deleted_at',null)->where('course_type','App\Models\GeneralEducation\Course')->whereIn('tag',$tags)->get();
            $temp_courses = array();
            $courses = null;
            foreach ($courses_tag as $item){
                $temp_course = Course::find($item->course_id);
                array_push($temp_courses,$temp_course);
            }
            $courses = collect($temp_courses);

            if(count($courses)>2){
                $object = $courses->random(2);
            }
            else if(count($courses)==2){
                $object = $courses;
            }
            else{
                $object = array();
            }


            if(count($object) > 0 and $user_id != null){
                foreach ($object as $key => $item){

                    $student = Student::where('user_id',$user_id)->first();
                    $controlEntry = Entry::where('student_id',$student->id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->where('deleted_at',null)->get();
                    if($controlEntry != null and count($controlEntry)>0){
                        $object[$key]['inEntry'] = true;
                    }
                    else{
                        $object[$key]['inEntry'] = false;
                    }

                    $contorlBasket = DB::table('basket')->where('user_id',$user_id)->where('course_id',$item->id)->where('course_type','App\Models\GeneralEducation\Course')->get();
                    if($contorlBasket !=  null and count($contorlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $contorlFav = DB::table('favorite')->where('user_id',$user_id)->where('course_id',$item->id)->where('course_type','App\Models\GeneralEducation\Course')->get();
                    if($contorlFav !=  null and count($contorlFav) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }

                foreach ($object as $key=>$item){
                    $subcategory = SubCategory::find($item->sub_category_id);
                    $object[$key]['subCategory'] = $subcategory;
                }
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
            $object = Comment::where('course_id', $id)->where('course_type','App\Models\GeneralEducation\Course')->where('active', true)->orderBy('created_at', 'desc')->paginate(10);
            foreach ($object as $key=>$comment){
                $user = User::find($comment->user_id);
                $object[$key]['user'] = $user;
            }
        }
        catch(\Exception $e){
            $error = $e->getMessage();
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

    public function calculateProgress($course_id, $user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            if($user_id!=null){
                $student = Student::where('user_id',$user_id)->first();
                $sections = Section::where('course_id',$course_id)->where('deleted_at',null)->where('active',true)->get()->toArray();

                $lessons = array();
                foreach ($sections as $section){
                    $tempLessons = Lesson::where('section_id',$section['id'])->where('deleted_at',null)->where('active',true)->get()->toArray();
                    foreach ($tempLessons as $lesson){
                        array_push($lessons,$lesson);
                    }

                }

                // tamamlanmış dersleri al
                $completedLessons = DB::table('ge_students_completed_lessons')
                    ->where('student_id',$student->id)
                    ->where('lesson_type','App\Models\GeneralEducation\Lesson')->get();
                $completeCount = 0;
                foreach ($lessons as $lesson){
                    foreach ($completedLessons as $completedLessonn){
                        if($lesson['id'] == $completedLessonn->lesson_id){;
                            $completeCount = $completeCount + 1;
                            break;
                        }
                    }
                }

                $progress = 0;
                $progress = ($completeCount/count($lessons))*100;
                $object = $progress;
            }



            /*$student = Student::find($student_id);
            $lessonsArray = array();
            $course = Course::find($course_id);
            $sections = $course->sections;
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
            $object = $progressPercent;*/
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

    public function getPreviewLessons($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $previewLessons = array();
            $course = Course::find($id);
            $sections = $course->sections;
            foreach ($sections as $section){
                $lessons = $section->lessons;
                foreach ($lessons as $lesson){
                    if($lesson->preview == 1){
                        array_push($previewLessons,$lesson);
                    }
                }
            }
            $object = $previewLessons;

        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function inBasket($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        $control = DB::table('basket')->where('user_id',$user_id)
            ->where('course_id',$course_id)
            ->where('course_type','App\Models\GeneralEducation\Course')->get();
        if($control!=null and count($control)>0){
            $object = true;
        }
        else{
            $object = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function buy($courseId,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            // öğrenciyi purchase tablosuna kaydet.
            $object = new Purchase();
            $object->user_id =  $data['userId'];
            $user = User::find($data['userId']);
            $object->student_id = $user->student->id;
            $object->course_id = $courseId;
            $object->course_type = 'App\Models\GeneralEducation\Course';
            $object->price = $data['price'];
            $object->confirmation = true;
            $object->save();

            //  öğrenciyi entry tablosuna kaydet.
            $object = null;
            $object = new Entry();
            $object->course_id = $courseId;
            $object->course_type = 'App\Models\GeneralEducation\Course';
            $object->student_id = $user->student->id;

            $course = Course::find($courseId);
            $today = date("Y/m/d");
            $accessTime = $course->access_time;
            $object->access_start = $today;
            $object->access_finish = date('Y-m-d', strtotime('+ '.$accessTime.' months', strtotime($today)));
            $object->active = true;
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

    public function deleteCourse($courseId,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $user = User::find($data['userId']);
            $instructor = $user->instructor;
            if($instructor != null){
                $hasCourse = DB::table('ge_courses_instructors')->where('course_id',$courseId)
                    ->where('course_type','App\Models\GeneralEducation\Course')
                    ->where('deleted_at',null)
                    ->where('instructor_id',$instructor->id)
                    ->where('is_manager',true)->get();
                if($hasCourse != null and count($hasCourse)>0){
                    $now = date('Y-m-d', time());
                    $flag = false;
                    $entries = Entry::where('course_id',$courseId)->where('course_type','App\Models\GeneralEducation\Course')->where('active',true)->get();
                    foreach ($entries as $entry){
                        if(date('Y-m-d',strtotime($entry->access_start))<=$now and date('Y-m-d',strtotime($entry->access_finish))>=$now){
                            $flag = true;
                            break;
                        }
                    }
                    if($flag == false){
                        // kurs ve kursa ait tüm bilgileri sil
                        $course = Course::find($courseId);
                        $sections = Section::where('course_id',$courseId)->where('deleted_at',null)->get();
                        foreach ($sections as $section){
                            $lessons = Lesson::where('section_id',$section->id)->where('deleted_at',null)->get();
                            foreach ($lessons as $lesson){
                                $sources = Source::where('lesson_id',$lesson->id)->where('deleted_at',null)->where('lesson_type','App\Models\GeneralEducation\Lesson')->get();
                                foreach ($sources as $source){
                                    $source->delete();
                                }
                                $lesson->delete();
                            }
                            $section->delete();
                        }
                        $course->delete();
                       DB::table('ge_courses_instructors')
                            ->where('course_id',$courseId)
                            ->where('course_type','App\Models\GeneralEducation\Course')->update(['deleted_at' => date('Y-m-d H:i:s')]);
                    }
                    else{
                        $error = "Kursa sahip öğrenci bulunmaktadır.Bu yüzden kursu silemezsiniz.";
                        $result = false;
                    }
                }
                else{
                    $error = "Bu kursun eğitmeni veya yönetici değilsiniz.Erişiminiz bulunmamaktadır.";
                    $result = false;
                }
            }
            else{
                $error = "Eğitmen değilsiniz.Erişiminiz bulunmamaktadır.";
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

    public function activeCourse($courseId,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $user = User::find($data['userId']);
            $instructor = $user->instructor;
            if($instructor != null){
                $hasCourse = DB::table('ge_courses_instructors')->where('course_id',$courseId)
                    ->where('course_type','App\Models\GeneralEducation\Course')
                    ->where('deleted_at',null)
                    ->where('instructor_id',$instructor->id)
                    ->where('is_manager',true)->get();
                if($hasCourse != null and count($hasCourse)>0){
                   $course = Course::find($courseId);
                   $sections = Section::where('course_id',$course->id)->where('active',true)->where('deleted_at',null)->get();
                   if($sections != null and count($sections)>0){
                       $flag = false;
                       foreach ($sections as $section){
                           $lessons = Lesson::where('section_id',$section->id)->where('active',true)->where('deleted_at',null)->get();
                           if($lessons != null and count($lessons)>0){
                               $course->active = true;
                               $course->save();
                               $flag = true;
                               break;
                           }
                       }
                       if($flag == false){
                           $error = "Kursa ait ders bulunmadığı için aktifleştirme işlemi başarısız.";
                           $result = false;
                       }
                   }
                   else{
                       $error = "Kursa ait bölüm bulunmadığı için aktifleştirme işlemi başarısız.";
                       $result = false;
                   }

                }
                else{
                    $error = "Bu kursun eğitmeni veya yönetici değilsiniz.Erişiminiz bulunmamaktadır.";
                    $result = false;
                }
            }
            else{
                $error = "Eğitmen değilsiniz.Erişiminiz bulunmamaktadır.";
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

    public function passiveCourse($courseId,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $user = User::find($data['userId']);
            $instructor = $user->instructor;
            if($instructor != null){
                $hasCourse = DB::table('ge_courses_instructors')->where('course_id',$courseId)
                    ->where('course_type','App\Models\GeneralEducation\Course')
                    ->where('deleted_at',null)
                    ->where('instructor_id',$instructor->id)
                    ->where('is_manager',true)->get();
                if($hasCourse != null and count($hasCourse)>0){
                    $course = Course::find($courseId);
                    $course->active = false;
                    $course->save();
                }
                else{
                    $error = "Bu kursun eğitmeni veya yönetici değilsiniz.Erişiminiz bulunmamaktadır.";
                    $result = false;
                }
            }
            else{
                $error = "Eğitmen değilsiniz.Erişiminiz bulunmamaktadır.";
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

}
