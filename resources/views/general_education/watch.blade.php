@extends('layouts.app')
@section('content')
    <div>
        <!-- lesson view area -->
        <div class="uk-margin-left uk-margin-right uk-margin-top uk-margin-bottom uk-margin-medium-bottom">
            <div class="uk-card uk-card-default uk-align-center">
                <div class="uk-card-body uk-grid uk-padding-remove">
                    <!-- video player -->
                    <div class="uk-width-3-4@m uk-flex align-items-center justify-content-center">
                        <video width="400" controls>
                            <source src="#" type="video/mp4">
                            <source src="#" type="video/ogg">
                            Your browser does not support HTML5 video.
                        </video>
                        <!--<iframe v-else :src="'/'+learnCourse.sections[0].lessons[0].file_path" class="uk-width" style="height: 550px" frameborder="0"></iframe>-->
                    </div>
                    <!-- side menu -->
                    <div class="uk-width-1-4@m uk-container uk-grid-padding-remove@m" style="padding: 0;">
                        <div class="tm-filters uk-background-default" id="filters">
                            <div class="uk-padding-remove uk-preserve-color">
                                <!-- Sidebar menu-->
                                <ul class="uk-child-width-expand uk-tab tm-side-course-nav uk-margin-remove uk-position-z-index" uk-switcher="animation: uk-animation-slide-right-small">
                                    <li class="uk-active">
                                        <a href="#" uk-tooltip="title: Course Videos ; delay: 100 ; pos: bottom-center;"> <i class="fas fa-video icon-medium uk-margin-small-right"></i>@lang('front/auth.lessons')</a>
                                    </li>
                                    <li>
                                        <a href="#" uk-tooltip="title: Course Exercise ; delay: 100 ; pos: bottom-center;"> <i class="fas fa-file-archive icon-medium uk-margin-small-right"></i>@lang('front/auth.sources')</a>
                                    </li>
                                </ul>
                                <!-- Sidebar contents -->
                                <ul class="uk-switcher uk-height-max-large uk-overflow-auto">
                                    <!-- Course Video tab  -->
                                    <li>
                                        <div class="demo1 tab-video" data-simplebar>
                                            <ul uk-accordion>
                                                <!-- section one -->
                                                @foreach($course->sections as $section)
                                                <li class="tm-course-lesson-section uk-background-default">
                                                    <a class="uk-accordion-title  uk-padding-small" href="#"><h6> @lang('front/auth.section') {{$loop->index + 1}}</h6> <h4 class="uk-margin-remove">{{$section->name}}</h4> </a>
                                                    <div class="uk-accordion-content uk-margin-remove-top">
                                                        <div class="tm-course-section-list">
                                                            <ul>
                                                                @foreach($section->lessons as $lesson)
                                                                <a href="#" class="uk-link-reset">
                                                                    <li>
                                                                        <span class="uk-icon-button icon-play"> <i class="fas @if($lesson->is_video) fa-play @else fa-file-alt @endif icon-small"></i> </span>
                                                                        <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-large-right">{{$loop->index + 1}}. {{$lesson->name}}</div>
                                                                        <a class="uk-icon-button uk-link-reset uk-margin-small-right uk-icon uk-button-success uk-position-center-right uk-animation-scale-up" href="#" style="display:none"> <i class="fas fa-check-circle icon-small  uk-text-white"></i> </a>
                                                                        @if($lesson->is_video)<span class="uk-position-center-right time uk-margin-medium-right">  {{$lesson->long}}</span>@endif
                                                                    </li>
                                                                </a>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                    <!-- Exicse  tab  -->
                                    <li>
                                        <div class="demo1 uk-background-muted" data-simplebar>
                                            <div class="tm-course-section-list">
                                                <ul>
                                                    <li>
                                                        <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 500 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Q & A area -->
        <h3 class="uk-heading-line uk-text-center"><span>Soru Cevap</span></h3>
        @for($i = 0; $i < 10; $i++)
        <div class="uk-container uk-margin-top">
            <div class="uk-card uk-padding-small uk-card-default">
                <div class="uk-card-body uk-padding-small uk-flex align-items-center">
                    <div class="uk-width-1-6@m uk-visible@m justify-content-center">
                        <img class="uk-border-circle " src="{{asset(Auth::user()->avatar)}}" style="width: 125px; height:125px;">
                    </div>
                    <div class="uk-grid-stack uk-width-5-6@m">
                        <h4 class="uk-margin-remove">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h4>
                        <hr class="uk-margin-small-bottom uk-margin-small-top">
                        <p class="uk-margin-remove">
                            yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum
                            yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum
                            yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum
                            yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum
                            yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum
                            yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum
                            yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum
                        </p>
                    </div>
                </div>
            </div>
            <div uk-grid>
                <div class="uk-width-1-6"></div>
                <div class="uk-card uk-card-primary uk-padding-small uk-width-5-6">
                    <div class="uk-card-body uk-padding-small uk-flex align-items-center">
                        <div class="uk-width-1-6@m uk-visible@m justify-content-center">
                            <img class="uk-border-circle " src="{{asset(Auth::user()->avatar)}}" style="width: 125px; height:125px;">
                        </div>
                        <div class="uk-grid-stack uk-width-5-6@m">
                            <h4 class="uk-margin-remove">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h4>
                            <hr class="uk-margin-small-bottom uk-margin-small-top">
                            <p class="uk-margin-remove">
                                yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum
                                yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum
                                yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum
                                yorum yorum yorum yorum
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>
@endsection
