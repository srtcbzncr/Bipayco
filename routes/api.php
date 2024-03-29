<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::post('/resetPasswordTokenControl','Auth\AuthController@resetPasswordTokenControl')->name('resetPasswordTokenControl');


# Home'daki ge,pl vb. kurslar.
Route::get('/home/ge/{user_id?}', 'API\HomeController@indexGe')->name('home_ge');
Route::get('/home/pl/{user_id?}', 'API\HomeController@indexPl')->name('home_pl');
Route::get('/home/pe/{user_id?}', 'API\HomeController@indexPe')->name('home_pe');
Route::get('/home/books/{user_id?}', 'API\HomeController@indexBooks')->name('home_books');
Route::get('/home/exams/{user_id?}', 'API\HomeController@indexExams')->name('home_exams');
Route::get('/home/live/{user_id?}', 'API\HomeController@indexLives')->name('home_lives'); // live_ok
Route::get('/home/lives/{user_id?}', 'API\Live\CourseController@allLives')->name('api_all_lives'); // live_ok

Route::get('search/{tag}/{userId?}','API\Search\SearchController@search')->name('api_search');

# live
Route::get('live/end_meeting/{meeting_id}','HomeController@end_meeting')->name('live_end_meeting');

#Kurs detay sayfası,kategoriler ve alt kategoriler ve
# iki api yazılacak. 1. sepette varmı yokmu, 2. benzer kurslar.
Route::group(['prefix' => 'ge'], function(){
    Route::group(['prefix' => 'category'], function(){
        Route::get('{id}', 'API\GeneralEducation\CategoryController@show2')->name('ge_category_courses');
    });
    Route::group(['prefix' => 'subCategory'], function(){
        Route::get('{id}', 'API\GeneralEducation\SubCategoryController@show')->name('ge_sub_category_courses');
    });
    Route::group(['prefix' => 'course'], function(){
        Route::get('{id}', 'API\GeneralEducation\CourseController@show')->name('ge_course');
        Route::post('{id}/buy','API\GeneralEducation\CourseController@buy')->name('ge_course_buy');
    });
    Route::get('index', 'API\HomeController@ge_index')->name('ge_index');

    Route::get('/inBasket/{user_id}/{course_id}','API\GeneralEducation\CourseController@inBasket')->name('ge_in_basket');
    Route::get('/similarCourses/{course_id}/{user_id?}','API\GeneralEducation\CourseController@simularCourses')->name('ge_simularCourses');
});

Route::group(['prefix' => 'pl'],function (){
    /*Route::group(['prefix' => 'category'],function (){
        # pl de burası yok.
        Route::get('{id}','API\PrepareLessons\CategoryController@show')->name('pl_category_courses');
    });
    Route::group(['prefix' => 'subCategory'], function(){
        # pl de burası yok.
        Route::get('{id}', 'API\PrepareLessons\SubCategoryController@show')->name('pl_sub_category_courses');
    });*/
    Route::group(['prefix' => 'course'], function(){
        Route::get('{id}', 'API\PrepareLessons\CourseController@show')->name('pl_course');
        Route::post('{id}/buy','API\PrepareLessons\CourseController@buy')->name('pl_course_buy');
    });

    # pl de burası yok.
    Route::get('index', 'API\HomeController@pl_index')->name('pl_index');

    Route::get('/inBasket/{user_id}/{course_id}','API\PrepareLessons\CourseController@inBasket')->name('pl_in_basket');
    Route::get('/similarCourses/{course_id}/{user_id?}','API\PrepareLessons\CourseController@simularCourses')->name('pl_simularCourses');

    # lessonları ve buna bağlı subjectleri getirir.
    Route::get('/lessons','API\HomeController@getCrLessons')->name('pl_lessons');
    Route::get('/lesson/{id}','API\PrepareLessons\CurriculumController@showLessonCourses')->name('pl_lesson_courses');

});

Route::group(['prefix' => 'pe'],function (){
    /*Route::group(['prefix' => 'category'],function (){
        # pl de burası yok.
        Route::get('{id}','API\PrepareLessons\CategoryController@show')->name('pl_category_courses');
    });
    Route::group(['prefix' => 'subCategory'], function(){
        # pl de burası yok.
        Route::get('{id}', 'API\PrepareLessons\SubCategoryController@show')->name('pl_sub_category_courses');
    });*/
    Route::group(['prefix' => 'course'], function(){
        Route::get('{id}', 'API\PrepareExams\CourseController@show')->name('pe_course'); // ok
        Route::post('{id}/buy','API\PrepareExams\CourseController@buy')->name('pe_course_buy'); // ok
    });

    # pe de burası yok.
    Route::get('index', 'API\HomeController@pl_index')->name('pe_index');

    Route::get('/inBasket/{user_id}/{course_id}','API\PrepareExams\CourseController@inBasket')->name('pe_in_basket'); // ok
    Route::get('/similarCourses/{course_id}/{user_id?}','API\PrepareExams\CourseController@simularCourses')->name('pe_simularCourses'); // ok

    # sınavları getirir.
    Route::get('/exams','API\HomeController@getCrExams')->name('pe_lessons'); // ok
    Route::get('/exam/{id}','API\PrepareExams\CurriculumController@showExamCourses')->name('pe_lesson_courses'); // ok

});

Route::group(['prefix' => 'live'],function (){
    Route::group(['prefix' => 'course'], function(){
        Route::get('{id}', 'API\Live\CourseController@show')->name('live_course'); // live_ok
        //Route::post('{id}/buy','API\Live\CourseController@buy')->name('live_course_buy'); // bu yok
    });

    Route::get('/inBasket/{user_id}/{course_id}','API\Live\CourseController@inBasket')->name('live_in_basket'); // live_ok
    Route::get('/similarCourses/{course_id}/{user_id?}','API\Live\CourseController@simularCourses')->name('live_simularCourses'); // live_ok

});


Route::get('/purchases/{user_id}','API\Purchases\PurchasesController@getPurchases')->name('api_get_purchases');

Route::prefix('profile')->group(function (){
    # buradaki userId instructor'a ait değil. Giriş yapmış kullanıcıya ait.Eğer giriş yapmış kullanıcı yoksa gönderilmesine gerek yoktur.
    Route::get('instructor/{instructorId}/{userId?}', 'API\Auth\AuthController@getInstructorsCourses')->name('instructor_profile');
});

Route::prefix('country')->group(function(){
    Route::get('index', 'API\Base\CountryController@index')->name('api_country_index');
    Route::get('{id}', 'API\Base\CountryController@show')->name('api_country_show');
    Route::get('{id}/cities', 'API\Base\CountryController@cities')->name('api_country_cities');
});

Route::prefix('category')->group(function(){
    Route::get('index', 'API\GeneralEducation\CategoryController@index')->name('api_category_index');
    Route::get('{id}', 'API\GeneralEducation\CategoryController@show')->name('api_category_show');
});

