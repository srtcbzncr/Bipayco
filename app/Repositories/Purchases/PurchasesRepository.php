<?php


namespace App\Repositories\Purchases;


use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Purchase;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Carbon\Carbon;

class PurchasesRepository implements IRepository
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
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $purchases = Purchase::where('user_id',$id)->where('deleted_at',null)->orderBy('created_at','desc')->paginate(10);
            foreach ($purchases as $key => $item){
                if($item->course_type == 'App\Models\GeneralEducation\Course'){
                    $course = Course::find($item->course_id);
                    $course['course_type'] = "generalEducation";

                    $now = Carbon ::now();
                    $created_at = Carbon ::parse($item->created_at);

                    if($created_at->diffInDays($now, false)>30){
                        $course['isRebate'] = false;
                    }
                    else{
                        $course['isRebate'] = true;
                    }
                    $purchases[$key]['course'] = $course;
                }
                else if($item->course_type == 'App\Models\PrepareLessons\Course'){
                    $course = \App\Models\PrepareLessons\Course::find($item->course_id);
                    $course['course_type'] = "prepareLessons";
                    $now = Carbon ::now();
                    $created_at = Carbon ::parse($item->created_at);

                    if($created_at->diffInDays($now, false)>30){
                        $course['isRebate'] = false;
                    }
                    else{
                        $course['isRebate'] = true;
                    }
                    $purchases[$key]['course'] = $course;
                }
                else if($item->course_type == 'App\Models\PrepareExams\Course'){
                    $course = \App\Models\PrepareExams\Course::find($item->course_id);
                    $course['course_type'] = "prepareExams";
                    $now = Carbon ::now();
                    $created_at = Carbon ::parse($item->created_at);

                    if($created_at->diffInDays($now, false)>30){
                        $course['isRebate'] = false;
                    }
                    else{
                        $course['isRebate'] = true;
                    }
                    $purchases[$key]['course'] = $course;
                }
            }
            $object = $purchases;
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
}
