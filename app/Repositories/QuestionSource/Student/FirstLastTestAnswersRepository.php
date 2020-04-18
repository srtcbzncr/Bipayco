<?php


namespace App\Repositories\QuestionSource\Student;


use App\Models\Auth\Student;
use App\Models\QuestionSource\Student\FirstLastTestAnswers;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FirstLastTestAnswersRepository implements IRepository
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
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $userId = Auth::id();
            $student = Student::where('user_id',$userId)->first();

            foreach ($data as $item){
                $object = new FirstLastTestAnswers();
                $object->studentId = $student->id;
                $object->questionId = $item['questionId'];
                $object->result = $item['result'];
                $object->save();
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
