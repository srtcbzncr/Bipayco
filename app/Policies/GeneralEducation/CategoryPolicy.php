<?php

namespace App\Policies\GeneralEducation;

use App\Models\Auth\User;
use App\Models\GeneralEducation\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(User $user){
        return true;
    }

    public function update(User $user, Category $category){
        return true;
    }

    public function delete(User $user, Category $category){
        return true;
    }
}
