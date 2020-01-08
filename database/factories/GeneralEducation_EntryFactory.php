<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\Student;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Entry;
use Faker\Generator as Faker;

$factory->define(Entry::class, function (Faker $faker) {
    $rand = rand(0, 100);
    $course = null;
    if ($rand > 50){
        $course = \App\Models\PrepareLessons\Course::orderByRaw('RAND()')->take(1)->first();
    }
    else{
        $course = \App\Models\GeneralEducation\Course::orderByRaw('RAND()')->take(1)->first();
    }
    $student = Student::orderByRaw('RAND()')->take(1)->first();
    return [
        'course_id' => $course->id,
        'course_type' => get_class($course),
        'student_id' => $student->id,
        'access_start' => $faker->dateTime,
        'access_finish' => $faker->dateTime,
    ];
});
