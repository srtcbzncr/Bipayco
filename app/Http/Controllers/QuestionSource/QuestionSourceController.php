<?php

namespace App\Http\Controllers\QuestionSource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionSourceController extends Controller
{
    public function show(){
        return view('instructor.question_source');
    }

    public function createGet(){
        return view('instructor.question_source_create');
    }
}
