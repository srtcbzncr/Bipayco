<?php


namespace App\Repositories\Admin;


use App\Events\Auth\AdminRegisterEvent;
use App\Models\Auth\Admin;
use App\Models\Auth\Guardian;
use App\Models\Auth\Instructor;
use App\Models\Auth\Student;
use App\Models\Auth\User;
use App\Models\GeneralEducation\Purchase;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;

class AuthRepository implements IRepository {

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

    public function createAdmin($data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = new Admin();
            $user = User::where('email',$data['email'])->first();
            $object->authority_id = $data['authorityId'];
            $object->user_id = $user->id;
            $object->active = $data['active'];
            $object->reference_code = uniqid('ad'.random_int(100,999), false);
            $object->save();

            // event tetikle kullanıcıya admin olarak eklendiğine dair.
            $eventData = array();
            $eventData['name'] = $user->first_name.' '.$user->last_name;
            $eventData['mail'] = $data['email'];
            event(new AdminRegisterEvent($eventData));
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

    public function deleteAdmin($adminId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Admin::find($adminId);
            $object->delete();
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

    public function activeAdmin($adminId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Admin::find($adminId);
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

    public function passiveAdmin($adminId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Admin::find($adminId);
            $object->active = false;
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

    public function showAdmins(){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object=Admin::where('deleted_at',null)
                ->paginate(10);
            foreach ($object as $key=>$item){
                $user = User::find($item->user_id);
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

    public function getAdmin($adminId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Admin::find($adminId);
            $user = User::find($object->user_id);
            $object['user'] = $user;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function showStudents(){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object=Student::where('deleted_at',null)
                ->paginate(10);
            foreach ($object as $key=> $item){
                $user = User::find($item->user_id);
                // toplam harcama bilgisini ekle
                $total = 0;
                $purchases = Purchase::where('user_id',$user->id)->where('deleted_at',null)->get();
                foreach ($purchases as $purchase){
                    $total = $total + $purchase->price;
                }
                $user['totalSpend'] = $total;

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

    public function getStudent($studentId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Student::find($studentId);
            $user = User::find($object->user_id);
            $object['user'] = $user;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function activeStudent($studentId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Student::find($studentId);
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

    public function passiveStudent($studentId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Student::find($studentId);
            $object->active = false;
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

    public function deleteStudent($studentId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Student::find($studentId);
            $object->delete();
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

    public function showInstructors(){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object=Instructor::where('deleted_at',null)
                ->paginate(10);
            foreach ($object as $key=>$item){
                $user = User::find($item->user_id);

                // toplam kazançları al
                $totalEarn = 0;
                $ge_instructors = DB::table('ge_courses_instructors')->where('instructor_id',$item->id)->where('active',true)->where('deleted_at',null)->get();
                foreach ($ge_instructors as $ge_instructor){
                    $total = 0;
                    $ge_purchases = Purchase::where('course',$ge_instructor->course_id)->where('course_type',$ge_instructor->course_type)->where('confirmation',true)->where('deleted_at',null)->get();
                    foreach ($ge_purchases as $purchase){
                        $total = $total + $purchase->price;
                    }
                    $totalEarn = $totalEarn + (($total*$ge_instructor->percent)/100);
                }
                $user['totalEearn'] = $totalEarn;

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

    public function getInstructor($instructorId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Instructor::find($instructorId);
            $user = User::find($object->user_id);
            $object['user'] = $user;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function activeInstructor($instructorId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Instructor::find($instructorId);
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

    public function passiveInstructor($instructorId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Instructor::find($instructorId);
            $object->active = false;
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

    public function deleteInstructor($instructorId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Instructor::find($instructorId);
            $object->delete();
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

    public function showGuardians(){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object=Guardian::where('deleted_at',null)
                ->paginate(10);
            foreach ($object as $key=>$item){
                $user = User::find($item->user_id);
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

    public function getGuardian($guardianId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Guardian::find($guardianId);
            $user = User::find($object->user_id);
            $object['user'] = $user;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function activeGuardian($guardianId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Guardian::find($guardianId);
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

    public function passiveGuardian($guardianId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Guardian::find($guardianId);
            $object->active = false;
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

    public function deleteGuardian($guardianId){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Guardian::find($guardianId);
            $object->delete();
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
