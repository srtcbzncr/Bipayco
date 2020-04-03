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


# Home'daki ge,pl vb. kurslar.
Route::get('/home/ge/{user_id?}', 'API\HomeController@indexGe')->name('home_ge');
Route::get('/home/pl/{user_id?}', 'API\HomeController@indexPl')->name('home_pl');
Route::get('/home/pe/{user_id?}', 'API\HomeController@indexPe')->name('home_pe');
Route::get('/home/books/{user_id?}', 'API\HomeController@indexBooks')->name('home_books');
Route::get('/home/exams/{user_id?}', 'API\HomeController@indexExams')->name('home_exams');

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
    });
    Route::get('index', 'API\HomeController@ge_index')->name('ge_index');

    Route::get('/inBasket/{user_id}/{course_id}','API\GeneralEducation\CourseController@inBasket')->name('ge_in_basket');
    Route::get('/similarCourses/{course_id}/{user_id?}','API\GeneralEducation\CourseController@simularCourses')->name('ge_simularCourses');
});

Route::group(['prefix' => 'pl'],function (){
    Route::group(['prefix' => 'category'],function (){
        # pl de burası yok.
        Route::get('{id}','API\PrepareLessons\CategoryController@show')->name('pl_category_courses');
    });
    Route::group(['prefix' => 'subCategory'], function(){
        # pl de burası yok.
        Route::get('{id}', 'API\PrepareLessons\SubCategoryController@show')->name('pl_sub_category_courses');
    });
    Route::group(['prefix' => 'course'], function(){
        Route::get('{id}', 'API\PrepareLessons\CourseController@show')->name('pl_course');
    });

    # pl de burası yok.
    Route::get('index', 'API\HomeController@pl_index')->name('pl_index');

    Route::get('/inBasket/{user_id}/{course_id}','API\PrepareLessons\CourseController@inBasket')->name('pl_in_basket');
    Route::get('/similarCourses/{course_id}/{user_id?}','API\PrepareLessons\CourseController@simularCourses')->name('pl_simularCourses');
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
    Route::get('{id}/comments', 'API\GeneralEducation\CourseController@getComments')->name('api_course_get_comments');
    Route::get('{id}/canEntry/{user_id}', 'API\GeneralEducation\CourseController@canEntry')->name('api_course_can_entry');
    Route::get('{id}/canComment/{user_id}', 'API\GeneralEducation\CourseController@canComment')->name('api_course_can_comment');
    Route::get('{id}/generalEducation/previewLessons','API\GeneralEducation\CourseController@getPreviewLessons')->name('api_ge_preview_lessons');
    Route::get('{id}/prepareLessons/previewLessons','API\PrepareLessons\CourseController@getPreviewLessons')->name('api_pl_preview_lessons');

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
    # General Education
    Route::post('generalEducation/course/create/{id?}', 'API\GeneralEducation\CourseController@createPost')->name('api_ge_course_create_post');
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
    Route::post('prepareLessons/course/{id}/goals', 'API\PrepareLessons\CourseController@goalsPost')->name('api_pl_course_goals_post');
    Route::get('prepareLessons/course/{id}/goals','API\PrepareLessons\CourseController@goalsGet')->name('api_pl_course_goals_get');
    Route::get('prepareLessons/course/{id}/subjects','API\PrepareLessons\CourseController@getSubjects')->name('api_pl_course_subjects');
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
    Route::get('prepareLessons/getRandomQuestions','API\PrepareLessons\CourseController@getRandomQuestions')->name('api_pl_course_getRandomQuestions');

    # getSubjects
    Route::get('subjects/lesson/{id}','API\PrepareLessons\CourseController@getSubjectsForLesson')->name('api_pl_course_subjects_get');

});

# Kurs İzleme Bölümü İçin Routes
Route::prefix('learn')->group(function (){
    Route::get('generalEducation/{course_id}/user/{user_id}','API\Learn\GeneralEducation\LearnController@getCourse')->name('api_get_general_education_course');
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
    Route::post('/deleteAll/{user_id}','API\Basket\BasketController@removeAll')->name('remove_basket_all');
    Route::get('/show/{user_id}','API\Basket\BasketController@show')->name('show_basket');
});
Route::prefix('favorite')->group(function (){
    Route::post('/add','API\Favorite\FavoriteController@add')->name('add_basket');
    Route::post('/delete','API\Favorite\FavoriteController@remove')->name('remove_basket');
    Route::get('/show/{user_id}','API\Favorite\FavoriteController@show')->name('show_basket');
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
           Route::get('/{cityId}/district','API\Admin\BaseController@getDistricts')->name('admin_bs_city_district');
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
   });
});
