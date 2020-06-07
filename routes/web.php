<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home'); // pe_ok
Route::get('register', 'Auth\AuthController@registerGet')->name('registerGet');
Route::post('register', 'Auth\AuthController@registerPost')->name('registerPost');
Route::get('login', 'Auth\AuthController@loginGet')->name('loginGet');
Route::post('login', 'Auth\AuthController@loginPost')->name('loginPost');
Route::get('logout', 'Auth\AuthController@logout')->name('logout');
Route::get('error', 'HomeController@error')->name('error');

Route::get('forgotPassword','Auth\AuthController@forgotPassGet')->name('forgotPasswordGet'); // şifremi unuttum ekranı getirir.
Route::post('forgotPassword','Auth\AuthController@forgotPassPost')->name('forgotPasswordPost'); // email gönder. İçerisinde token barındıran bir link ile.
Route::post('forgotPassword/reset','Auth\AuthController@forgotPassReset')->name('forgotPasswordPostReset'); // yeni şifreyi girer ve home ekranına gider.
Route::get('newPassword/{token}','Auth\AuthController@newPasswordGet')->name('newPassword'); // yeni şifreyi girmek için view döndürür.

Route::post('search','Search\SearchController@search')->name('search');

Route::group(['prefix' => 'iyzico', 'middleware' => 'auth'],function (){
    Route::get('/billing','Iyzico\CheckOutController@billing')->name('iyzico_billing');
    Route::post('/checkOut','Iyzico\CheckOutController@checkOut')->name('iyzico_check_out');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){
    Route::get('/', 'Admin\HomeController@dashboard')->name('adminDashboard');
    Route::get('/categories','Admin\HomeController@categories')->name('adminCategories');
   // Route::get('/subCategories','Admin\HomeController@subCategories')->name('adminSubCategories');
    Route::get('/cities','Admin\HomeController@cities')->name('adminCities');
   // Route::get('/districts','Admin\HomeController@districts')->name('adminDistricts');
    Route::get('/grade','Admin\HomeController@grade')->name('adminGrade');
    Route::get('/lesson','Admin\HomeController@lesson')->name('adminLesson');
    //Route::get('/subjects','Admin\HomeController@subjects')->name('adminSubjects');
    Route::get('/category/{categoryId}/subCategories','Admin\HomeController@getSubcategoryOfCategory')->name('admingetSubjects');
    Route::get('/city/{cityId}/districts','Admin\HomeController@getDistrictsOfCity')->name('admingetDistricts');
    Route::get('/lesson/{lessonId}/subjects','Admin\HomeController@getSubjectsOfLesson')->name('admingetSubjects');
    Route::get('/exam','Admin\HomeController@exam')->name('admin_get_exam');

    Route::get('/users','Admin\HomeController@users')->name('admin_users');
    Route::get('/instructors','Admin\HomeController@instructors')->name('admin_instructor');
    Route::get('/guardians','Admin\HomeController@guardians')->name('admin_guardian');
    Route::get('/admins','Admin\HomeController@admins')->name('admin_admins');
});

Route::group(['prefix' => 'guardian' , 'middleware' => 'auth'],  function (){
   Route::get('/students','Guardian\GuardianController@students')->name('guardian_students');
   Route::get('/student_profile','Guardian\GuardianController@studentProfile')->name('guardian_student_profile');
   Route::get('/student_course_detail/{guardianUserId}/{studentUserId}/{courseId}','Guardian\GuardianController@studentCourseDetail')->name('guardian_student_course_detail');
});

Route::group(['prefix' => 'settings', 'middleware' => 'auth'], function(){
    Route::get('/', 'Auth\AuthController@settings')->name('settings');
    Route::post('updatePersonalData', 'Auth\AuthController@updatePersonalData')->name('updatePersonalData');
    Route::post('updateAvatar', 'Auth\AuthController@updateAvatar')->name('updateAvatar');
    Route::post('updatePassword', 'Auth\AuthController@updatePassword')->name('updatePassword');
    Route::post('updateInstructorData', 'Auth\AuthController@updateInstructorData')->name('updateInstructorData');
});

Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function(){
    Route::get('student/{id}', 'Auth\AuthController@studentProfile')->name('student_profile');
    Route::get('/basket','Auth\AuthController@getBasketView')->name('get_basket');
    Route::get('/favorite','Auth\AuthController@getFavoriteView')->name('get_favorite');
});
Route::get('instructorProfile/{id}', 'Auth\AuthController@instructorProfile')->name('instructor_profile');

Route::group(['prefix' => 'instructor', 'middleware' => 'auth'], function(){
   Route::get('create', 'Auth\AuthController@createInstructorGet')->name('instructor_create_get');
   Route::post('create', 'Auth\AuthController@createInstructorPost')->name('instructor_create_post');
   Route::get('courses', 'Auth\InstructorController@courses')->middleware('hasInstructorProfile')->name('instructor_courses');
   Route::get('books', 'Auth\InstructorController@books')->middleware('hasInstructorProfile')->name('instructor_books');
   Route::get('exams', 'Auth\InstructorController@exams')->middleware('hasInstructorProfile')->name('instructor_exams');
   Route::get('homeworks', 'Auth\InstructorController@homeworks')->middleware('hasInstructorProfile')->name('instructor_homeworks');
   Route::get('performance', 'Auth\InstructorController@performance')->middleware('hasInstructorProfile')->name('instructor_performance');
   Route::get('questions', 'Auth\InstructorController@questions')->middleware('hasInstructorProfile')->name('instructor_questions');
   Route::group(['prefix' => 'ge', 'middleware' => 'hasInstructorProfile'], function(){
           Route::get('course/create/{id?}', 'GeneralEducation\CourseController@createGet')->name('ge_course_create_get');
   });
    Route::group(['prefix' => 'pl', 'middleware' => 'hasInstructorProfile'], function(){
        Route::get('course/create/{id?}', 'PrepareLesson\CourseController@createGet')->name('pl_course_create_get');
    });
    Route::group(['prefix' => 'pe', 'middleware' => 'hasInstructorProfile'], function(){
        Route::get('course/create/{id?}', 'PrepareExams\CourseController@createGet')->name('pe_course_create_get'); // pe_ok
    });
});

