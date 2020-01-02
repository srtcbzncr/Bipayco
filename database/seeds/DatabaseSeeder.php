<?php

use App\Models\Auth\Guardian;
use App\Models\Auth\Instructor;
use App\Models\Base\School;
use Illuminate\Database\Seeder;
use App\Models\Auth\Student;
use App\Models\Base\SocialMedia;
use App\Models\GeneralEducation\Category;
use App\Models\GeneralEducation\SubCategory;
use App\Models\GeneralEducation\Course;
use App\Models\GeneralEducation\Section;
use App\Models\GeneralEducation\Lesson;
use App\Models\GeneralEducation\Achievement;
use App\Models\GeneralEducation\Answer;
use App\Models\GeneralEducation\Comment;
use App\Models\GeneralEducation\Discount;
use App\Models\GeneralEducation\Entry;
use App\Models\GeneralEducation\Favorite;
use App\Models\GeneralEducation\Notice;
use App\Models\GeneralEducation\Purchase;
use App\Models\GeneralEducation\Question;
use App\Models\GeneralEducation\Rebate;
use App\Models\GeneralEducation\Requirement;
use App\Models\GeneralEducation\Source;
use App\Models\GeneralEducation\Tag;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Guardian::class, 100)->create();
        factory(School::class, 100)->create();
        factory(Student::class, 100)->create();
        factory(SocialMedia::class, 10)->create();
        factory(Category::class, 100)->create();
        factory(SubCategory::class, 500)->create();
        factory(Course::class, 100)->create()->each(function($course){
            $random = rand(1,5);
            $i = 0;
            while($i < $random){
                $instructor = factory(Instructor::class)->create();
                DB::table('ge_courses_instructors')->insert([
                    'course_id' => $course->id,
                    'instructor_id' => $instructor->id,
                ]);
                $i = $i + 1;
            }
        });
        factory(Section::class, 500)->create();
        factory(Lesson::class, 1000)->create();
        factory(Achievement::class, 1000)->create();
        factory(Comment::class, 2000)->create();
        factory(Discount::class, 100)->create();
        factory(Entry::class, 200)->create();
        factory(Favorite::class, 200)->create();
        factory(Notice::class, 300)->create();
        factory(Purchase::class, 200)->create();
        factory(Question::class, 200)->create();
        factory(Answer::class, 500)->create();
        factory(Rebate::class, 200)->create();
        factory(Requirement::class, 1000)->create();
        factory(Source::class, 300)->create();
        factory(Tag::class, 1000)->create();
    }
}
