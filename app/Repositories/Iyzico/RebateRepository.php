<?php


namespace App\Repositories\Iyzico;


use App\Models\Auth\Student;
use App\Models\GeneralEducation\Entry;
use App\Models\GeneralEducation\Lesson;
use App\Models\GeneralEducation\Purchase;
use App\Models\GeneralEducation\Rebate;
use App\Models\GeneralEducation\Section;
use App\Models\Iyzico\BasketItems;
use App\Payment\Payment;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class RebateRepository implements IRepository
{

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
        // iade oluşturacağız
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            // coursun iade olabilme şartını kontrol et.
            $progress = 0;
            $user_id = $data['user_id'];
            $course_id = $data['course_id'];
            $student = $data['student_id'];
            $course_type = null;
            if($data['course_type'] == "ge"){
                $course_type = 'App\Models\GeneralEducation\Lesson';
            }
            else if($data['course_type'] == "pl"){
                $course_type = 'App\Models\PrepareLessons\Lesson';
            }
            else if($data['course_type'] == "pe"){
                $course_type = 'App\Models\PrepareExams\Lesson';
            }

            // prepare
            $purchase = Purchase::find($data['purchases_id']);

            if($data['course_type'] == "ge"){
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
                $progress = ($completeCount/count($lessons))*100;
            }
            else if($data['course_type'] == "pl"){
                $sections = \App\Models\PrepareLessons\Section::where('course_id',$course_id)->where('deleted_at',null)->where('active',true)->get()->toArray();
                $lessons = array();
                foreach ($sections as $section){
                    $tempLessons = \App\Models\PrepareLessons\Lesson::where('section_id',$section['id'])->where('deleted_at',null)->where('active',true)->get()->toArray();
                    foreach ($tempLessons as $lesson){
                        array_push($lessons,$lesson);
                    }

                }

                // tamamlanmış dersleri al
                $completedLessons = DB::table('ge_students_completed_lessons')
                    ->where('student_id',$student->id)
                    ->where('lesson_type','App\Models\PrepareLessons\Lesson')->get();
                $completeCount = 0;
                foreach ($lessons as $lesson){
                    foreach ($completedLessons as $completedLessonn){
                        if($lesson['id'] == $completedLessonn->lesson_id){;
                            $completeCount = $completeCount + 1;
                            break;
                        }
                    }
                }
                $progress = ($completeCount/count($lessons))*100;
            }
            else if($data['course_type'] == "pe"){
                $sections = \App\Models\PrepareExams\Section::where('course_id',$course_id)->where('deleted_at',null)->where('active',true)->get()->toArray();
                $lessons = array();
                foreach ($sections as $section){
                    $tempLessons = \App\Models\PrepareExams\Lesson::where('section_id',$section['id'])->where('deleted_at',null)->where('active',true)->get()->toArray();
                    foreach ($tempLessons as $lesson){
                        array_push($lessons,$lesson);
                    }

                }

                // tamamlanmış dersleri al
                $completedLessons = DB::table('ge_students_completed_lessons')
                    ->where('student_id',$student->id)
                    ->where('lesson_type','App\Models\PrepareExams\Lesson')->get();
                $completeCount = 0;
                foreach ($lessons as $lesson){
                    foreach ($completedLessons as $completedLessonn){
                        if($lesson['id'] == $completedLessonn->lesson_id){;
                            $completeCount = $completeCount + 1;
                            break;
                        }
                    }
                }
                $progress = ($completeCount/count($lessons))*100;
            }

            if($progress > 30){
                // iade başarısız.
                $result = false;
                $error = "%30 oranında ders izleme durumunda iade yapılamamaktadır.";
            }
            else{
                //rebate oluştur.
                $rebate = new Rebate();
                $rebate->user_id = $user_id;
                $rebate->purchase_id = $purchase->id;
                $rebate->message = $data['message'];
                $rebate->rebate_status = 0;
                $rebate->confirmation = false;
                $rebate->price = $purchase->price;
                $rebate->save();

                //iyzico_basket_items tablosundna iade edilecek ürünü getir.
                $iyzico_basket_items = BasketItems::where('purchase_id',$purchase->id)->where('course_type',$course_type)->where('course_id',$course_id)->where('confirmation',true)->where('deleted_at',null)->first();

                // iyzico iade oluştur.
                $payment = new Payment();
                $payment_result=$payment->rebate(Request::ip(),$purchase->price,$iyzico_basket_items->payment_transaction_id,$rebate->id);
                if($payment_result->getStatus() == "success"){
                    // iade başarılı
                    $rebate_update = Rebate::find($rebate->id);
                    $rebate_update->payment_id = $payment_result->getPaymentId();
                    $rebate_update->payment_transaction_id = $payment_result->getPaymentTransactionId();
                    $rebate_update->rebate_status = 1;
                    $rebate_update->confirmation = true;
                    $rebate_update->save();

                    // purchase ve entry tablosundan sil
                    $purchase_delete = Purchase::find($purchase->id);
                    $purchase_delete->delete();

                    $entry_delete = Entry::where('course_id',$course_id)->where('course_type',$course_type)->where('student_id',$student->id)->where('deleted_at',null)->first();
                    $entry_delete->delete();
                }
                else{
                    // iade başarısız
                    $rebate_update = Rebate::find($rebate->id);
                    $rebate_update->payment_id = $payment_result->getPaymentId();
                    $rebate_update->payment_transaction_id = $payment_result->getPaymentTransactionId();
                    $rebate_update->rebate_status = -1;
                    $rebate_update->confirmation = false;
                    $rebate_update->save();
                    $result = false;
                    $error = $payment_result->getErrorCode();
                }
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
}
