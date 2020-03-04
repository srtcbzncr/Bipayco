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

Route::prefix('country')->group(function(){
    Route::get('index', 'API\Base\CountryController@index')->name('api_country_index');
    Route::get('{id}', 'API\Base\CountryController@show')->name('api_country_show');
    Route::get('{id}/cities', 'API\Base\CountryController@cities')->name('api_country_cities');
});

Route::prefix('category')->group(function(){
    Route::get('index', 'API\GeneralEducation\CategoryController@index')->name('api_category_index');
    Route::get('{id}', 'API\GeneralEducation\CategoryController@show')->name('api_category_show');
});

Route::prefix('course')->group(function(){
    Route::get('getPopularCourses', 'API\GeneralEducation\CourseController@getPopularCourses')->name('api_course_get_popular_courses');
    Route::get('getByCategoryFilterByNewest/{category_id}', 'API\GeneralEducation\CourseController@getByCategoryFilterByNewest')->name('api_course_get_by_category_filter_by_newest');
    Route::get('getByCategoryFilterByOldest/{category_id}', 'API\GeneralEducation\CourseController@getByCategoryFilterByOldest')->name('api_course_get_by_category_filter_by_oldest');
    Route::get('getByCategoryFilterByPriceASC/{category_id}', 'API\GeneralEducation\CourseController@getByCategoryFilterByPriceASC')->name('api_course_get_by_category_filter_by_price_asc');
    Route::get('getByCategoryFilterByPriceDESC/{category_id}', 'API\GeneralEducation\CourseController@getByCategoryFilterByPriceDESC')->name('api_course_get_by_category_filter_by_price_desc');
    Route::get('getByCategoryFilterByPoint/{category_id}', 'API\GeneralEducation\CourseController@getByCategoryFilterByPoint')->name('api_course_get_by_category_filter_by_point');
    Route::get('getByCategoryFilterByPurchases/{category_id}', 'API\GeneralEducation\CourseController@getByCategoryFilterByPurchases')->name('api_course_get_by_category_filter_by_purchases');
    Route::get('getByCategoryFilterByTrending/{category_id}', 'API\GeneralEducation\CourseController@getByCategoryFilterByTrending')->name('api_course_get_by_category_filter_by_trending');
    Route::get('getBySubCategoryFilterByNewest/{sub_category_id}', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByNewest')->name('api_course_get_by_sub_category_filter_by_newest');
    Route::get('getBySubCategoryFilterByOldest/{sub_category_id}', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByOldest')->name('api_course_get_by_sub_category_filter_by_oldest');
    Route::get('getBySubCategoryFilterByPriceASC/{sub_category_id}', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByPriceASC')->name('api_course_get_by_sub_category_filter_by_price_asc');
    Route::get('getBySubCategoryFilterByPriceDESC/{sub_category_id}', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByPriceDESC')->name('api_course_get_by_sub_category_filter_by_price_desc');
    Route::get('getBySubCategoryFilterByPoint/{sub_category_id}', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByPoint')->name('api_course_get_by_sub_category_filter_by_point');
    Route::get('getBySubCategoryFilterByPurchases/{sub_category_id}', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByPurchases')->name('api_course_get_by_sub_category_filter_by_purchases');
    Route::get('getBySubCategoryFilterByTrending/{sub_category_id}', 'API\GeneralEducation\CourseController@getBySubCategoryFilterByTrending')->name('api_course_get_by_sub_category_filter_by_trending');
    Route::get('{id}/comments', 'API\GeneralEducation\CourseController@getComments')->name('api_course_get_comments');
    Route::get('{id}/canEntry/{user_id}', 'API\GeneralEducation\CourseController@canEntry')->name('api_course_can_entry');
    Route::get('{id}/canComment/{user_id}', 'API\GeneralEducation\CourseController@canComment')->name('api_course_can_comment');
});

Route::prefix('comment')->group(function(){
   Route::post('create', 'API\GeneralEducation\CommentController@create')->name('api_comment_create');
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
    Route::post('course/create/{id?}', 'API\GeneralEducation\CourseController@createPost')->name('api_ge_course_create_post');
    Route::post('course/{id}/goals', 'API\GeneralEducation\CourseController@goalsPost')->name('api_ge_course_goals_post');
    Route::get('course/{id}/goals','API\GeneralEducation\CourseController@goalsGet')->name('api_ge_course_goals_get');
    Route::post('course/{id}/sections/create/{section_id?}', 'API\GeneralEducation\CourseController@sectionsPost')->name('api_ge_course_sections_post');
    Route::post('course/{id}/sections/delete/{section_id}', 'API\GeneralEducation\CourseController@sectionsDelete')->name('api_ge_course_sections_delete');
    Route::get('course/{id}/sections/get','API\GeneralEducation\CourseController@sectionsGet')->name('api_ge_course_sections_get');
    Route::post('course/{id}/sections/{section_id}/lessons/create/{lesson_id?}','API\GeneralEducation\CourseController@lessonsPost')->name('api_ge_course_sections_lessons_post');
    Route::post('course/{id}/sections/{section_id}/lessons/delete/{lesson_id}','API\GeneralEducation\CourseController@lessonsDelete')->name('api_ge_course_sections_lessons_delete');
    Route::post('course/{id}/sections/{section_id}/lessons/{lesson_id}/source/delete/{source_id}','API\GeneralEducation\CourseController@sourceDelete')->name('api_ge_course_sections_lessons_sources_delete');
    Route::post('course/{id}/sections/{section_id}/lessons/{lesson_id}/source/cancel','API\GeneralEducation\CourseController@sourceDeleteCancel')->name('api_ge_course_sections_lessons_sources_delete_cancel');

    Route::post('course/{id}/instructors', 'API\GeneralEducation\CourseController@instructorsPost')->name('api_ge_course_instructors_post');
    Route::get('course/{id}/instructors','API\GeneralEducation\CourseController@instructorsGet')->name('api_ge_course_instructors_get');
    Route::get('search', 'API\Auth\AuthController@getInstructorByMail')->name('api_search_instructor');
    Route::post('course/{id}/section/{section_id}/up','API\GeneralEducation\CourseController@sectionUp')->name('api_ge_course_section_up');
    Route::post('course/{id}/section/{section_id}/down','API\GeneralEducation\CourseController@sectionDown')->name('api_ge_course_section_down');
    Route::post('course/{id}/section/{section_id}/lesson/{lesson_id}/up','API\GeneralEducation\CourseController@lessonUp')->name('api_ge_course_lesson_up');
    Route::post('course/{id}/section/{section_id}/lesson/{lesson_id}/down','API\GeneralEducation\CourseController@lessonDown')->name('api_ge_course_lesson_down');
});

# Kurs İzleme Bölümü İçin Routes
Route::prefix('learn')->group(function (){
    Route::get('generalEducation/{course_id}','API\Learn\GeneralEducation\LearnController@getCourse')->name('api_get_general_education_course');
    Route::get('generalEducation/{course_id}/lesson/{lesson_id}','API\Learn\GeneralEducation\LearnController@getLesson')->name('api_get_general_education_lesson');
    Route::get('generalEducation/{course_id}/lesson/{lesson_id}/sources','API\Learn\GeneralEducation\LearnController@getSources')->name('api_get_general_education_sources');
    Route::get('generalEducation/{course_id}/lesson/{lesson_id}/discussion','API\Learn\GeneralEducation\LearnController@getDiscussions')->name('api_get_general_education_discussion');
    Route::post('generalEducation/{course_id}/lesson/{lesson_id}/discussion/ask','API\Learn\GeneralEducation\LearnController@askQuestion')->name('api_get_general_education_discussion_ask');
    Route::post('generalEducation/{course_id}/lesson/{lesson_id}/discussion/answer/{question_id}','API\Learn\GeneralEducation\LearnController@answerQuestion')->name('api_get_general_education_discussion_answer');
    Route::post('generalEducation/{course_id}/lesson/{lesson_id}/complete','API\Learn\GeneralEducation\LearnController@completeLesson')->name('api_get_general_education_complete_lesson');
    Route::get('generalEducation/{course_id}/user/{user_id}/defaultLesson','API\Learn\GeneralEducation\LearnController@defaultLesson')->name('api_get_general_education_default_lesson');

});

Route::prefix('basket')->group(function (){
    Route::post('/add','API\Basket\BasketController@add')->name('add_basket');
    Route::post('/delete','API\Basket\BasketController@remove')->name('remove_basket');
    Route::get('/show/{user_id}','API\Basket\BasketController@show')->name('show_basket');
});

Route::get('myCourses/{id}', 'API\Auth\AuthController@courses')->name('api_my_courses');
Route::get('lastCourses/{id}', 'API\Auth\AuthController@getLastWatchedCourses')->name('api_my_last_courses');
