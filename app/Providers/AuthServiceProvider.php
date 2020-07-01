<?php

namespace App\Providers;

use App\Models\PrepareLessons\Course;
use App\Policies\PrepareLessons\CoursePolicy;
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
        'App\Models\GeneralEducation\Category' => 'App\Policies\GeneralEducation\CategoryPolicy',
        'App\Models\GeneralEducation\SubCategory' => 'App\Policies\GeneralEducation\CategoryPolicy',
        Course::class => CoursePolicy::class,
        'App\Models\PrepareLessons\Section' => 'App\Policies\PrepareLessons\SectionPolicy',
        \App\Models\PrepareExams\Course::class => \App\Policies\PrepareExams\CoursePolicy::class,
        \App\Models\Live\Course::class => \App\Policies\Live\CoursePolicy::class
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
