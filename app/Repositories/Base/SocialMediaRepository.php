<?php

namespace App\Repositories\Base;

use App\Repositories\IRepository;
use App\Models\Base\SocialMedia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Repositories\RepositoryResponse;

class SocialMediaRepository implements IRepository{

    /**
     * Return all social medias.
     *
     * @return App\Repositories\RepositoryResponse
     */
    public function all()
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = SocialMedia::all();
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    /**
     * Return a social media by id.
     *
     * @param  int $id
     * @return App\Repositories\RepositoryResponse
     */
    public function get($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = SocialMedia::find($id);
        }
        catch (\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    /**
     * Create a new social media.
     *
     * @param  array @data
     * @return App\Repositories\RepositoryResponse
     */
    public function create(array $data)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = new SocialMedia;

        // Operations
        try{
            $symbolPath = Storage::putFile('symbols', $data['symbol']);
            $object->symbol = $symbolPath;
            $object->name = $data['name'];
            $object->save();
        }
        catch (\Exception $e){
            $error = $e;
            $result = false;
        }
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    /**
     * Update a social media.
     *
     * @param  int @id, array @data
     * @return App\Repositories\RepositoryResponse
     */
    public function update($id, array $data)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = SocialMedia::find($id);
            $object->name = $data['name'];
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

    /**
     * Update a social media's symbol.
     *
     * @param  int @id, array @data
     * @return App\Repositories\RepositoryResponse
     */
    public function updateSymbol($id, array $data)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = SocialMedia::find($id);
            Storage::delete($object->symbol);
            $symbolPath = Storage::putFile('symbols', $data['symbol']);
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

    /**
     * Delete a social media.
     *
     * @param  int @id
     * @return App\Repositories\RepositoryResponse
     */
    public function delete($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $socialMedia = SocialMedia::find($id);
            Storage::delete($socialMedia->symbol);
            $socialMedia->delete();
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    /**
     * Set social media's active column to true.
     *
     * @param  int @id
     * @return App\Repositories\RepositoryResponse
     */
    public function setActive($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = SocialMedia::find($id);
            $object->active = true;
            $object->save();
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        //Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    /**
     * Set social media's active column to false.
     *
     * @param  int @id
     * @return App\Repositories\RepositoryResponse
     */
    public function setPassive($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = SocialMedia::find($id);
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
}