Route::prefix('curriculum')->group(function (){
    Route::get('index', 'API\PrepareLessons\CurriculumController@index')->name('api_pl_curriculum_index');
});


Route::prefix('course')->group(function(){
    #general education
    Route::get('getPopularCourses/{user_id?}', 'API\GeneralEducation\CourseController@getPopularCourses')->name('api_course_get_popular_courses');
    Route::get('getByCategoryFilterByNewest/{category_id}/{user_id?}', 'API\GeneralEducation\CourseController@getByCategoryFilterByNewest')->name('api_course_get_by_category_filter_by_newest');
    Route::get('getByCategoryFilterByOldest/{category_id}/{user_id?}', 'API\GeneralEducation\CourseController@getByCategoryFilterByOldest')->name('api_course_get_by_category_filter_by_oldest');
    Route::get('getByCategoryFilterByPriceASC/{category_id}/{user_id?}', 'API\GeneralEducation\CourseController@getByCategoryFilterByPriceASC')->name('api_course_get_by_category_filter_by_price_asc');
    Route::get('getByCategoryFilterByPriceDESC/{category_id}/{user_id?}', 'API\GeneralEducation\CourseController@getByCategoryFilterByPriceDESC')->name('api_course_get_by_category_filter_by_price_desc');
    Route::get('getByCategoryFilterByPoint/{category_id}/{user_id?}', 'API\GeneralEducation\CourseController@getByCategoryFilterByPoint')->name('api_course_get_by_category_filter_by_point');
    Route::get('getByCategoryFilterByPurchases/{category_id}/{user_id?}', 'API\GeneralEducation\CourseController@getByCategoryFilterByPurchases')->name('api_course_get_by_category_filter_by_purchases');
    Route::get('getByCategoryFilterByTrending/{category_id}/{user_id?}', 'API\GeneralEducation\CourseController@getByCategoryFilterByTrending')->name('api_course_get_by_category_filter_by_trending');
    Route::get('getBySubCategoryFilterByNewest/{sub_category_id}/{user_id?}', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByNewest')->name('api_course_get_by_sub_category_filter_by_newest');
    Route::get('getBySubCategoryFilterByOldest/{sub_category_id}/{user_id?}', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByOldest')->name('api_course_get_by_sub_category_filter_by_oldest');
    Route::get('getBySubCategoryFilterByPriceASC/{sub_category_id}/{user_id?}', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByPriceASC')->name('api_course_get_by_sub_category_filter_by_price_asc');
    Route::get('getBySubCategoryFilterByPriceDESC/{sub_category_id}/{user_id?}', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByPriceDESC')->name('api_course_get_by_sub_category_filter_by_price_desc');
    Route::get('getBySubCategoryFilterByPoint/{sub_category_id}/{user_id?}', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByPoint')->name('api_course_get_by_sub_category_filter_by_point');
    Route::get('getBySubCategoryFilterByPurchases/{sub_category_id}/{user_id?}', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByPurchases')->name('api_course_get_by_sub_category_filter_by_purchases');
    Route::get('getBySubCategoryFilterByTrending/{sub_category_id}/{user_id?}', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByTrending')->name('api_course_get_by_sub_category_filter_by_trending');

    #mix and common api
    //Route::get('{id}/comments', 'API\GeneralEducation\CourseController@getComments')->name('api_course_get_comments');
    Route::get('{id}/canEntry/{user_id}', 'API\GeneralEducation\CourseController@canEntry')->name('api_course_can_entry');
    Route::get('{id}/canComment/{user_id}', 'API\GeneralEducation\CourseController@canComment')->name('api_course_can_comment');
    Route::get('{id}/generalEducation/previewLessons','API\GeneralEducation\CourseController@getPreviewLessons')->name('api_ge_preview_lessons');
    Route::get('{id}/prepareLessons/previewLessons','API\PrepareLessons\CourseController@getPreviewLessons')->name('api_pl_preview_lessons');
    Route::get('{id}/prepareExams/previewLessons','API\PrepareExams\CourseController@getPreviewLessons')->name('api_pe_preview_lessons');

    #prepare lessons
    Route::get('getByLessonsFilterByNewest/{gradeId}/{lesson_id}/{user_id?}', 'API\PrepareLessons\CourseController@getByLessonFilterByNewest')->name('api_course_get_lesson_filter_by_newest');
    Route::get('getByLessonsFilterByOldest/{gradeId}/{lesson_id}/{user_id?}', 'API\PrepareLessons\CourseController@getByLessonFilterByOldest')->name('api_course_get_by_lesson_filter_by_oldest');
    Route::get('getByLessonsFilterByPriceASC/{gradeId}/{lesson_id}/{user_id?}', 'API\PrepareLessons\CourseController@getByLessonFilterByPriceASC')->name('api_course_get_by_lesson_filter_by_price_asc');
    Route::get('getByLessonsFilterByPriceDESC/{gradeId}/{lesson_id}/{user_id?}', 'API\PrepareLessons\CourseController@getByLessonFilterByPriceDESC')->name('api_course_get_by_lesson_filter_by_price_desc');
    Route::get('getByLessonsFilterByPoint/{gradeId}/{lesson_id}/{user_id?}', 'API\PrepareLessons\CourseController@getByLessonFilterByPoint')->name('api_course_get_by_lesson_filter_by_point');
    Route::get('getByLessonsFilterByPurchases/{gradeId}/{lesson_id}/{user_id?}', 'API\PrepareLessons\CourseController@getByLessonFilterByPurchases')->name('api_course_get_by_lesson_filter_by_purchases');
    Route::get('getByLessonsFilterByTrending/{gradeId}/{lesson_id}/{user_id?}', 'API\PrepareLessons\CourseController@getByLessonFilterByTrending')->name('api_course_get_by_lesson_filter_by_trending');

    #prepare exams
    Route::get('getByExamsFilterByNewest/{examId}/{user_id?}', 'API\PrepareExams\CourseController@getByLessonFilterByNewest')->name('api_course_get_lesson_filter_by_newest'); // ok
    Route::get('getByExamsFilterByOldest/{examId}/{user_id?}', 'API\PrepareExams\CourseController@getByLessonFilterByOldest')->name('api_course_get_by_lesson_filter_by_oldest'); // ok
    Route::get('getByExamsFilterByPriceASC/{examId}/{user_id?}', 'API\PrepareExams\CourseController@getByLessonFilterByPriceASC')->name('api_course_get_by_lesson_filter_by_price_asc'); // ok
    Route::get('getByExamsFilterByPriceDESC/{examId}/{user_id?}', 'API\PrepareExams\CourseController@getByLessonFilterByPriceDESC')->name('api_course_get_by_lesson_filter_by_price_desc'); // ok
    Route::get('getByExamsFilterByPoint/{examId}/{user_id?}', 'API\PrepareExams\CourseController@getByLessonFilterByPoint')->name('api_course_get_by_lesson_filter_by_point'); // ok
    Route::get('getByExamsFilterByPurchases/{examId}/{user_id?}', 'API\PrepareExams\CourseController@getByLessonFilterByPurchases')->name('api_course_get_by_lesson_filter_by_purchases'); // ok
    Route::get('getByExamsFilterByTrending/{examId}/{user_id?}', 'API\PrepareExams\CourseController@getByLessonFilterByTrending')->name('api_course_get_by_lesson_filter_by_trending'); // ok


});

Route::prefix('comment')->group(function(){
    Route::prefix('ge')->group(function (){
        Route::post('create', 'API\GeneralEducation\CommentController@create')->name('api_comment_create');
        Route::post('delete/{id}', 'API\GeneralEducation\CommentController@delete')->name('api_comment_delete');
        Route::post('update/{id}', 'API\GeneralEducation\CommentController@update')->name('api_comment_update');
        Route::get('/{courseId}/comments', 'API\GeneralEducation\CommentController@getComments')->name('api_course_get_ge_comments');

    });
    Route::prefix('pl')->group(function (){
        Route::post('create', 'API\PrepareLessons\CommentController@create')->name('api_comment_create');
        Route::post('delete/{id}', 'API\PrepareLessons\CommentController@delete')->name('api_comment_delete');
        Route::post('update/{id}', 'API\PrepareLessons\CommentController@update')->name('api_comment_update');
        Route::get('/{courseId}/comments', 'API\PrepareLessons\CommentController@getComments')->name('api_course_get_pl_comments');
    });
    Route::prefix('pe')->group(function (){
        Route::post('create', 'API\PrepareExams\CommentController@create')->name('api_comment_create');
        Route::post('delete/{id}', 'API\PrepareExams\CommentController@delete')->name('api_comment_delete');
        Route::post('update/{id}', 'API\PrepareExams\CommentController@update')->name('api_comment_update');
        Route::get('/{courseId}/comments', 'API\PrepareExams\CommentController@getComments')->name('api_course_get_pe_comments');
    });
});

Route::prefix('favorite')->group(function(){
   Route::post('create', 'API\GeneralEducation\FavoriteController@create')->name('api_favorite_create');
});

Route::prefix('city')->group(function(){
    Route::get('index', 'API\Base\CityController@index')->name('api_city_index');
    Route::get('{id}', 'API\Base\CityController@show')->name('api_city_show');
    Route::get('{id}/districts', 'API\Base\CityController@districts')->name('api_city_districts');
});

Route::prefix('district')->group(function(){
    Route::get('index', 'API\Base\DistrictController@index')->name('api_district_index');
    Route::get('{id}', 'API\Base\DistrictController@show')->name('api_district_show');
});

Route::prefix('instructor')->group(function(){
    # General Education
    Route::post('generalEducation/course/create/{id?}', 'API\GeneralEducation\CourseController@createPost')->name('api_ge_course_create_post');
    Route::post('generalEducation/course/{id}/delete', 'API\GeneralEducation\CourseController@deleteCourse')->name('api_ge_course_delete');
    Route::post('generalEducation/course/{id}/active', 'API\GeneralEducation\CourseController@activeCourse')->name('api_ge_course_active');
    Route::post('generalEducation/course/{id}/passive', 'API\GeneralEducation\CourseController@passiveCourse')->name('api_ge_course_passive');
    Route::post('generalEducation/course/{id}/goals', 'API\GeneralEducation\CourseController@goalsPost')->name('api_ge_course_goals_post');
    Route::get('generalEducation/course/{id}/goals','API\GeneralEducation\CourseController@goalsGet')->name('api_ge_course_goals_get');
    Route::post('generalEducation/course/{id}/sections/create/{section_id?}', 'API\GeneralEducation\CourseController@sectionsPost')->name('api_ge_course_sections_post');
    Route::post('generalEducation/course/{id}/sections/delete/{section_id}', 'API\GeneralEducation\CourseController@sectionsDelete')->name('api_ge_course_sections_delete');
    Route::get('generalEducation/course/{id}/sections/get','API\GeneralEducation\CourseController@sectionsGet')->name('api_ge_course_sections_get');
    Route::post('generalEducation/course/{id}/sections/{section_id}/lessons/create/{lesson_id?}','API\GeneralEducation\CourseController@lessonsPost')->name('api_ge_course_sections_lessons_post');
    Route::post('generalEducation/course/{id}/sections/{section_id}/lessons/delete/{lesson_id}','API\GeneralEducation\CourseController@lessonsDelete')->name('api_ge_course_sections_lessons_delete');
    Route::post('generalEducation/course/{id}/sections/{section_id}/lessons/{lesson_id}/source/delete/{source_id}','API\GeneralEducation\CourseController@sourceDelete')->name('api_ge_course_sections_lessons_sources_delete');
    Route::post('generalEducation/course/{id}/sections/{section_id}/lessons/{lesson_id}/source/cancel','API\GeneralEducation\CourseController@sourceDeleteCancel')->name('api_ge_course_sections_lessons_sources_delete_cancel');

    Route::post('generalEducation/course/{id}/instructors', 'API\GeneralEducation\CourseController@instructorsPost')->name('api_ge_course_instructors_post');
    Route::get('generalEducation/course/{id}/instructors','API\GeneralEducation\CourseController@instructorsGet')->name('api_ge_course_instructors_get');
    Route::get('search', 'API\Auth\AuthController@getInstructorByMail')->name('api_search_instructor');
    Route::post('generalEducation/course/{id}/section/{section_id}/up','API\GeneralEducation\CourseController@sectionUp')->name('api_ge_course_section_up');
    Route::post('generalEducation/course/{id}/section/{section_id}/down','API\GeneralEducation\CourseController@sectionDown')->name('api_ge_course_section_down');
    Route::post('generalEducation/course/{id}/section/{section_id}/lesson/{lesson_id}/up','API\GeneralEducation\CourseController@lessonUp')->name('api_ge_course_lesson_up');
    Route::post('generalEducation/course/{id}/section/{section_id}/lesson/{lesson_id}/down','API\GeneralEducation\CourseController@lessonDown')->name('api_ge_course_lesson_down');


    # Prepare Lessons
    Route::post('prepareLessons/course/create/{id?}', 'API\PrepareLessons\CourseController@createPost')->name('api_pl_course_create_post');
    Route::post('prepareLessons/course/{id}/delete', 'API\PrepareLessons\CourseController@deleteCourse')->name('api_pl_course_delete');
    Route::post('prepareLessons/course/{id}/active', 'API\PrepareLessons\CourseController@activeCourse')->name('api_pl_course_active');
    Route::post('prepareLessons/course/{id}/passive', 'API\PrepareLessons\CourseController@passiveCourse')->name('api_pl_course_passive');
    Route::post('prepareLessons/course/{id}/goals', 'API\PrepareLessons\CourseController@goalsPost')->name('api_pl_course_goals_post');
    Route::get('prepareLessons/course/{id}/goals','API\PrepareLessons\CourseController@goalsGet')->name('api_pl_course_goals_get');
    Route::get('prepareLessons/course/{id}/subjects','API\PrepareLessons\CourseController@getSubjects')->name('api_pl_course_subjects'); // pl course
    Route::post('prepareLessons/course/{id}/sections/create/{section_id?}', 'API\PrepareLessons\CourseController@sectionsPost')->name('api_pl_course_sections_post');
    Route::post('prepareLessons/course/{id}/sections/delete/{section_id}', 'API\PrepareLessons\CourseController@sectionsDelete')->name('api_pl_course_sections_delete');
    Route::get('prepareLessons/course/{id}/sections/get','API\PrepareLessons\CourseController@sectionsGet')->name('api_pl_course_sections_get');
    Route::post('prepareLessons/course/{id}/sections/{section_id}/lessons/create/{lesson_id?}','API\PrepareLessons\CourseController@lessonsPost')->name('api_pl_course_sections_lessons_post');
    Route::post('prepareLessons/course/{id}/sections/{section_id}/lessons/delete/{lesson_id}','API\PrepareLessons\CourseController@lessonsDelete')->name('api_pl_course_sections_lessons_delete');
    Route::post('prepareLessons/course/{id}/sections/{section_id}/lessons/{lesson_id}/source/delete/{source_id}','API\PrepareLessons\CourseController@sourceDelete')->name('api_pl_course_sections_lessons_sources_delete');
    Route::post('prepareLessons/course/{id}/sections/{section_id}/lessons/{lesson_id}/source/cancel','API\PrepareLessons\CourseController@sourceDeleteCancel')->name('api_pl_course_sections_lessons_sources_delete_cancel');

    Route::post('prepareLessons/course/{id}/instructors', 'API\PrepareLessons\CourseController@instructorsPost')->name('api_pl_course_instructors_post');
    Route::get('prepareLessons/course/{id}/instructors','API\PrepareLessons\CourseController@instructorsGet')->name('api_pl_course_instructors_get');
    Route::post('prepareLessons/course/{id}/section/{section_id}/up','API\PrepareLessons\CourseController@sectionUp')->name('api_pl_course_section_up');
    Route::post('prepareLessons/course/{id}/section/{section_id}/down','API\PrepareLessons\CourseController@sectionDown')->name('api_pl_course_section_down');
    Route::post('prepareLessons/course/{id}/section/{section_id}/lesson/{lesson_id}/up','API\PrepareLessons\CourseController@lessonUp')->name('api_gl_course_lesson_up');
    Route::post('prepareLessons/course/{id}/section/{section_id}/lesson/{lesson_id}/down','API\PrepareLessons\CourseController@lessonDown')->name('api_pl_course_lesson_down');

    # getSubjects
    Route::get('subjects/lesson/{id}','API\PrepareLessons\CourseController@getSubjectsForLesson')->name('api_pl_course_subjects_get'); // soru havuzu

    # prepare exams
    Route::post('prepareExams/course/create/{id?}', 'API\PrepareExams\CourseController@createPost')->name('api_pl_course_create_post'); // ok
    Route::post('prepareExams/course/{id}/delete', 'API\PrepareExams\CourseController@deleteCourse')->name('api_pl_course_delete'); // ok
    Route::post('prepareExams/course/{id}/active', 'API\PrepareExams\CourseController@activeCourse')->name('api_pl_course_active'); // ok
    Route::post('prepareExams/course/{id}/passive', 'API\PrepareExams\CourseController@passiveCourse')->name('api_pl_course_passive'); // ok
    Route::post('prepareExams/course/{id}/goals', 'API\PrepareExams\CourseController@goalsPost')->name('api_pl_course_goals_post'); // ok
    Route::get('prepareExams/course/{id}/goals','API\PrepareExams\CourseController@goalsGet')->name('api_pl_course_goals_get'); // ok
    Route::post('prepareExams/course/{id}/sections/create/{section_id?}', 'API\PrepareExams\CourseController@sectionsPost')->name('api_pl_course_sections_post'); // ok
    Route::post('prepareExams/course/{id}/sections/delete/{section_id}', 'API\PrepareExams\CourseController@sectionsDelete')->name('api_pl_course_sections_delete'); // ok
    Route::get('prepareExams/course/{id}/sections/get','API\PrepareExams\CourseController@sectionsGet')->name('api_pl_course_sections_get'); // ok
    Route::post('prepareExams/course/{id}/sections/{section_id}/lessons/create/{lesson_id?}','API\PrepareExams\CourseController@lessonsPost')->name('api_pl_course_sections_lessons_post'); // ok
    Route::post('prepareExams/course/{id}/sections/{section_id}/lessons/delete/{lesson_id}','API\PrepareExams\CourseController@lessonsDelete')->name('api_pl_course_sections_lessons_delete'); // ok
    Route::post('prepareExams/course/{id}/sections/{section_id}/lessons/{lesson_id}/source/delete/{source_id}','API\PrepareExams\CourseController@sourceDelete')->name('api_pl_course_sections_lessons_sources_delete'); // ok
    Route::post('prepareExams/course/{id}/sections/{section_id}/lessons/{lesson_id}/source/cancel','API\PrepareExams\CourseController@sourceDeleteCancel')->name('api_pl_course_sections_lessons_sources_delete_cancel'); // ok

    Route::post('prepareExams/course/{id}/instructors', 'API\PrepareExams\CourseController@instructorsPost')->name('api_pl_course_instructors_post'); // ok
    Route::get('prepareExams/course/{id}/instructors','API\PrepareExams\CourseController@instructorsGet')->name('api_pl_course_instructors_get'); // ok
    Route::post('prepareExams/course/{id}/section/{section_id}/up','API\PrepareExams\CourseController@sectionUp')->name('api_pl_course_section_up'); // ok
    Route::post('prepareExams/course/{id}/section/{section_id}/down','API\PrepareExams\CourseController@sectionDown')->name('api_pl_course_section_down'); // ok
    Route::post('prepareExams/course/{id}/section/{section_id}/lesson/{lesson_id}/up','API\PrepareExams\CourseController@lessonUp')->name('api_gl_course_lesson_up'); // ok
    Route::post('prepareExams/course/{id}/section/{section_id}/lesson/{lesson_id}/down','API\PrepareExams\CourseController@lessonDown')->name('api_pl_course_lesson_down'); // ok
    Route::get('prepareExams/exams','API\PrepareExams\CourseController@getExams')->name('api_pl_course_get_exams');


    # live
    Route::post('live/course/create', 'API\Live\LiveController@createLiveOnBipayco')->name('api_live_course_create'); // live_ok
    Route::post('live/course/{course_id}/update', 'API\Live\LiveController@updateLiveOnBipayco')->name('api_live_course_update'); // live_ok
    Route::post('live/course/{id}/delete', 'API\Live\CourseController@deleteCourse')->name('api_live_course_delete'); // live_ok
    Route::post('live/course/{id}/goals', 'API\Live\CourseController@goalsPost')->name('api_live_course_goals_post'); // live_ok
    Route::get('live/course/{id}/goals','API\Live\CourseController@goalsGet')->name('api_live_course_goals_get'); // live_ok
    Route::get('live/course/{id}/instructors','API\Live\CourseController@instructorsGet')->name('api_live_course_instructors_get'); // live_ok
    Route::get('live/course/{id}/createOnBBB/{user_id}','API\Live\LiveController@createLiveOnBBB')->name('api_live_course_create_on_bbb'); // live_ok
    Route::get('live/course/{id}/join/{user_id}','API\Live\LiveController@joinLive')->name('api_live_course_join_live'); // live_ok

    // soru cevap bölümü
    Route::get('getNotAnsweredQuestions/{userId}','API\Learn\QuestionAnswer\QuestionAnswerController@getNotAnsweredQuestions')->name('api_get_not_answered_question');
    Route::get('getAnsweredQuestions/{userId}','API\Learn\QuestionAnswer\QuestionAnswerController@getAnsweredQuestions')->name('api_get_answered_question');
    Route::post('deleteAnswer/{answerId}','API\Learn\QuestionAnswer\QuestionAnswerController@deleteAnswer')->name('api_delete_answer');
    Route::post('updateAnswer/{answerId}','API\Learn\QuestionAnswer\QuestionAnswerController@updateAnswer')->name('api_update_answer');
});

# Kurs İzleme Bölümü İçin Routes
Route::prefix('learn')->group(function (){
        # general education
    Route::get('generalEducation/{course_id}/user/{user_id}','API\Learn\GeneralEducation\LearnController@getCourse')->name('api_get_general_education_course');
    Route::get('generalEducation/{course_id}/lesson/{lesson_id}','API\Learn\GeneralEducation\LearnController@getLesson')->name('api_get_general_education_lesson');
    Route::get('generalEducation/{course_id}/lesson/{lesson_id}/sources','API\Learn\GeneralEducation\LearnController@getSources')->name('api_get_general_education_sources');
    Route::get('generalEducation/{course_id}/lesson/{lesson_id}/discussion','API\Learn\GeneralEducation\LearnController@getDiscussions')->name('api_get_general_education_discussion');
    Route::post('generalEducation/{course_id}/lesson/{lesson_id}/discussion/ask','API\Learn\GeneralEducation\LearnController@askQuestion')->name('api_get_general_education_discussion_ask');
    Route::post('generalEducation/{course_id}/lesson/{lesson_id}/discussion/answer/{question_id}','API\Learn\GeneralEducation\LearnController@answerQuestion')->name('api_get_general_education_discussion_answer');
    Route::post('generalEducation/{course_id}/lesson/{lesson_id}/complete','API\Learn\GeneralEducation\LearnController@completeLesson')->name('api_get_general_education_complete_lesson');
    Route::get('generalEducation/{course_id}/user/{user_id}/defaultLesson','API\Learn\GeneralEducation\LearnController@defaultLesson')->name('api_get_general_education_default_lesson');

        # prepare lessons
    Route::post('prepareLessons/createFirstLastTestStatus/create','API\QuestionSource\Student\FirstLastTestStatusController@create')->name('api_prepareLessons_create_flTestStatus');
    Route::post('prepareLessons/createFirstLastTestAnswers/create','API\QuestionSource\Student\FirstLastTestAnswersController@create')->name('api_prepareLessons_create_flTestAnswers');
    Route::get('prepareLessons/getRandomQuestions/{courseId}/{crLessonId}/{crSubjectId}','API\PrepareLessons\CourseController@getRandomQuestions')->name('api_pl_course_getRandomQuestions');
    Route::get('prepareLessons/{course_id}/lesson/{lesson_id}/sources','API\Learn\PrepareLessons\LearnController@getSources')->name('api_get_pl_sources');
    Route::get('prepareLessons/{course_id}/lesson/{lesson_id}/discussion','API\Learn\PrepareLessons\LearnController@getDiscussions')->name('api_get_pl_discussion');
    Route::post('prepareLessons/{course_id}/lesson/{lesson_id}/discussion/ask','API\Learn\PrepareLessons\LearnController@askQuestion')->name('api_pl_discussion_ask');
    Route::post('prepareLessons/{course_id}/lesson/{lesson_id}/discussion/answer/{question_id}','API\Learn\PrepareLessons\LearnController@answerQuestion')->name('api_pl_discussion_answer');
    Route::post('prepareLessons/{course_id}/lesson/{lesson_id}/complete','API\Learn\PrepareLessons\LearnController@completeLesson')->name('api_pl_complete_lesson');
    Route::get('prepareLessons/{course_id}/user/{user_id}/defaultLesson','API\Learn\PrepareLessons\LearnController@defaultLesson')->name('api_pl_default_lesson');

        # prepare exams
    Route::post('prepareExams/createFirstLastTestStatus/create','API\QuestionSource\Student\FirstLastTestStatusController@create')->name('api_prepareExams_create_flTestStatus'); // ok
   // Route::post('prepareExams/createFirstLastTestAnswers/create','API\QuestionSource\Student\FirstLastTestAnswersController@create')->name('api_prepareLessons_create_flTestAnswers');
    Route::get('prepareExams/getRandomQuestions/{courseId}/{crLessonId}/{crSubjectId}','API\PrepareExams\CourseController@getRandomQuestions')->name('api_pe_course_getRandomQuestions'); // ok
    Route::get('prepareExams/{course_id}/lesson/{lesson_id}/sources','API\Learn\PrepareExams\LearnController@getSources')->name('api_get_pe_sources'); // ok
    Route::get('prepareExams/{course_id}/lesson/{lesson_id}/discussion','API\Learn\PrepareExams\LearnController@getDiscussions')->name('api_get_pe_discussion'); // ok
    Route::post('prepareExams/{course_id}/lesson/{lesson_id}/discussion/ask','API\Learn\PrepareExams\LearnController@askQuestion')->name('api_pe_discussion_ask'); // ok
    Route::post('prepareExams/{course_id}/lesson/{lesson_id}/discussion/answer/{question_id}','API\Learn\PrepareExams\LearnController@answerQuestion')->name('api_pe_discussion_answer'); // ok
    Route::post('prepareExams/{course_id}/lesson/{lesson_id}/complete','API\Learn\PrepareExams\LearnController@completeLesson')->name('api_pe_complete_lesson'); // ok
    Route::get('prepareExams/{course_id}/user/{user_id}/defaultLesson','API\Learn\PrepareExams\LearnController@defaultLesson')->name('api_pe_default_lesson'); // ok


});

Route::prefix('basket')->group(function (){
    Route::post('/add','API\Basket\BasketController@add')->name('add_basket');
    Route::post('/delete','API\Basket\BasketController@remove')->name('remove_basket');
    Route::post('/deleteAll/{user_id}','API\Basket\BasketController@removeAll')->name('remove_basket_all');
    Route::get('/show/{user_id}','API\Basket\BasketController@show')->name('show_basket');
    Route::post('/buy/{userId}','API\Basket\BasketController@buy')->name('buy_courses');

    Route::get('/referenceControl/{user_id}/{referenceCode}','API\Basket\BasketController@referenceControl')->name('api_reference_control');
    Route::post('/checkOut','API\Basket\BasketController@checkOut')->name('api_check_out');
});
Route::prefix('favorite')->group(function (){
    Route::post('/add','API\Favorite\FavoriteController@add')->name('add_favorite');
    Route::post('/delete','API\Favorite\FavoriteController@remove')->name('remove_favorite');
    Route::get('/show/{user_id}','API\Favorite\FavoriteController@show')->name('show_favorite');
    Route::get('/getLastFavorites/{user_id}','API\Favorite\FavoriteController@getLastFavorite')->name('favorite_get_last');
    Route::get('/getFavoritePaginate/{user_id}','API\Favorite\FavoriteController@getFavoritePaginate')->name('favorite_get_favorite');
});

Route::prefix('notification')->group(function (){
    Route::post('/create/{userId}','API\Notification\NotificationController@create')->name('api_notification_create');
    Route::get('/show/{userId}','API\Notification\NotificationController@show')->name('api_notification_show');
    Route::get('/get/{notificationId}','API\Notification\NotificationController@get')->name('api_notification_get');
    Route::post('/delete/{notificationId}','API\Notification\NotificationController@delete')->name('api_notification_delete');
    Route::post('/seen/{notificationId}','API\Notification\NotificationController@seen')->name('api_notification_seen');
});

Route::prefix('student')->group(function (){
    Route::post('/acceptGuardian/{studentId}/{guardianId}','API\Notification\NotificationController@acceptGuardian')->name('api_student_accept');
    Route::post('/rejectGuardian/{studentId}/{guardianId}','API\Notification\NotificationController@rejectGuardian')->name('api_student_reject');
});


Route::prefix('questionSource')->group(function (){
   Route::post('/create','API\QuestionSource\QuestionSourceController@create')->name('api_question_source_create');
   Route::post('/delete/{id}','API\QuestionSource\QuestionSourceController@delete')->name('api_question_source_delete');
   Route::get('/getQuestions/{user_id}','API\QuestionSource\QuestionSourceController@getQuestions')->name('api_question_source_get_questions');
   Route::get('/getQuestion/{id}','API\QuestionSource\QuestionSourceController@getQuestion')->name('api_question_source_get_question');
   Route::post('/update/{id}','API\QuestionSource\QuestionSourceController@update')->name('api_question_source_update_question');
});


Route::get('myCourses/{id}', 'API\Auth\AuthController@courses')->name('api_my_courses');
Route::get('lastCourses/{id}', 'API\Auth\AuthController@getLastWatchedCourses')->name('api_my_last_courses');
Route::post('rebateCourse','API\Iyzico\RebateController@rebateCourse')->name('api_rebate_course');

Route::prefix('admin')->group(function (){
   Route::prefix('bs')->group(function (){
       Route::prefix('country')->group(function (){
           Route::post('/create','API\Admin\BaseController@createCountry')->name('admin_bs_country_create');
           Route::get('/show','API\Admin\BaseController@showCountries')->name('admin_bs_country_show');
           Route::get('/show/{countryId}','API\Admin\BaseController@showCountry')->name('admin_bs_country_show_country');
           Route::post('/delete/{countryId}','API\Admin\BaseController@deleteCountry')->name('admin_bs_country_delete');
           Route::post('/update/{countryId}','API\Admin\BaseController@updateCountry')->name('admin_bs_country_update');
       });
       Route::prefix('city')->group(function (){
           Route::post('/create','API\Admin\BaseController@createCity')->name('admin_bs_city_create');
           Route::get('/show','API\Admin\BaseController@showCities')->name('admin_bs_city_show');
           Route::get('/show/{cityId}','API\Admin\BaseController@showCity')->name('admin_bs_city_show_city');
           Route::post('/delete/{cityId}','API\Admin\BaseController@deleteCity')->name('admin_bs_city_delete');
           Route::post('/update/{cityId}','API\Admin\BaseController@updateCity')->name('admin_bs_city_update');
           Route::post('/setActive/{cityId}','API\Admin\BaseController@setActiveCity')->name('admin_bs_city_active');
           Route::post('/setPassive/{cityId}','API\Admin\BaseController@setPassiveCity')->name('admin_bs_city_passive');
           Route::get('/{cityId}/districts','API\Admin\BaseController@getDistricts')->name('admin_bs_city_district');
       });
       Route::prefix('district')->group(function (){
           Route::post('/create','API\Admin\BaseController@createDistrict')->name('admin_bs_district_create');
           Route::get('/show','API\Admin\BaseController@showDistricts')->name('admin_bs_district_show');
           Route::get('/show/{districtId}','API\Admin\BaseController@showDistrict')->name('admin_bs_district_show_district');
           Route::post('/delete/{districtId}','API\Admin\BaseController@deleteDistrict')->name('admin_bs_district_delete');
           Route::post('/update/{districtId}','API\Admin\BaseController@updateDistrict')->name('admin_bs_district_update');
           Route::post('/setActive/{districtId}','API\Admin\BaseController@setActiveDistrict')->name('admin_bs_district_active');
           Route::post('/setPassive/{districtId}','API\Admin\BaseController@setPassiveDistrict')->name('admin_bs_district_passive');
       });
   });
   Route::prefix('ge')->group(function (){
       Route::prefix('category')->group(function (){
           Route::post('/create','API\Admin\CategoryController@createCategory')->name('admin_ge_category_create');
           Route::get('/show','API\Admin\CategoryController@showCategories')->name('admin_ge_category_show');
           Route::get('/show/{categoryId}','API\Admin\CategoryController@showCategory')->name('admin_ge_category_show_category');
           Route::post('/delete/{categoryId}','API\Admin\CategoryController@deleteCategory')->name('admin_ge_category_delete');
           Route::post('/update/{categoryId}','API\Admin\CategoryController@updateCategory')->name('admin_ge_category_update');
           Route::post('/setActive/{categoryId}','API\Admin\CategoryController@setActive')->name('admin_ge_category_active');
           Route::post('/setPassive/{categoryId}','API\Admin\CategoryController@setPassive')->name('admin_ge_category_passive');
           Route::get('/{categoryId}/subCategories','API\Admin\CategoryController@getSubCategories')->name('admin_ge_category_subCategories');
       });
       Route::prefix('subCategory')->group(function (){
           Route::post('/create','API\Admin\SubCategoryController@createSubCategory')->name('admin_ge_subCategory_create');
           Route::get('/show','API\Admin\SubCategoryController@showSubCategories')->name('admin_ge_subCategory_show');
           Route::get('/show/{subCategoryId}','API\Admin\SubCategoryController@showSubCategory')->name('admin_ge_subCategory_show_category');
           Route::post('/delete/{subCategoryId}','API\Admin\SubCategoryController@deleteSubCategory')->name('admin_ge_subCategory_delete');
           Route::post('/update/{subCategoryId}','API\Admin\SubCategoryController@updateSubCategory')->name('admin_ge_subCategory_update');
           Route::post('/setActive/{subCategoryId}','API\Admin\SubCategoryController@setActive')->name('admin_ge_subCategory_active');
           Route::post('/setPassive/{subCategoryId}','API\Admin\SubCategoryController@setPassive')->name('admin_ge_subCategory_passive');
       });
   });
   Route::prefix('cr')->group(function (){
       Route::prefix('grade')->group(function (){
           Route::post('/create','API\Admin\GradeController@createGrade')->name('admin_cr_grade_create');
           Route::get('/show','API\Admin\GradeController@showGradies')->name('admin_cr_grade_show');
           Route::get('/show/{gradeId}','API\Admin\GradeController@showGrade')->name('admin_cr_grade_show_grade');
           Route::post('/delete/{gradeId}','API\Admin\GradeController@deleteGrade')->name('admin_cr_grade_delete');
           Route::post('/update/{gradeId}','API\Admin\GradeController@updateGrade')->name('admin_cr_grade_update');
       });
       Route::prefix('lesson')->group(function (){
           Route::post('/create','API\Admin\LessonController@createLesson')->name('admin_cr_lesson_create');
           Route::get('/show','API\Admin\LessonController@showLessons')->name('admin_cr_lesson_show');
           Route::get('/show/{lessonId}','API\Admin\LessonController@showLesson')->name('admin_cr_lesson_show_grade');
           Route::post('/delete/{lessonId}','API\Admin\LessonController@deleteLesson')->name('admin_cr_lesson_delete');
           Route::post('/update/{lessonId}','API\Admin\LessonController@updateLesson')->name('admin_cr_lesson_update');
           Route::get('/{lessonId}/subjects','API\Admin\LessonController@getSubjects')->name('admin_cr_lesson_subjects');
       });
       Route::prefix('subject')->group(function (){
           Route::post('/create','API\Admin\SubjectController@createSubject')->name('admin_cr_subject_create');
           Route::get('/show','API\Admin\SubjectController@showSubjects')->name('admin_cr_subject_show');
           Route::get('/show/{subjectId}','API\Admin\SubjectController@showSubject')->name('admin_cr_subject_show_subject');
           Route::post('/delete/{subjectId}','API\Admin\SubjectController@deleteSubject')->name('admin_cr_subject_delete');
           Route::post('/update/{subjectId}','API\Admin\SubjectController@updateSubject')->name('admin_cr_subject_update');
       });
       Route::prefix('exam')->group(function (){
           Route::post('/create','API\Admin\ExamController@createExam')->name('admin_cr_exam_create');
           Route::get('/show','API\Admin\ExamController@showExams')->name('admin_cr_exam_show');
           Route::get('/show/{examId}','API\Admin\ExamController@showExam')->name('admin_cr_exam_show_exam');
           Route::post('/delete/{examId}','API\Admin\ExamController@deleteExam')->name('admin_cr_exam_delete');
           Route::post('/update/{examId}','API\Admin\ExamController@updateExam')->name('admin_cr_exam_update');
       });
   });
   Route::prefix('auth')->group(function (){
       Route::post('/admin/create','API\Admin\AuthController@createAdmin')->name('admin_auth_create_admin');
       Route::post('/admin/delete/{adminId}','API\Admin\AuthController@deleteAdmin')->name('admin_auth_delete_admin');
       Route::post('/admin/active/{adminId}','API\Admin\AuthController@activeAdmin')->name('admin_auth_active_admin');
       Route::post('/admin/passive/{adminId}','API\Admin\AuthController@passiveAdmin')->name('admin_auth_passive_admin');
       Route::get('/admin/show','API\Admin\AuthController@showAdmins')->name('admin_auth_show_admins');
       Route::get('/admin/get/{adminId}','API\Admin\AuthController@getAdmin')->name('admin_auth_get_admin');

       Route::get('/student/show','API\Admin\AuthController@showStudents')->name('admin_auth_show_students');
       Route::get('/student/get/{studentId}','API\Admin\AuthController@getStudent')->name('admin_auth_get_student');
       Route::post('/student/active/{studentId}','API\Admin\AuthController@activeStudent')->name('admin_auth_active_student');
       Route::post('/student/passive/{studentId}','API\Admin\AuthController@passiveStudent')->name('admin_auth_passive_student');
       Route::post('/student/delete/{studentId}','API\Admin\AuthController@deleteStudent')->name('admin_auth_delete_student');

       Route::get('/instructor/show','API\Admin\AuthController@showInstructors')->name('admin_auth_show_instructors');
       Route::get('/instructor/get/{instructorId}','API\Admin\AuthController@getInstructor')->name('admin_auth_get_instructor');
       Route::post('/instructor/active/{instructorId}','API\Admin\AuthController@activeInstructor')->name('admin_auth_active_instructor');
       Route::post('/instructor/passive/{instructorId}','API\Admin\AuthController@passiveInstructor')->name('admin_auth_passive_instructor');
       Route::post('/instructor/delete/{instructorId}','API\Admin\AuthController@deleteInstructor')->name('admin_auth_delete_instructor');

       Route::get('/guardian/show','API\Admin\AuthController@showGuardians')->name('admin_auth_show_guardians');
       Route::get('/guardian/get/{guardianId}','API\Admin\AuthController@getGuardian')->name('admin_auth_get_guardian');
       Route::post('/guardian/active/{guardianId}','API\Admin\AuthController@activeGuardian')->name('admin_auth_active_guardian');
       Route::post('/guardian/passive/{guardianId}','API\Admin\AuthController@passiveGuardian')->name('admin_auth_passive_guardian');
       Route::post('/guardian/delete/{guardianId}','API\Admin\AuthController@deleteGuardian')->name('admin_auth_delete_guardian');
   });
   Route::prefix('purchase')->group(function (){
       Route::get('getPurchases/{user_id}','API\Admin\PurchasesController@getPurchases')->name('api_get_purchases');
       Route::get('getPurchaseDetail/{payment_id}','API\Admin\PurchasesController@getPurchaseDetail')->name('api_get_purchase_detail');
       Route::get('getPurchasesAsDate/{user_id}','API\Admin\PurchasesController@getPurchasesAsDate')->name('api_get_purchases_as_date');

       Route::get('getInstructorsEarnByReferenceCode/{user_id}','API\Admin\PurchasesController@getInstructorsEarnByReferenceCode')->name('api_getInstructorsEarnByReferenceCode');
       Route::get('getInstructorEarnByReferenceCode/{user_id}/{instructor_id}','API\Admin\PurchasesController@getInstructorEarnByReferenceCode')->name('api_getInstructorEarnByReferenceCode');
       Route::post('confirmInstructorPriceByReferenceCode/{user_id}/{instructor_id}','API\Admin\PurchasesController@confirmInstructorPriceByReferenceCode')->name('api_confirmInstructorPriceByReferenceCode');

   });
   Route::prefix('course')->group(function (){
      Route::get('/all_ge_courses/{user_id}','API\Admin\CourseController@geAllCourses')->name('api_admin_ge_all_courses'); // ok
      Route::get('/all_pl_courses/{user_id}','API\Admin\CourseController@plAllCourses')->name('api_admin_pl_all_courses'); // ok
      Route::get('/all_pe_courses/{user_id}','API\Admin\CourseController@peAllCourses')->name('api_admin_pe_all_courses'); // ok
      Route::get('/all_live_courses/{user_id}','API\Admin\CourseController@liveAllCourses')->name('api_admin_live_all_courses'); // ok

      Route::post('/active_ge_course/{user_id}/{course_id}','API\Admin\CourseController@activeGeCourse')->name('api_admin_active_ge_course'); // ok
      Route::post('/active_pl_course/{user_id}/{course_id}','API\Admin\CourseController@activePlCourse')->name('api_admin_active_pl_course'); // ok
      Route::post('/active_pe_course/{user_id}/{course_id}','API\Admin\CourseController@activePeCourse')->name('api_admin_active_pe_course'); // ok
      //Route::post('/active_live_course/{user_id}/{course_id}','API\Admin\CourseController@activeLiveCourse')->name('api_admin_active_live_course');

      Route::post('/passive_ge_course/{user_id}/{course_id}','API\Admin\CourseController@passiveGeCourse')->name('api_admin_passive_ge_course'); // ok
      Route::post('/passive_pl_course/{user_id}/{course_id}','API\Admin\CourseController@passivePlCourse')->name('api_admin_passive_pl_course'); // ok
      Route::post('/passive_pe_course/{user_id}/{course_id}','API\Admin\CourseController@passivePeCourse')->name('api_admin_passive_pe_course'); // ok
      //Route::post('/passive_live_course/{user_id}/{course_id}','API\Admin\CourseController@passiveLiveCourse')->name('api_admin_passive_live_course');

       Route::post('/delete_ge_course/{user_id}/{course_id}','API\Admin\CourseController@deleteGeCourse')->name('api_admin_delete_ge_course'); // ok
       Route::post('/delete_pl_course/{user_id}/{course_id}','API\Admin\CourseController@deletePlCourse')->name('api_admin_delete_pl_course'); // ok
       Route::post('/delete_pe_course/{user_id}/{course_id}','API\Admin\CourseController@deletePeCourse')->name('api_admin_delete_pe_course'); // ok
       Route::post('/delete_live_course/{user_id}/{course_id}','API\Admin\CourseController@deleteLiveCourse')->name('api_admin_delete_live_course'); // ok

       Route::get('/detail_ge/{user_id}/{course_id}','API\Admin\CourseController@detailGeCourse')->name('api_admin_detail_ge_course'); // ok
       Route::get('/detail_pl/{user_id}/{course_id}','API\Admin\CourseController@detailPlCourse')->name('api_admin_detail_pl_course'); // ok
       Route::get('/detail_pe/{user_id}/{course_id}','API\Admin\CourseController@detailPeCourse')->name('api_admin_detail_pe_course'); // ok
       Route::get('/detail_live/{user_id}/{course_id}','API\Admin\CourseController@detailLiveCourse')->name('api_admin_detail_live_course'); // ok

       Route::get('/students_ge/{user_id}/{course_id}','API\Admin\CourseController@studentsGe')->name('api_admin_students_ge'); // ok
       Route::get('/students_pl/{user_id}/{course_id}','API\Admin\CourseController@studentsPl')->name('api_admin_students_pl'); // ok
       Route::get('/students_pe/{user_id}/{course_id}','API\Admin\CourseController@studentsPe')->name('api_admin_students_pe'); // ok
       Route::get('/students_live/{user_id}/{course_id}','API\Admin\CourseController@studentsLive')->name('api_admin_students_live'); // ok
   });

});

Route::prefix('guardian')->group(function (){
    Route::post('/createGuardian','API\Guardian\GuardianController@create')->name('guardian_create');
    Route::post('/updateGuardian/{userId}','API\Guardian\GuardianController@update')->name('guardian_update');
    Route::post('/deleteGuardian/{userId}','API\Guardian\GuardianController@delete')->name('guardian_delete');
    Route::get('/getGuardian/{userId}','API\Guardian\GuardianController@get')->name('guardian_get');

    // userId: velinin user id'si - otherId: öğrencinin user id'si
    Route::post('/addStudent','API\Guardian\GuardianController@addStudent')->name('guardian_add_student');
    Route::post('/deleteStudent/{userId}/{otherId}','API\Guardian\GuardianController@deleteStudent')->name('guardian_delete_student');
    Route::get('/getStudents/{userId}','API\Guardian\GuardianController@getStudents')->name('guardian_get_students'); // paginate var
    Route::get('/getStudentsList/{userId}','API\Guardian\GuardianController@getStudentsList')->name('guardian_get_students_list'); // paginate yok
    Route::get('/getStudent/{userId}/{otherId}','API\Guardian\GuardianController@getStudent')->name('guardian_get_student');

    // Hangi kursun hangi derslerini izlemiş bilgilerini getir
    Route::get('/courseInfo/{userId}/{otherId}','API\Guardian\GuardianController@getCourseInfo')->name('guardian_courseInfo'); // paginate yok
    // courseType: 1= ge, 2= pl, 3=pe
    Route::get('/courseInfo/{userId}/{otherId}/{courseId}/{courseType}','API\Guardian\GuardianController@getOneCourseInfo')->name('guardian_courseOneInfo'); // paginate yok
    // Hangi kursun sectionun ön/test sonuçları bilgilerini  getir
    Route::get('/firstLastTestInfo/{userId}/{otherId}','API\Guardian\GuardianController@getflTestInfo')->name('guardian_flTestInfo'); // paginate yok
    // courseType: 1= ge, 2= pl, 3=pe
    Route::get('/firstLastTestInfo/{userId}/{otherId}/{courseId}/{courseType}','API\Guardian\GuardianController@getOneflTestInfo')->name('guardian_flTestInfo'); // paginate yok

});
