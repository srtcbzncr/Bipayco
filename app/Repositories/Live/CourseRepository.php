<?php


namespace App\Repositories\Live;


use App\Models\Auth\Instructor;
use App\Models\Auth\Student;
use App\Models\Auth\User;
use App\Models\GeneralEducation\Achievement;
use App\Models\GeneralEducation\Purchase;
use App\Models\GeneralEducation\Requirement;
use App\Models\GeneralEducation\Tag;
use App\Models\Live\Course;
use App\Models\Live\Entry;
use App\Models\UsersOperations\Basket;
use App\Models\UsersOperations\Favorite;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JoisarJignesh\Bigbluebutton\Facades\Bigbluebutton;

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
            $error = $e->getMessage();;
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

                $achs = Achievement::where('course_id',$id)->where('course_type','App\Models\Live\Course')->where('active',true)->where('deleted_at',null)->get();
                $reqs = Requirement::where('course_id',$id)->where('course_type','App\Models\Live\Course')->where('active',true)->where('deleted_at',null)->get();
                $tags = Tag::where('course_id',$id)->where('course_type','App\Models\Live\Course')->where('deleted_at',null)->get();
                $object['achievements'] = $achs;
                $object['requirements'] = $reqs;
                $object['tags'] = $tags;

                $ge_instructor = DB::table('ge_courses_instructors')->where('course_id',$id)->where('course_type','App\Models\Live\Course')
                    ->where('is_manager',true)->where('active',true)->where('deleted_at',null)->first();
                $instructor = Instructor::find($ge_instructor->instructor_id);
                $instructor['user'] = User::find($instructor->user_id);
                $object['instructor'] = $instructor;
            }
            else{
                $object = Course::find($id);

                // kurs başladımı kontrol (is_meeting?)
                $is_meeting=Bigbluebutton::isMeetingRunning([
                    'meetingID' => $object->meeting_id,
                ]);
                $object['isMeeting'] = $is_meeting;

                $achs = Achievement::where('course_id',$id)->where('course_type','App\Models\Live\Course')->where('active',true)->where('deleted_at',null)->get();
                $reqs = Requirement::where('course_id',$id)->where('course_type','App\Models\Live\Course')->where('active',true)->where('deleted_at',null)->get();
                $tags = Tag::where('course_id',$id)->where('course_type','App\Models\Live\Course')->where('deleted_at',null)->get();
                $object['achievements'] = $achs;
                $object['requirements'] = $reqs;
                $object['tags'] = $tags;

                $ge_instructor = DB::table('ge_courses_instructors')->where('course_id',$id)->where('course_type','App\Models\Live\Course')
                    ->where('is_manager',true)->where('active',true)->where('deleted_at',null)->first();
                $instructor = Instructor::find($ge_instructor->instructor_id);
                $instructor['user'] = User::find($instructor->user_id);
                $object['instructor'] = $instructor;


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
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $course = Course::find($id);
            $course->delete();
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

    public function goalsPost($course_id,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            // var olanları sil yenilerini ekle
            DB::beginTransaction();

            $tempAchievements = Achievement::where('course_id',$course_id)->where('course_type','App\Models\Live\Course')
                ->where('active',true)->where('deleted_at',null)->get();
            foreach ($tempAchievements as $achievement){
                $achievement->delete();
            }

            $tempRequirements = Requirement::where('course_id',$course_id)->where('course_type','App\Models\Live\Course')
                ->where('active',true)->where('deleted_at',null)->get();
            foreach ($tempRequirements as $requirement){
                $requirement->delete();
            }

            $tempTags = Tag::where('course_id',$course_id)->where('course_type','App\Models\Live\Course')->where('deleted_at',null)->get();
            foreach ($tempTags as $tag){
                $tag->delete();
            }

            if(isset($data['achievements']) && $data['achievements']!=null){
                $achievements = explode(',',$data['achievements']);
                foreach ($achievements as $achievement){
                    $temp = new Achievement();
                    $temp->course_id = $course_id;
                    $temp->course_type = 'App\Models\Live\Course';
                    $temp->content = $achievement;
                    $temp->active = true;
                    $temp->save();
                }
            }
            if(isset($data['requirements']) && $data['requirements']!=null){
                $requirements = explode(',',$data['requirements']);
                foreach ($requirements as $requirement){
                    $temp = new Requirement();
                    $temp->course_id = $course_id;
                    $temp->course_type = 'App\Models\Live\Course';
                    $temp->content = $requirement;
                    $temp->active = true;
                    $temp->save();
                }
            }
            if(isset($data['tags']) && $data['tags']!=null){
                $tags = explode(',',$data['tags']);
                foreach ($tags as $tag){
                    $temp = new Tag();
                    $temp->course_id = $course_id;
                    $temp->course_type = 'App\Models\Live\Course';
                    $temp->tag = $tag;
                    $temp->save();
                }
            }
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function goalsGet($course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            // var olanları sil yenilerini ekle
            DB::beginTransaction();

            $tempAchievements = Achievement::where('course_id',$course_id)->where('course_type','App\Models\Live\Course')
                ->where('active',true)->where('deleted_at',null)->get();

            $tempRequirements = Requirement::where('course_id',$course_id)->where('course_type','App\Models\Live\Course')
                ->where('active',true)->where('deleted_at',null)->get();

            $tempTags = Tag::where('course_id',$course_id)->where('course_type','App\Models\Live\Course')->where('deleted_at',null)->get();

            $object = array();
            $object['achievements'] = $tempAchievements;
            $object['requirements'] = $tempRequirements;
            $object['tags'] = $tempTags;
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();;
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
            $error = $e->getMessage();;
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
            $error = $e->getMessage();;
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
                if($item->course_id!=$id){
                    $temp_course = Course::find($item->course_id);
                    array_push($temp_courses,$temp_course);
                }

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
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function instructorsGet($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = array();

        // Operations
        try{
            $ge_courses_instructor = DB::table('ge_courses_instructors')->where('course_id',$id)->where('course_type','App\Models\Live\Course')
                ->where('active',true)->where('deleted_at',null)->first();
            $instructor = Instructor::find($ge_courses_instructor->instructor_id);
            $user = User::find($instructor->user_id);

            $instructor['user'] = $user;
            $instructor['percent'] = $ge_courses_instructor->percent;
            $instructor['is_manager'] = true;
            $object = $instructor;
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
