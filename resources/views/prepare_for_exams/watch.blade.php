@extends('layouts.app')
@section('content')
    <div>
        <!-- lesson view area -->
        <div class="uk-margin-left uk-margin-right uk-margin-top uk-margin-bottom uk-margin-medium-bottom">
            <watch
                @if($isTest)
                    is-test
                    :selected="{{$course->selectedSection}}"
                @else
                    :selected="{{$course->selectedLesson}}"
                @endif
                :course="{{$course}}"
                user-id="{{Auth::user()->id}}"
                course-id="{{$course->id}}"
                section-text="@lang('front/auth.section')"
                full-screen-text="@lang('front/auth.full_screen')"
                lesson-text="@lang('front/auth.lessons')"
                sources-text="@lang('front/auth.sources')"
                module-name="prepareExams"
                @if(isset($testType))
                    test-type="{{$testType}}"
                @endif
            > </watch>
        </div>

        @if(!$isTest)
            <!-- Q & A area -->
            <h3 class="uk-heading-line uk-text-center"><span>@lang('front/auth.question_answer')</span></h3>
            <question-answer-area
                student-id="{{Auth::user()->id}}"
                course-id="{{$course->id}}"
                selected-lesson-id="{{$course->selectedLesson->id}}"
                day-before-text="@lang('front/auth.day(s)') @lang('front/auth.before')"
                month-before-text="@lang('front/auth.month(s)') @lang('front/auth.before')"
                year-before-text="@lang('front/auth.year(s)') @lang('front/auth.before')"
                minute-before-text="@lang('front/auth.minute(s)') @lang('front/auth.before')"
                hour-before-text="@lang('front/auth.hour(s)') @lang('front/auth.before')"
                module-name="prepareExams"
            > </question-answer-area>
        @endif
    </div>
@endsection
