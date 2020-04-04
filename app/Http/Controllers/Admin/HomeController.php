<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function categories(){
        return view('admin.categories');
    }

  /*  public function subCategories(){
        return view('admin.sub_categories');
    }*/

    public function cities(){
        return view('admin.cities');
    }

  /*  public function districts(){
        return view('admin.districts');
    }*/

    public function grade(){
        return view('admin.grade');
    }

    public function lesson(){
        return view('admin.lesson');
    }

  /*  public function subjects(){
        return view('admin.subjects');
    }*/

    public function getSubcategoryOfCategory($categoryId){
        // initializing
        $data = array();

        // operations
        $data['categoryId'] = $categoryId;
        return view('admin.sub_categories')->with('data',$data);
    }

    public function getDistrictsOfCity($cityId){
        // initializing
        $data = array();

        // operations
        $data['cityId'] = $cityId;
        return view('admin.districts')->with('data',$data);
    }

    public function getSubjectsOfLesson($lessonId){
        // initializing
        $data = array();

        // operations
        $data['lessonId'] = $lessonId;
        return view('admin.subjects')->with('data',$data);
    }
}
