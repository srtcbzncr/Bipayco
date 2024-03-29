<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\GeneralEducation\NewComment' => [
            'App\Listeners\GeneralEducation\CalculateCoursePoint',
        ],
        'App\Events\GeneralEducation\NewPurchase' => [
            'App\Listeners\GeneralEducation\CalculateCoursePurchaseCount',
        ],
        'App\Events\GeneralEducation\StartLessonEvent' => [
            'App\Listeners\GeneralEducation\StartLessonListener',
        ],
        'App\Events\GeneralEducation\FinishLessonEvent' => [
            'App\Listeners\GeneralEducation\FinishLessonListener',
        ],
        'App\Events\GeneralEducation\CreateDiscount' => [
            'App\Listeners\GeneralEducation\UpdateCoursePriceWithDiscount',
        ],
        'App\Events\GeneralEducation\DeleteDiscount' => [
            'App\Listeners\GeneralEducation\UpdateCoursePriceWithoutDiscount',
        ],
        'App\Events\UsersOperations\CreateLastWatchedCourse' => [
            'App\Listeners\UsersOperations\LastWacthedCourse'
        ],
        'App\Events\UsersOperations\CalculateCourseLong' => [
            'App\Listeners\UsersOperations\CalculateCourseLongListener'
        ],
        'App\Events\Auth\RegisterEvent' => [
            'App\Listeners\Auth\RegisterListener'
        ],
        'App\Events\Auth\InstructorCallEvent' => [
            'App\Listeners\Auth\InstructorCallListener'
        ],
        'App\Events\Instructor\CourseActiveEvent' => [
            'App\Listeners\Instructor\CourseActiveListener'
        ],
        'App\Events\Instructor\SectionActiveEvent' => [
            'App\Listeners\Instructor\SectionActiveListener'
        ],
        'App\Events\UsersOperations\AddStudentByGuardian' => [
            'App\Listeners\UsersOperations\AddStudentByGuardianListener'
        ],
        'App\Events\Auth\AdminRegisterEvent' => [
            'App\Listeners\Auth\AdminRegisterListener'
        ],
        'App\Events\Live\StartLiveEvent' => [
            'App\Listeners\Live\StartLiveListener'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
