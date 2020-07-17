<?php

namespace App\Repositories\GeneralEducation;

use App\Models\Auth\Student;
use App\Models\GeneralEducation\Entry;
use App\Models\UsersOperations\Basket;
use App\Models\UsersOperations\Favorite;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use App\Models\GeneralEducation\SubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SubCategoryRepository implements IRepository{

    public function all()
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = SubCategory::all();
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
            $object = SubCategory::find($id);
        }
        catch(\Exception $e){
            $error = $e;
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
            $symbolPath = Storage::url($data['symbol']->store('public/symbols'));
            $imagePath = Storage::url($data['image']->store('public/images'));
            $object = new SubCategory;
            $object->category_id = $data['category_id'];
            $object->name = $data['name'];
            $object->description = $data['description'];
            $object->color = $data['color'];
            $object->symbol = $symbolPath;
            $object->image = $imagePath;
            $object->save();
        }
        catch(\Exception $e){
            $error = $e;
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
            $object = SubCategory::find($id);
            $object->category_id = $data['category_id'];
            $object->name = $data['name'];
            $object->description = $data['description'];
            $object->color = $data['color'];
            $object->save();
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function updateSymbol($id, array $data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = SubCategory::find($id);
            Storage::delete($object->symbol);
            $symbolPath = Storage::url($data['symbol']->store('public/symbols'));
            $object->symbol = $symbolPath;
            $object->save();
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function updateImage($id, array $data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = SubCategory::find($id);
            Storage::delete($object->image);
            $imagePath = Storage::url($data['image']->store('public/image'));
            $object->symbol = $imagePath;
            $object->save();
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e;
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
            $subCategory = SubCategory::find($id);
            Storage::delete($subCategory->symbol);
            Storage::delete($subCategory->image);
            $subCategory->delete();
        }
        catch(\Exception $e){
            $error = $e;
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
            $error = $e;
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
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getCourses($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $user = Auth::user();
            if($user == null){
                $subCategory = SubCategory::find($id);
                $object = $subCategory->courses->where('active',true)->where('deleted_at',null);
                foreach ($object as $key=>$item){
                    $subcategory = SubCategory::find($item->sub_category_id);
                    $object[$key]['subCategory'] = $subcategory;
                }
            }
            else{
                $subCategory = SubCategory::find($id);
                $object = $subCategory->courses->where('active',true)->where('deleted_at',null);
                foreach ($object as $key=>$item){
                    $subcategory = SubCategory::find($item->sub_category_id);
                    $object[$key]['subCategory'] = $subcategory;
                }

                foreach ($object as $key => $course){

                    $student = Student::where('user_id',$user->id)->first();
                    $controlEntry = Entry::where('student_id',$student->id)->where('course_type','App\Models\GeneralEducation\Course')
                        ->where('course_id',$item->id)->where('deleted_at',null)->get();
                    if($controlEntry != null and count($controlEntry)>0){
                        $object[$key]['inEntry'] = true;
                    }
                    else{
                        $object[$key]['inEntry'] = false;
                    }

                    $controlBasket = Basket::where('user_id',$user->id)->where('course_id',$course->id)->where('course_type','App\Models\GeneralEducation\Course')->get();
                    if($controlBasket != null and count($controlBasket)>0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFav = Favorite::where('user_id',$user->id)->where('course_id',$course->id)->where('course_type','App\Models\GeneralEducation\Course')->get();
                    if($controlFav != null and count($controlFav)>0){
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

    public function getCategory($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $subCategory = SubCategory::find($id);
            $object = $subCategory->category;
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
