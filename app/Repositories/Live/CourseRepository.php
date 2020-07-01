<?php


namespace App\Repositories\Live;


use App\Models\Auth\Student;
use App\Models\Auth\User;
use App\Models\GeneralEducation\Purchase;
use App\Models\GeneralEducation\Tag;
use App\Models\Live\Course;
use App\Models\Live\Entry;
use App\Models\UsersOperations\Basket;
use App\Models\UsersOperations\Favorite;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseRepository implements IRepository{
    public function all()
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{

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
            // kursu getir. Eğer kullanıcı giriş yapmışsa entry,basket ve fav verisini getir.
            $user = Auth::user();
            if($user == null){
                $object = Course::find($id);
            }
            else{
                $object = Course::find($id);
                $student = Student::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();

                $live_entry = Entry::where('student_id',$student->id)->where('live_course_id',$id)->where('deleted_at',null)->first();
                if($live_entry == null){
                    $object['inEntry'] = false;
                }
                else{
                    $object['inEntry'] = true;
                }

                $controlBasket = Basket::where('user_id',$user->id)->where('course_id',$id)->where('course_type','App\Models\Live\Course')->get();
                if($controlBasket != null and count($controlBasket) > 0){
                    $object['inBasket'] = true;
                }
                else{
                    $object['inBasket'] = false;
                }

                $controlFav = Favorite::where('user_id',$user->id)->where('course_id',$id)->where('course_type','App\Models\Live\Course')->get();
                if($controlFav != null and count($controlFav) > 0){
                    $object['inFavorite'] = true;
                }
                else{
                    $object['inFavorite'] = false;
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

    public function goalsPost($course_id,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            // var olanları sil yenilerini ekle
            if(isset($data['achievements'])){

            }
            if(isset($data['requirements'])){

            }
            if(isset($data['tags'])){

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

    public function getStudents($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Entry::where('live_course_id', $id)->where('deleted_at',null)->orderBy('created_at', 'desc')->take(3)->get();
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function allLiveCourses(){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('completed_at',null)->where('deleted_at',null)->get();
            $object['courseCount'] = count($object);

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
            // canlı yaynının başlayacağı en yakın tarihine göre sırala
            $object = Course::where('completed_at',null)->where('deleted_at',null)->orderBy('datetime', 'asc')->take(12)->get();
            if($user_id!=null){
                // bu kursların favori veya sepete eklenip eklenmediği bilgisini getir.
                foreach ($object as $key=> $course){

                    $student = Student::where('user_id',$user_id)->where('deleted_at',null)->first();
                    $controlEntry = Entry::where('student_id',$student->id)->where('live_course_id',$course->id)->where('deleted_at',null)->get();
                    if($controlEntry != null and count($controlEntry)>0){
                        $object[$key]['inEntry'] = true;
                    }
                    else{
                        $object[$key]['inEntry'] = false;
                    }

                    $controlBasket = Basket::where('course_id',$course->id)->where('user_id',$user_id)->where('course_type','App\Models\Live\Course')->first();
                    if($controlBasket != null)
                        $object[$key]['inBasket'] = true;
                    else
                        $object[$key]['inBasket'] = false;

                    $controlFavorite = Favorite::where('course_id',$course->id)->where('user_id',$user_id)->where('course_type','App\Models\Live\Course')->first();
                    if($controlFavorite != null)
                        $object[$key]['inFavorite'] = true;
                    else
                        $object[$key]['inFavorite'] = false;
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

                $student = Student::where('user_id',$user->id)->first();
                $controlEntry = Entry::where('student_id',$student->id)->where('live_course_id',$id)->where('deleted_at',null)->get();
                if($controlEntry != null and count($controlEntry)>0){
                    $object['inEntry'] = true;
                }
                else{
                    $object['inEntry'] = false;
                }

                $controlBasket = Basket::where('user_id',$user->id)->where('course_id',$id)->where('course_type','App\Models\Live\Course')->get();
                if($controlBasket != null and count($controlBasket) > 0){
                    $object['inBasket'] = true;
                }
                else{
                    $object['inBasket'] = false;
                }
                $controlFav = Favorite::where('user_id',$user->id)->where('course_id',$id)->where('course_type','App\Models\Live\Course')->get();
                if($controlFav != null and count($controlFav) > 0){
                    $object['inFavorite'] = true;
                }
                else{
                    $object['inFavorite'] = false;
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

   /* public function buy($courseId,$data){
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
            $object->course_type = 'App\Models\Live\Course';
            $object->price = $data['price'];
            $object->confirmation = true;
            $object->save();

            //  öğrenciyi entry tablosuna kaydet.
            $object = null;
            $object = new Entry();
            $object->course_id = $courseId;
            $object->course_type = 'App\Models\Live\Course';
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
    }*/

    public function inBasket($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        $control = DB::table('basket')->where('user_id',$user_id)
            ->where('course_id',$course_id)
            ->where('course_type','App\Models\Live\Course')->get();
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

    public function getSimilarCourses($id,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);

            $pe_tag = Tag::where('course_id',$id)->where('course_type','App\Models\Live\Course')->where('deleted_at',null)->get();
            $tags = array();
            foreach ($pe_tag as $item){
                array_push($tags,$item->tag);
            }
            $courses_tag = Tag::where('deleted_at',null)->where('course_type','App\Models\Live\Course')->whereIn('tag',$tags)->get();
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
                    $controlEntry = Entry::where('student_id',$student->id)->where('live_course_id',$item->id)->where('deleted_at',null)->get();
                    if($controlEntry != null and count($controlEntry)>0){
                        $object[$key]['inEntry'] = true;
                    }
                    else{
                        $object[$key]['inEntry'] = false;
                    }

                    $contorlBasket = DB::table('basket')->where('user_id',$user_id)->where('course_id',$item->id)->where('course_type','App\Models\Live\Course')->get();
                    if($contorlBasket !=  null and count($contorlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $contorlFav = DB::table('favorite')->where('user_id',$user_id)->where('course_id',$item->id)->where('course_type','App\Models\Live\Course')->get();
                    if($contorlFav !=  null and count($contorlFav) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
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

}
