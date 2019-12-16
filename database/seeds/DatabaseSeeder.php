<?php

use App\Models\Auth\Guardian;
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

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Guardian::class, 20)->create();
        factory(School::class, 10)->create();
        factory(Student::class, 50)->create();
        factory(SocialMedia::class, 5)->create();
        factory(Category::class, 10)->create();
        factory(SubCategory::class, 20)->create();
        factory(Course::class, 10)->create();
        factory(Section::class, 30)->create();
        factory(Lesson::class, 100)->create();
        factory(Achievement::class,100)->create();
        factory(Comment::class, 200)->create();
        factory(Discount::class, 10)->create();
        factory(Entry::class, 20)->create();
        factory(Favorite::class, 20)->create();
        factory(Notice::class, 30)->create();
        factory(Purchase::class, 20)->create();
        factory(Question::class, 20)->create();
        factory(Answer::class, 50)->create();
        factory(Rebate::class, 20)->create();
        factory(Requirement::class, 100)->create();
        factory(Source::class, 30)->create();
        factory(Tag::class, 100)->create();
    }
}
