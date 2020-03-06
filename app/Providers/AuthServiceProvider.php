<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Models\GeneralEducation\Course' => 'App\Policies\GeneralEducation\CoursePolicy',
        'App\Models\PrepareLessons\Course', 'App\Policies\PrepareLessons\CoursePolicy',
        'App\Models\GeneralEducation\Category' => 'App\Policies\GeneralEducation\CategoryPolicy',
        'App\Models\GeneralEducation\SubCategory' => 'App\Policies\GeneralEducation\CategoryPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
