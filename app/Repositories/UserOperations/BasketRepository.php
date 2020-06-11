<?php


namespace App\Repositories\UserOperations;


use App\Models\Auth\Instructor;
use App\Models\Auth\User;
use App\Models\Base\City;
use App\Models\Base\Country;
use App\Models\Base\District;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Entry;
use App\Models\GeneralEducation\Purchase;
use App\Models\Iyzico\BasketItems;
use App\Models\UsersOperations\Basket;
use App\Payment\Payment;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Iyzipay\Model\PaymentItem;

class BasketRepository implements IRepository
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

    public function add($data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {
            DB::beginTransaction();
            $basket = new Basket();
            $basket->user_id = $data['user_id'];
            $basket->course_id = $data['course_id'];
            if($data['module_name'] == 'generalEducation'){
                $basket->course_type = 'App\Models\GeneralEducation\Course';
            }
            else if($data['module_name'] == 'prepareLessons'){
                $basket->course_type = 'App\Models\PrepareLessons\Course';
            }
            else if($data['module_name'] == 'prepareExams'){
                $basket->course_type = 'App\Models\PrepareExams\Course';
            }
            else if($data['module_name'] == 'pre'){
            }
            else if($data['module_name'] == 'qb'){
            }
            else if($data['module_name'] == 'hw'){
            }
            $basket->save();

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

    public function remove($data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {
            DB::beginTransaction();

            $type = "";
            if($data['module_name'] == 'generalEducation')
                $type = "App\Models\GeneralEducation\Course";
            else if($data['module_name'] == 'prepareLessons')
                $type = "App\Models\PrepareLessons\Course";
            else if($data['module_name'] == 'prepareExams')
                $type = "App\Models\PrepareExams\Course";

            DB::table('basket')->where('user_id',$data['user_id'])
                ->where('course_id',$data['course_id'])
                ->where('course_type',$type)->delete();

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

    public function removeAll($user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {

            DB::table('basket')->where('user_id',$user_id)->delete();

        }catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function show($user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {

            $courses = Basket::where('user_id',$user_id)->get();
            foreach ($courses as $key => $item){
                if($item->course_type == "App\Models\GeneralEducation\Course"){
                    $courses[$key]['course_type'] = "generalEducation";
                    $course = Course::find($item->course_id);
                    $courses[$key]['course'] = $course;
                }
                else if($item->course_type == "App\Models\PrepareLessons\Course"){
                    $courses[$key]['course_type'] = "prepareLessons";
                    $course = \App\Models\PrepareLessons\Course::find($item->course_id);
                    $courses[$key]['course'] = $course;
                }
                else if($item->course_type == "App\Models\PrepareExams\Course"){
                    $courses[$key]['course_type'] = "prepareExams";
                    $course = \App\Models\PrepareExams\Course::find($item->course_id);
                    $courses[$key]['course'] = $course;
                }
            }
            $object = $courses;

        }catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function buy($userId,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {
            DB::beginTransaction();
            foreach ($data['cart'] as $item){
                // öğrenciyi purchase tablosuna kaydet.
                if($item['course_type'] == "generalEducation"){
                    $object = new Purchase();
                    $object->user_id =  $userId;
                    $user = User::find($userId);
                    $object->student_id = $user->student->id;
                    $object->course_id = $item['course_id'];
                    $object->course_type = 'App\Models\GeneralEducation\Course';
                    $object->price = $item['course']['price'];
                    $object->confirmation = true;
                    $object->save();

                    //  öğrenciyi entry tablosuna kaydet.
                    $object = null;
                    $object = new Entry();
                    $object->course_id = $item['course_id'];
                    $object->course_type = 'App\Models\GeneralEducation\Course';
                    $object->student_id = $user->student->id;

                    $course = \App\Models\GeneralEducation\Course::find($item['course_id']);
                    $today = date("Y/m/d");
                    $accessTime = $course->access_time;
                    $d = new \DateTime();
                    $object->access_start = $d->format('Y-m-d');
                    $object->access_finish = date('Y-m-d', strtotime('+ '.$accessTime.' months', strtotime($today)));
                    $object->active = true;
                    $object->save();
                }
                else if($item['course_type'] == "prepareLessons"){
                    $object = new Purchase();
                    $object->user_id =  $userId;
                    $user = User::find($userId);
                    $object->student_id = $user->student->id;
                    $object->course_id = $item['course_id'];
                    $object->course_type = 'App\Models\PrepareLessons\Course';
                    $object->price = $item['course']['price'];
                    $object->confirmation = true;
                    $object->save();

                    //  öğrenciyi entry tablosuna kaydet.
                    $object = null;
                    $object = new Entry();
                    $object->course_id = $item['course_id'];
                    $object->course_type = 'App\Models\PrepareLessons\Course';
                    $object->student_id = $user->student->id;

                    $course = \App\Models\PrepareLessons\Course::find($item['course_id']);
                    $today = date("Y/m/d");
                    $accessTime = $course->access_time;
                    $d = new \DateTime();
                    $object->access_start = $d->format('Y-m-d');
                    $object->access_finish = date('Y-m-d', strtotime('+ '.$accessTime.' months', strtotime($today)));
                    $object->active = true;
                    $object->save();
                }
                else if($item['course_type'] == "prepareExams"){
                    $object = new Purchase();
                    $object->user_id =  $userId;
                    $user = User::find($userId);
                    $object->student_id = $user->student->id;
                    $object->course_id = $item['course_id'];
                    $object->course_type = 'App\Models\PrepareExams\Course';
                    $object->price = $item['course']['price'];
                    $object->confirmation = true;
                    $object->save();

                    //  öğrenciyi entry tablosuna kaydet.
                    $object = null;
                    $object = new Entry();
                    $object->course_id = $item['course_id'];
                    $object->course_type = 'App\Models\PrepareExams\Course';
                    $object->student_id = $user->student->id;

                    $course = \App\Models\PrepareExams\Course::find($item['course_id']);
                    $today = date("Y/m/d");
                    $accessTime = $course->access_time;
                    $d = new \DateTime();
                    $object->access_start = $d->format('Y-m-d');
                    $object->access_finish = date('Y-m-d', strtotime('+ '.$accessTime.' months', strtotime($today)));
                    $object->active = true;
                    $object->save();
                }
            }

            // delete all data that user has
            DB::table('basket')->where('user_id',$userId)->delete();
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function referenceControl($referenceCode){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {

            $instructor = Instructor::where('reference_code',$referenceCode)->where('active',true)
                ->where('deleted_at',null)->first();
            if($instructor != null){
                $object = true;
            }
            else{
                $object = false;
            }

        }catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function checkOut($data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {
            DB::beginTransaction();
            #preapre checkOut methot
            $ip = Request::ip();
            $basket = Basket::where('user_id',$data['user_id'])->get();
            $courses = array();
            foreach ($basket as $item){
                if($item->course_type == "App\Models\GeneralEducation\Course"){
                    $course = Course::find($item->course_id);
                    array_push($courses,$course);
                }
                else if($item->course_type == "App\Models\PrepareLessons\Course"){
                    $course = \App\Models\PrepareLessons\Course::find($item->course_id);
                    array_push($courses,$course);
                }
                else if($item->course_type == "App\Models\PrepareExams\Course"){
                    $course = \App\Models\PrepareExams\Course::find($item->course_id);
                    array_push($courses,$course);
                }
            }
            #create iyzico_basket and iyzico_basket_items
            $iyzicoBasket = new \App\Models\Iyzico\Basket();
            $iyzicoBasket->save();

            for($i = 0;$i<count($courses);$i++){
                $iyzicoBasketItems = new BasketItems();
                $iyzicoBasketItems->iyzico_basket_id = $iyzicoBasket->id;
                $iyzicoBasketItems->save();
            }

            $data['is_discount'] = false;
            if($data['coupon'] != "null"){
                $data['is_discount'] = true;
            }
            $payment = new Payment();
            $payment_result = $payment->checkOut($data['user_id'],$data['first_name'],$data['last_name'],$data['phone_number'],$data['email'],$data['identity_number'],
                $ip,$data['city'],$data['zip_code'],$data['country'],$data['address'],$courses,$data['is_discount'],$iyzicoBasket->id);

            if($payment_result->getStatus() == "success"){
                $object = array();
                $object['checkout_form_content'] = $payment_result->getCheckoutFormContent();
                $object['basket_id'] = $payment_result->getConversationId();
                $object['token'] = $payment_result->getToken();

                $iyzicoBasket->token = $payment_result->getToken();
                $iyzicoBasket->save();
            }
            else{
                $result = false;
                $error = 'Hata Kodu: '.$payment_result->getErrorCode();
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            $error = " ";
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function result($data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {
            DB::beginTransaction();
            $payment = new Payment();
            $payment_result = $payment->result($data['token']);

            if($payment_result->getStatus() == "success"){
                if($payment_result->getPaymentStatus() == "SUCCESS"){
                    $object = true;
                    // iyzico basket'i güncelle
                    $iyzicoBasket = \App\Models\Iyzico\Basket::where('token',$data['token'])->where('deleted_at',null)->first();
                    $iyzicoBasket->status = $payment_result->getStatus();
                    $iyzicoBasket->price = $payment_result->getPrice();
                    $iyzicoBasket->payment_status = $payment_result->getPaymentStatus();
                    $iyzicoBasket->error_message = $payment_result->getErrorMessage();
                    $iyzicoBasket->payment_id = $payment_result->getPaymentId();
                    $iyzicoBasket->fraud_status = $payment_result->getFraudStatus();
                    $iyzicoBasket->iyzico_comission_fee = $payment_result->getIyziCommissionFee();
                    $iyzicoBasket->save();

                    // iyzico basket itemi güncelle
                    $iyzicoBasketItems = BasketItems::where('iyzico_basket_id',$iyzicoBasket->id)->where('deleted_at',null)->get();
                    $paymentItems = $payment_result->getPaymentItems();
                    $coursesId = array();
                    $coursesType = array();
                    $coursesPrice = array();
                    for($i=0;$i<count($iyzicoBasketItems);$i++){

                        $itemId = $paymentItems[$i]->getItemId();
                        $exp = explode('-',$itemId);
                        $type = $exp[0];
                        $course_type = null;
                        if($type == "ge"){
                            $course_type = "App\Models\GeneralEducation\Course";
                        }
                        else if($type == "pl"){
                            $course_type = "App\Models\PrepareLessons\Course";
                        }
                        else if($type == "pe"){
                            $course_type = "App\Models\PrepareExams\Course";
                        }
                        $course_id = $exp[1];

                        array_push($coursesId,$course_id);
                        array_push($coursesType,$course_type);
                        array_push($coursesPrice,$paymentItems[$i]->getPaidPrice());

                        $iyzicoBasketItems[$i]->item_id = $paymentItems[$i]->getItemId();
                        $iyzicoBasketItems[$i]->course_type = $course_type;
                        $iyzicoBasketItems[$i]->course_id = $course_id;
                        $iyzicoBasketItems[$i]->price = $paymentItems[$i]->getPaidPrice();
                        $iyzicoBasketItems[$i]->payment_transaction_id = $paymentItems[$i]->getPaymentTransactionId();
                        $iyzicoBasketItems[$i]->transaction_status = $paymentItems[$i]->getTransactionStatus();
                        $iyzicoBasketItems[$i]->confirmation = true;
                        $iyzicoBasketItems[$i]->save();
                    }

                    // ge_purchase ve ge_entries tablosuna ekle
                    for($i=0;$i<count($coursesId);$i++){
                        // öğrenciyi purchase tablosuna kaydet.
                        if($coursesType[$i] == "App\Models\GeneralEducation\Course"){
                            $object = new Purchase();
                            $object->user_id =  $data['user_id'];
                            $user = User::find($data['user_id']);
                            $object->student_id = $user->student->id;
                            $object->course_id = $coursesId[$i];
                            $object->course_type = 'App\Models\GeneralEducation\Course';
                            $object->price = $coursesPrice[$i];
                            $object->confirmation = true;
                            $object->save();

                            //  öğrenciyi entry tablosuna kaydet.
                            $object = null;
                            $object = new Entry();
                            $object->course_id = $coursesId[$i];
                            $object->course_type = 'App\Models\GeneralEducation\Course';
                            $object->student_id = $user->student->id;

                            $course = \App\Models\GeneralEducation\Course::find($coursesId[$i]);
                            $today = date("Y/m/d");
                            $accessTime = $course->access_time;
                            $d = new \DateTime();
                            $object->access_start = $d->format('Y-m-d');
                            $object->access_finish = date('Y-m-d', strtotime('+ '.$accessTime.' months', strtotime($today)));
                            $object->active = true;
                            $object->save();
                        }
                        else if($coursesType[$i] == "App\Models\PrepareLessons\Course"){
                            $object = new Purchase();
                            $object->user_id =  $data['user_id'];
                            $user = User::find($data['user_id']);
                            $object->student_id = $user->student->id;
                            $object->course_id = $coursesId[$i];
                            $object->course_type = 'App\Models\PrepareLessons\Course';
                            $object->price = $coursesPrice[$i];
                            $object->confirmation = true;
                            $object->save();

                            //  öğrenciyi entry tablosuna kaydet.
                            $object = null;
                            $object = new Entry();
                            $object->course_id = $coursesId[$i];
                            $object->course_type = 'App\Models\PrepareLessons\Course';
                            $object->student_id = $user->student->id;

                            $course = \App\Models\PrepareLessons\Course::find($coursesId[$i]);
                            $today = date("Y/m/d");
                            $accessTime = $course->access_time;
                            $d = new \DateTime();
                            $object->access_start = $d->format('Y-m-d');
                            $object->access_finish = date('Y-m-d', strtotime('+ '.$accessTime.' months', strtotime($today)));
                            $object->active = true;
                            $object->save();
                        }
                        else if($coursesType[$i] == "App\Models\PrepareExams\Course"){
                            $object = new Purchase();
                            $object->user_id =  $data['user_id'];;
                            $user = User::find($data['user_id']);
                            $object->student_id = $user->student->id;
                            $object->course_id = $coursesId[$i];
                            $object->course_type = 'App\Models\PrepareExams\Course';
                            $object->price = $coursesPrice[$i];
                            $object->confirmation = true;
                            $object->save();

                            //  öğrenciyi entry tablosuna kaydet.
                            $object = null;
                            $object = new Entry();
                            $object->course_id = $coursesId[$i];;
                            $object->course_type = 'App\Models\PrepareExams\Course';
                            $object->student_id = $user->student->id;

                            $course = \App\Models\PrepareExams\Course::find($coursesId[$i]);
                            $today = date("Y/m/d");
                            $accessTime = $course->access_time;
                            $d = new \DateTime();
                            $object->access_start = $d->format('Y-m-d');
                            $object->access_finish = date('Y-m-d', strtotime('+ '.$accessTime.' months', strtotime($today)));
                            $object->active = true;
                            $object->save();
                        }
                    }
                    $basket = Basket::where('user_id',$data['user_id'])->get();
                    foreach ($basket as $item){
                        $item->delete();
                    }
                   $object = true;
                }
                else{
                    $error = $payment_result->getErrorCode();
                    $object = false;
                }
            }
            else{
                $result = false;
                $error = $payment_result->getErrorCode();
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            $error = " ";
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
}
