@extends('layouts.admin')
@section('content')
    <!--general education-->
    <div class="uk-container">
        <div class="section-heading uk-position-relative uk-margin-medium-top none-border uk-clearfix">
            <div class="uk-float-left uk-margin-top">
                <h2>@lang('front/auth.general_education')</h2>
            </div>
            <div class="uk-float-right">
                <a href="{{route('ge_course_create_get')}}" class="uk-button uk-button-success uk-margin-small-right uk-margin-small-top"><i class="fas fa-plus uk-margin-small-right"></i>@lang('front/auth.add_lessons')</a>
                <a href="{{route('ge_index')}}" class="uk-button uk-button-grey uk-margin-small-top">@lang('front/auth.see_more')</a>
            </div>
        </div>
    </div>
    @if($data['ge']==null || count($data['ge'])==0)
    <div class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
        <h4 class="uk-text-bold uk-margin-remove-top">@lang('front/auth.not_found_content')</h4>
    </div>
    @else
    <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
        <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
            @foreach($data['ge'] as $course)
            <li>
                <instructor-courses-card
                    :course="{{$course}}"
                    user-id="{{Auth::user()->id}}"
                    module-name="generalEducation"
                    student-count="{{$course->studentCount()}}"
                    course-route="{{route('ge_course', $course->id)}}"
                    edit-course-route="{{route('ge_course_create_get',$course->id)}}"
                ></instructor-courses-card>
            </li>
            @endforeach
        </ul>
        <a class="uk-position-center-left uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
        <a class="uk-position-center-right uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-next uk-slider-item="next"></a>
        <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin">
            <li uk-slider-item="0" class="">
                <a href="#"></a>
            </li>
        </ul>
    </div>
    @endif
    <!--prepare for lessons-->
    <div class="uk-container">
        <div class="section-heading uk-position-relative uk-margin-medium-top none-border uk-clearfix">
            <div class="uk-float-left uk-margin-top">
                <h2>@lang('front/auth.prepare_for_lessons')</h2>
            </div>
            <div class="uk-float-right">
                <a href="{{route('pl_course_create_get')}}" class="uk-button uk-button-success uk-margin-small-right uk-margin-small-top"><i class="fas fa-plus uk-margin-small-right"></i>@lang('front/auth.add_lessons')</a>
                <a href="{{route('pl_index')}}" class="uk-button uk-button-grey uk-margin-small-top">@lang('front/auth.see_more')</a>
            </div>
        </div>
    </div>
    @if($data['pl']==null || count($data['pl'])==0)
    <div class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
        <h4 class="uk-text-bold uk-margin-remove-top">@lang('front/auth.not_found_content')</h4>
    </div>
    @else
    <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
        <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
            @foreach($data['pl'] as $course)
                <li>
                    <instructor-courses-card
                        :course="{{$course}}"
                        user-id="{{Auth::user()->id}}"
                        module-name="prepareLessons"
                        student-count="{{$course->studentCount()}}"
                        course-route="{{route('pl_course', $course->id)}}"
                        edit-course-route="{{route('pl_course_create_get',$course->id)}}"
                    ></instructor-courses-card>
                </li>
            @endforeach
        </ul>
        <a class="uk-position-center-left uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
        <a class="uk-position-center-right uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-next uk-slider-item="next"></a>
        <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin">
            <li uk-slider-item="0" class="">
                <a href="#"></a>
            </li>
        </ul>
    </div>
    @endif
    <!--prepare for exams-->
    <div class="uk-container">
        <div class="section-heading uk-position-relative uk-margin-medium-top none-border uk-clearfix">
            <div class="uk-float-left uk-margin-top">
                <h2>@lang('front/auth.prepare_for_exams')</h2>
            </div>
            <div class="uk-float-right">
                <a href="{{route('pe_course_create_get')}}" class="uk-button uk-button-success uk-margin-small-right uk-margin-small-top"><i class="fas fa-plus uk-margin-small-right"></i>@lang('front/auth.add_lessons')</a>
                <a href="{{route('pe_index')}}" class="uk-button uk-button-grey uk-margin-small-top">@lang('front/auth.see_more')</a>
            </div>
        </div>
    </div>
    @if($data['pe']==null || count($data['pe'])==0)
    <div class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
        <h4 class="uk-text-bold uk-margin-remove-top">@lang('front/auth.not_found_content')</h4>
    </div>
    @else
    <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium  uk-margin-large-bottom" uk-slider>
        <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
            @foreach($data['pe'] as $course)
                <li>
                    <instructor-courses-card
                        :course="{{$course}}"
                        user-id="{{Auth::user()->id}}"
                        module-name="prepareExams"
                        student-count="{{$course->studentCount()}}"
                        course-route="{{route('pe_course', $course->id)}}"
                        edit-course-route="{{route('pe_course_create_get',$course->id)}}"
                    ></instructor-courses-card>
                </li>
            @endforeach
        </ul>
        <a class="uk-position-center-left uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
        <a class="uk-position-center-right uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-next uk-slider-item="next"></a>
        <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin">
            <li uk-slider-item="0" class="">
                <a href="#"></a>
            </li>
        </ul>
    </div>
    @endif
@endsection
