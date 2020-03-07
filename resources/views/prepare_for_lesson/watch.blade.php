@extends('layouts.app')
@section('content')
    <div>
        <!-- lesson view area -->
        <div class="uk-margin-left uk-margin-right uk-margin-top uk-margin-bottom uk-margin-medium-bottom">
            <watch
                course-id="{{$course->id}}"
                first-lesson-id="{{$course->sections[0]->lessons[0]->id}}"
                module-name="prepareLessons"
            > </watch>
        </div>
        <!-- Q & A area -->
        <h3 class="uk-heading-line uk-text-center"><span>Soru Cevap</span></h3>
        <question-answer-area
            student-id="{{Auth::user()->id}}"
            course-id="{{$course->id}}"
            module-name="prepareLessons"
        > </question-answer-area>
    </div>
@endsection
