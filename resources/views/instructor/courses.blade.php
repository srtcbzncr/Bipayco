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
                <div class="uk-card-default uk-card-hover uk-card-small uk-width Course-card uk-inline-clip uk-transition-toggle" tabindex="0">
                    <a href="{{route('ge_course', $course->id)}}" class="uk-link-reset">
                        <div class="course-img uk-background-center-center uk-background-cover uk-height-medium" style="background-image: url({{$course->image}})"></div>
                        <div class="uk-card-body">
                            <h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">{{$course->name}}</h4>
                            <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="uk-height-small">{{$course->description}}</p>
                            <hr class="uk-margin-remove-top">
                            <div class="uk-grid uk-child-width-1-2">
                                <div>
                                    <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right"><i class="fas fa-user-graduate uk-margin-small-right"></i>{{$course->studentCount()}} @lang('front/auth.student')</p>
                                    <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right"><i class="fas fa-calendar-alt uk-margin-small-right"></i>{{date("d/m/Y", strtotime($course->created_at))}}</p>
                                </div>
                                <div class="uk-flex justify-content-between align-items-center ">
                                    <a class="uk-button-text uk-button" href="{{route('ge_course_create_get',$course->id)}}"><i class="fas fa-cog"></i></a>
                                    @if($course->active)
                                        <a class="uk-button-text uk-button" href="#"><i class="fas fa-times-circle"></i></a>
                                    @else
                                        <a class="uk-button-text uk-button" href="#"><i class="fas fa-check-circle"></i></a>
                                    @endif
                                    <a class="uk-button uk-button-text" href="#"> <i class="fas fa-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
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
                <a href="{{route('ge_index')}}" class="uk-button uk-button-grey uk-margin-small-top">@lang('front/auth.see_more')</a>
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
                    <div class="uk-card-default uk-card-hover uk-card-small uk-width Course-card uk-inline-clip uk-transition-toggle" tabindex="0">
                        <a href="{{route('ge_course', $course->id)}}" class="uk-link-reset">
                            <div class="course-img uk-background-center-center uk-background-cover uk-height-medium" style="background-image: url({{$course->image}})"></div>
                            <div class="uk-card-body">
                                <h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">{{$course->name}}</h4>
                                <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="uk-height-small">{{$course->description}}</p>
                                <hr class="uk-margin-remove-top">
                                <div class="uk-grid uk-child-width-1-2">
                                    <div>
                                        <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right"><i class="fas fa-user-graduate uk-margin-small-right"></i>{{$course->studentCount()}} @lang('front/auth.student')</p>
                                        <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right"><i class="fas fa-calendar-alt uk-margin-small-right"></i>{{date("d/m/Y", strtotime($course->created_at))}}</p>
                                    </div>
                                    <div class="uk-flex justify-content-between align-items-center ">
                                        <a class="uk-button-text uk-button" href="#"><i class="fas fa-cog"></i></a>
                                        @if($course->active)
                                            <a class="uk-button-text uk-button" href="#"><i class="fas fa-times-circle"></i></a>
                                        @else
                                            <a class="uk-button-text uk-button" href="#"><i class="fas fa-check-circle"></i></a>
                                        @endif
                                        <a class="uk-button uk-button-text" href="#"> <i class="fas fa-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
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
                <a href="{{route('ge_index')}}" class="uk-button uk-button-success uk-margin-small-right uk-margin-small-top"><i class="fas fa-plus uk-margin-small-right"></i>@lang('front/auth.add_lessons')</a>
                <a href="{{route('ge_index')}}" class="uk-button uk-button-grey uk-margin-small-top">@lang('front/auth.see_more')</a>
            </div>
        </div>
    </div>
    @if($data['pe']==null || count($data['pe'])==0)
    <div class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
        <h4 class="uk-text-bold uk-margin-remove-top">@lang('front/auth.not_found_content')</h4>
    </div>
    @else
    <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
        <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
            @foreach($data['pe'] as $course)
                <li>
                    <div class="uk-card-default uk-card-hover uk-card-small uk-width Course-card uk-inline-clip uk-transition-toggle" tabindex="0">
                        <a href="{{route('ge_course', $course->id)}}" class="uk-link-reset">
                            <div class="course-img uk-background-center-center uk-background-cover uk-height-medium" style="background-image: url({{$course->image}})"></div>
                            <div class="uk-card-body">
                                <h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">{{$course->name}}</h4>
                                <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="uk-height-small">{{$course->description}}</p>
                                <hr class="uk-margin-remove-top">
                                <div class="uk-grid uk-child-width-1-2">
                                    <div>
                                        <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right"><i class="fas fa-user-graduate uk-margin-small-right"></i>{{$course->studentCount()}} @lang('front/auth.student')</p>
                                        <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right"><i class="fas fa-calendar-alt uk-margin-small-right"></i>{{date("d/m/Y", strtotime($course->created_at))}}</p>
                                    </div>
                                    <div class="uk-flex justify-content-between align-items-center ">
                                        <a class="uk-button-text uk-button" href="#"><i class="fas fa-cog"></i></a>
                                        @if($course->active)
                                            <a class="uk-button-text uk-button" href="#"><i class="fas fa-times-circle"></i></a>
                                        @else
                                            <a class="uk-button-text uk-button" href="#"><i class="fas fa-check-circle"></i></a>
                                        @endif
                                        <a class="uk-button uk-button-text" href="#"> <i class="fas fa-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
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
