<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Curriculum\Subject;
use App\Models\PrepareLessons\Course;
use App\Models\PrepareLessons\Section;
use Faker\Generator as Faker;

$factory->define(Section::class, function (Faker $faker) {
    $course = Course::orderByRaw('RAND()')->take(1)->first();
    $subject = Subject::orderByRaw('RAND()')->take(1)->first();
    $count = Section::where('course_id', $course->id)->get()->count();
    return [
        'course_id' => $course->id,
        'subject_id' => $subject->id,
        'no' => $count+1,
        'name' => $faker->sentence(3),
    ];
});
