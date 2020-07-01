<?php


namespace App\Repositories\Live;


use App\Models\Auth\Student;
use App\Models\Live\Course;
use App\Models\Live\Entry;
use App\Models\UsersOperations\Basket;
use App\Models\UsersOperations\Favorite;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\Auth;

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
            $object = Entry::where('live_course_id', $id)->orderBy('created_at', 'desc')->take(3)->get();
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
}