Route::group(['prefix' => 'ge'], function(){
    Route::group(['prefix' => 'category'], function(){
        Route::get('{id}', 'GeneralEducation\CategoryController@show')->name('ge_category_courses');
    });
    Route::group(['prefix' => 'subCategory'], function(){
        Route::get('{id}', 'GeneralEducation\SubCategoryController@show')->name('ge_sub_category_courses');
    });
    Route::group(['prefix' => 'course'], function(){
        Route::get('{id}', 'GeneralEducation\CourseController@show')->name('ge_course');
        //Route::get('{id}/watch', 'GeneralEducation\CourseController@watch')->name('ge_watch');
    });
    Route::get('index', 'HomeController@ge_index')->name('ge_index');
});

Route::group(['prefix' => 'pl'],function (){
    Route::group(['prefix' => 'category'],function (){
        Route::get('{id}','PrepareLesson\CategoryController@show')->name('pl_category_courses');
    });
    Route::group(['prefix' => 'lessons'], function(){
        Route::get('{id}', 'PrepareLesson\SubCategoryController@show')->name('pl_sub_category_courses');
    });
    Route::group(['prefix' => 'course'], function(){
        Route::get('{id}', 'PrepareLesson\CourseController@show')->name('pl_course');
        //Route::get('{id}/watch', 'PrepareLesson\CourseController@watch')->name('pl_watch');
    });
    Route::get('index', 'HomeController@pl_index')->name('pl_index');
});

Route::group(['prefix' => 'pe'],function (){
    #buna gerek yok.
    Route::group(['prefix' => 'category'],function (){
        Route::get('{id}','PrepareLesson\CategoryController@show')->name('pe_category_courses');
    });
    Route::group(['prefix' => 'exams'], function(){
        Route::get('{id}', 'PrepareExams\SubCategoryController@show')->name('pe_sub_category_courses');
        //Route::get('/', 'PrepareExams\SubCategoryController@show')->name('pe_sub_category_courses'); // pe_ok
    });
    Route::group(['prefix' => 'course'], function(){
        Route::get('{id}', 'PrepareExams\CourseController@show')->name('pe_course'); // pe_ok
        //Route::get('{id}/watch', 'PrepareLesson\CourseController@watch')->name('pl_watch');
    });
    Route::get('index', 'HomeController@pe_index')->name('pe_index'); // pe_ok
});

Route::group(['prefix' => 'questionSource', 'middleware' => 'auth'],function (){
    Route::get('/','QuestionSource\QuestionSourceController@show')->name('questionSource_show');
    Route::get('/create','QuestionSource\QuestionSourceController@createGet')->name('questionSource_create');
    Route::get('/update/{questionId}','QuestionSource\QuestionSourceController@updateGet')->name('questionSource_update');
});

Route::group(['prefix' => 'learn', 'middleware' => 'auth'],function (){
   Route::group(['prefix' => 'ge'],function (){
       Route::get('/course/{course_id}','GeneralEducation\LearnController@getCourse')->name('learn_ge_course_get');
       Route::get('/course/{course_id}/lesson/{lesson_id}','GeneralEducation\LearnController@getLesson')->name('learn_ge_lesson_get');
   });

   Route::group(['prefix' => 'pl'],function (){
       Route::get('/course/{course_id}','PrepareLesson\LearnController@getCourse')->name('learn_pl_course_get');
       Route::get('/course/{course_id}/lesson/{lesson_id}','PrepareLesson\LearnController@getLesson')->name('learn_pl_lesson_get');
       Route::group(['prefix' => 'test'],function (){
          Route::get('/firstTest/{courseId}/{sectionId}','PrepareLesson\LearnController@getFirstTest')->name('learn_pl_get_first_test');
          Route::get('/lastTest/{courseId}/{sectionId}','PrepareLesson\LearnController@getLastTest')->name('learn_pl_get_last_test');
       });
   });

   Route::group(['prefix' => 'pe'],function (){
       Route::get('/course/{course_id}','PrepareExams\LearnController@getCourse')->name('learn_pe_course_get');
       Route::get('/course/{course_id}/lesson/{lesson_id}','PrepareExams\LearnController@getLesson')->name('learn_pe_lesson_get');
       Route::group(['prefix' => 'test'],function (){
          Route::get('/firstTest/{courseId}/{sectionId}','PrepareExams\LearnController@getFirstTest')->name('learn_pe_get_first_test');
          Route::get('/lastTest/{courseId}/{sectionId}','PrepareExams\LearnController@getLastTest')->name('learn_pe_get_last_test');
       });
   });


});





