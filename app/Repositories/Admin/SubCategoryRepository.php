<?php


namespace App\Repositories\Admin;


use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\SubCategory;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SubCategoryRepository implements IRepository
{

    public function all()
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = DB::table('ge_sub_categories')->where('deleted_at',null)->paginate(10);
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
            $object = SubCategory::find($id);
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
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = new SubCategory();
            $object->category_id = $data['categoryId'];
            $object->description = $data['description'];
            $object->name = $data['name'];
            $object->color = $data['color'];
            $object->symbol = $data['symbol'];
            $filePath = $data['image']->store('public/images');
            $accessPath = Storage::url($filePath);
            $object->image = $accessPath;
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

    public function update($id, array $data)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = SubCategory::find($id);
            $object->category_id = $data['categoryId'];
            $object->description = $data['description'];
            $object->name = $data['name'];
            $object->color = $data['color'];
            $object->symbol = $data['symbol'];
            if(isset($data['image']) and $data['image'] != null){
                $filePath = $data['image']->store('public/images');
                $accessPath = Storage::url($filePath);
                $object->image = $accessPath;
            }
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

    public function delete($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = SubCategory::find($id);
            $control = false;
            $courses = Course::where('sub_category_id',$id)->where('deleted_at',null)->get();
            if($courses == null or count($courses) == 0){
                $control = true;
            }

            if($control){
                $object->delete();
            }
            else{
                $result = false;
                $error = "Alt kategoriye ait kurslar bulunmaktadır.";
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

    public function setActive($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = SubCategory::find($id);
            $object->active = true;
            $object->save();
        }
        catch(\Exception $e){
            $error = $e->getMessage();
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
            $object = SubCategory::find($id);
            $object->active = false;
            $object->save();
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
