<?php


namespace App\Repositories\Admin;


use App\Models\GeneralEducation\Category;
use App\Models\GeneralEducation\SubCategory;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryRepository implements IRepository
{

    public function all()
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = DB::table('ge_categories')->paginate(10);
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
            $object = Category::find($id);
            $object['subCategories'] = $object->subCategories;
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
            $object = new Category();
            $object->name = $data['name'];
            $object->description = $data['description'];
            $object->symbol = $data['symbol'];
            $object->color = $data['color'];
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
            $object = new Category();
            $object->name = $data['name'];
            $object->description = $data['description'];
            $object->symbol = $data['symbol'];
            $object->color = $data['color'];
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
            DB::beginTransaction();
            $object = Category::find($id);
            $subs = $object->subCategories;
            foreach ($subs as $sub){
                $tempSub = SubCategory::find($sub->id);
                $tempSub->delete();
            }
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

    public function setActive($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Category::find($id);
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

    public function setPassive($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Category::find($id);
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

    public function getSubCategoriesOfCategory($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = SubCategory::where('category_id ',$id)->get();
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
