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

    public function cities(){
        return view('admin.cities');
    }

    public function districts(){
        return view('admin.districts');
    }

    public function grade(){
        return view('admin.grade');
    }

    public function lesson(){
        return view('admin.lesson');
    }

    public function subjects(){
        return view('admin.subjects');
    }
}
