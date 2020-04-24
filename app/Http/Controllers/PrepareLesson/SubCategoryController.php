<?php

namespace App\Http\Controllers\PrepareLesson;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function show(){
        return view('prepare_for_lesson.lesson');
    }
}
