<?php

namespace App\Repositories\Auth;


use App\Repositories\IRepository;
use Illuminate\Http\Request;
use App\Models\Auth\User;

class UserRepository implements IRepository{

    /**
     * Get all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function All()
    {
        return User::all();
    }

    /**
     * Get a user by id.
     *
     * @param  int  $id
     * @return App\Models\Auth\User
     */
    public function Get($id)
    {
        return User::find($id);
    }

     /**
     * Get a user by id.
     *
     * @param  int  $id
     * @return App\Models\Auth\User
     */
    public function Create(Request $request)
    {

    }

    public function Update($id, Request $request)
    {
        // TODO: Implement Update() method.
    }

    public function Delete($id)
    {
        // TODO: Implement Delete() method.
    }

    public function SetActive($id)
    {
        // TODO: Implement SetActive() method.
    }

    public function SetPassive($id)
    {
        // TODO: Implement SetPassive() method.
    }
}
