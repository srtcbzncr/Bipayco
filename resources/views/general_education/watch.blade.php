@extends('layouts.app')
@section('content')
    <div>
        <!-- lesson view area -->
        <div class="uk-margin-left uk-margin-right uk-margin-top uk-margin-bottom uk-margin-medium-bottom">
            <watch
                :course="{{$course}}"
                :selected-lesson="{{$course->selectedLesson}}"
                user-id="{{Auth::user()->id}}"
                course-id="{{$course->id}}"
                first-lesson-id="{{$course->sections[0]->lessons[0]->id}}"
                module-name="generalEducation"
                section-text="@lang('front/auth.section')"
                full-screen-text="@lang('front/auth.full_screen')"
                lesson-text="@lang('front/auth.lessons')"
                sources-text="@lang('front/auth.sources')"
            > </watch>
        </div>
        <!-- Q & A area -->
        <h3 class="uk-heading-line uk-text-center"><span>Soru Cevap</span></h3>
        <question-answer-area
            student-id="{{Auth::user()->id}}"
            course-id="{{$course->id}}"
            selected-lesson-id="{{$course->selectedLesson->id}}"
            module-name="generalEducation"
            day-before-text="@lang('front/auth.day(s)') @lang('front/auth.before')"
            month-before-text="@lang('front/auth.month(s)') @lang('front/auth.before')"
            year-before-text="@lang('front/auth.year(s)') @lang('front/auth.before')"
            minute-before-text="@lang('front/auth.minute(s)') @lang('front/auth.before')"
            hour-before-text="@lang('front/auth.hour(s)') @lang('front/auth.before')"
        > </question-answer-area>
    </div>
@endsection
