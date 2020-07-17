<?php


namespace App\Repositories\Live;


use App\Models\Auth\Instructor;
use App\Models\Auth\Student;
use App\Models\Auth\User;
use App\Models\Live\Course;
use App\Models\Live\Entry;
use App\Models\UsersOperations\Basket;
use App\Models\UsersOperations\Favorite;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use BigBlueButton\Parameters\CreateMeetingParameters;
use JoisarJignesh\Bigbluebutton\Facades\Bigbluebutton;

class LiveRepository  implements IRepository{

    public function all()
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('deleted_at',null)->where('completed_at',null)->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function allLives($user_id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('deleted_at',null)->where('completed_at',null)->paginate(9);
            foreach ($object as $key => $item){
                $basketControl = Basket::where('user_id',$user_id)->where('course_id',$item->id)->where('course_type','App\Models\Live\Course')->get();
                if($basketControl!=null and count($basketControl)>0){
                    $object[$key]['inBasket'] = true;
                }
                else{
                    $object[$key]['inBasket'] = false;
                }

                $favoriteControl = Favorite::where('user_id',$user_id)->where('course_id',$item->id)->where('course_type','App\Models\Live\Course')->get();
                if($favoriteControl!=null and count($favoriteControl)>0){
                    $object[$key]['inFavorite'] = true;
                }
                else{
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

    public function createLiveOnBipayco($data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = new Course();
            $imagePath = Storage::url($data['image']->store('public/images'));
            $object->image = $imagePath;
            $object->name = $data['name'];
            $object->description = $data['description'];
            $object->price = $data['price'];
            $object->price_with_discount = $data['price_with_discount'];
            $object->datetime = $data['datetime'];
            $object->max_participant = $data['max_participant'];
            $object->attendee_pw = uniqid('at'.random_int(100,999), false);
            $object->moderator_pw = uniqid('mo'.random_int(100,999), false);
            $object->record = false;
            $object->duration = $data['duration'];
            $object->meeting_id = uniqid('mi'.random_int(100,999), false);
            $object->save();

            //$user = User::find($data['user_id']);
            $instructor = Instructor::where('user_id',$data['user_id'])->where('active',true)->where('deleted_at',null)->first();
            DB::table('ge_courses_instructors')->insert([
                'course_id' => $object->id,
                'course_type' => 'App\Models\Live\Course',
                'instructor_id' => $instructor->id,
                'is_manager' => true,
                'percent' => 100,
                'active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
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

    public function updateLiveOnBipayco($course_id,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Course::find($course_id);
            if(file_exists($data['image'])){
                $imagePath = Storage::url($data['image']->store('public/images'));
                $object->image = $imagePath;
            }
            $object->name = $data['name'];
            $object->description = $data['description'];
            $object->price = $data['price'];
            $object->price_with_discount = $data['price_with_discount'];
            $object->datetime = $data['datetime'];
            $object->max_participant = $data['max_participant'];
            $object->duration = $data['duration'];
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

    public function createLiveOnBBB($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $flag = false;
            $instructor = Instructor::where('user_id',$user_id)->where('active',true)->where('deleted_at',null)->first();
            if($instructor!=null){
                $ge_instructor_course = DB::table('ge_courses_instructors')->where('course_id',$course_id)
                    ->where('course_type','App\Models\Live\Course')->where('instructor_id',$instructor->id)
                    ->where('active',true)->where('deleted_at',null)->first();
                if($ge_instructor_course!=null){
                    $flag = true;
                }
            }

            if($flag==false){
                $result = false;
                $error = 'Eğitmen kimlik doğrulama hatası';
            }
            else{
                $live = Course::find($course_id);
                $now = Carbon::now();
                // zaman kontrolü
                if($live->datetime <= $now->toDateTimeString()){
                    $params = new CreateMeetingParameters($live->meeting_id, $live->name);
                    $params->setModeratorPassword($live->moderator_pw);
                    $params->setAttendeePassword($live->attendee_pw);
                    $params->setDuration($live->duration);
                    $params->setMaxParticipants($live->max_participant);
                    $params->setEndCallbackUrl('https://www.bipayco.com/api/live/end_meeting/'.$live->meeting_id);
                    $params->setLogoutUrl('https://www.bipayco.com');

                    $params->setBreakout(false); # dinlenme odası yok bu yüzden aşağıdaki brekout verileri direkt default 0 verdim.
                    $params->setFreeJoin(false);

                    $object=BigBlueButton::create($params);
                }
                else{
                    $error = "Canlı yayın zamanı henüz gelmediği için başlatamazsınız.";
                    $result = false;
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

    public function joinLive($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $user = User::find($user_id);
            $live = Course::find($course_id);
            $instructor = Instructor::where('user_id',$user_id)->where('active',true)->where('deleted_at',null)->first();
            if($instructor!=null){
                $control = DB::table('ge_courses_instructors')->where('course_id',$course_id)->where('course_type', 'App\Models\Live\Course')
                    ->where('instructor_id',$instructor->id)->where('active',true)->where('deleted_at',null)->first();
                if($control!=null){
                    $object=BigBlueButton::join([
                        'meetingID' => $live->meeting_id,
                        'userName' => $user->first_name.' '.$user->last_name,
                        'password' => $live->moderator_pw, //which user role want to join set password here
                        'redirect' => true, //it will not redirect into bigblueservr
                    ]);
                }
                else{
                    $student = Student::where('user_id',$user_id)->where('active',true)->where('deleted_at',null)->first();
                    $live_entry_control = Entry::where('student_id',$student->id)->where('live_course_id',$course_id)->where('deleted_at',null)->first();
                    if($live_entry_control!=null){
                        $object=BigBlueButton::join([
                            'meetingID' => $live->meeting_id,
                            'userName' => $user->first_name.' '.$user->last_name,
                            'password' => $live->attendee_pw, //which user role want to join set password here
                            'redirect' => true, //it will not redirect into bigblueservr
                        ]);
                    }
                    else{
                        $error = 'Kursa sahip olmadığın için katılamazsın';
                        $result = false;
                    }
                }
            }
            else{
                $student = Student::where('user_id',$user_id)->where('active',true)->where('deleted_at',null)->first();
                $live_entry_control = Entry::where('student_id',$student->id)->where('live_course_id',$course_id)->where('deleted_at',null)->first();
                if($live_entry_control!=null){
                    $object=BigBlueButton::join([
                        'meetingID' => $live->meeting_id,
                        'userName' => $user->first_name.' '.$user->last_name,
                        'password' => $live->attendee_pw, //which user role want to join set password here
                        'redirect' => true, //it will not redirect into bigblueservr
                    ]);
                }
                else{
                    $error = 'Kursa sahip olmadığın için katılamazsın';
                    $result = false;
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
}
