<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.2.6/dist/js/uikit.min.js"></script>
    <script src="{{asset('js/simplebar.js')}}"></script>
    <script src="{{asset('js/dropzone.min.js')}}"></script>
    <script src="{{asset('js/uikit.js')}}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/uikit.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin.css')}}" rel="stylesheet">
    <link href="{{asset('css/dropzone.css')}}" rel="stylesheet">
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
    <link href="{{asset('css/fontawesome.css')}}" rel="stylesheet">
</head>
<body style="overflow: hidden;">
    <div class="tm-course-lesson" id="app1">
        <!-- side nav icon -->
        <i class="fas fa-bars icon-large tm-side-menu-icon" uk-toggle="target: #side-nav; cls: side-nav-active" uk-tooltip="title: Open side Navigation  ; delay: 200 ; pos: bottom-left; offset:20 ;animation:uk-animation-scale-up ;"></i>
        <!-- mobile-sidebar  -->
        <i class="fas fa-video icon-large tm-side-right-mobile-icon uk-hidden@m" uk-toggle="target: #filters"></i>
        <!-- mobile-sidebar  -->
        <i class="fas fa-video icon-large tm-side-right-mobile-icon uk-hidden@m" uk-toggle="target: #filters"></i>
        <div class="side-nav uk-animation-slide-left-medium" id="side-nav">
            <span class="uk-animation-fade tm-mobile-close-icon" uk-toggle="target: #side-nav; cls: side-nav-active"> <i class="fas fa-times icon-large"></i></span>
            <side-bar
                general-education-route="{{route('ge_index')}}"
                home-route="{{route('home')}}"
                logo="{{asset('images/logo.png')}}"
                general-education="@lang('front/auth.general_education')"
                all-of-category="@lang('front/auth.all_of_category')"
            ></side-bar>
        </div>
        <div class="uk-grid-collapse" id="course-fliud" uk-grid>
            <!-- PreLoader -->
            <div id="spinneroverlay">
                <div class="spinner"></div>
            </div>
            <div class="uk-width-3-4@m uk-margin-auto">
                <header class="tm-course-content-header uk-background-grey">
                    <a href="#" class="back-to-dhashboard uk-margin-large-left" uk-tooltip="title: Back to Course Dashboard  ; delay: 200 ; pos: bottom-left ;animation:uk-animation-scale-up ; offset:20"> Course Dhashboard</a>
                </header>
                <!--Course-side icon make Hidden sidebar -->
                <i class="fas fa-angle-right icon-large uk-float-right tm-side-course-icon  uk-visible@m" uk-toggle="target: #course-fliud; cls: tm-course-fliud" uk-tooltip="title: Hide sidebar  ; delay: 200 ; pos: bottom-right ;animation:uk-animation-scale-up ; offset:20"></i>
                <!--Course-side active icon -->
                <i class="fas fa-angle-left icon-large uk-float-right tm-side-course-active-icon uk-visible@m" uk-toggle="target: #course-fliud; cls: tm-course-fliud" uk-tooltip="title: Open sidebar  ; delay: 200 ; pos: bottom-right ;animation:uk-animation-scale-up ; offset:20"></i>
                <ul class="uk-subnav tm-course-content-nav" uk-switcher="animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium">
                    <li>
                        <a href="#"> Course Videos </a>
                    </li>
                    <li>
                        <a href="#"> Discussions </a>
                    </li>
                </ul>
                @yield('content')
            </div>
            <!-- Sidebar-->
            <div class="uk-width-1-4@m uk-offcanvas tm-filters uk-background-default tm-side-course uk-animation-slide-right-medium" id="filters" uk-offcanvas="overlay: true; container: false; flip: true">
                <div class="uk-offcanvas-bar uk-padding-remove uk-preserve-color">
                    <!-- Sidebar menu-->
                    <ul class="uk-child-width-expand uk-tab tm-side-course-nav uk-margin-remove uk-position-z-index" uk-switcher="animation: uk-animation-slide-right-medium, uk-animation-slide-left-small" style="    box-shadow: 3px 0px 7px 1px gainsboro;" uk-switcher>
                        <li class="uk-active">
                            <a href="#" uk-tooltip="title: Course Videos ; delay: 200 ; pos: bottom-left ;animation:uk-animation-scale-up"> <i class="fas fa-video icon-medium"></i>  Videos </a>
                        </li>
                        <li>
                            <a href="#" uk-tooltip="title: Course Files ; delay: 200 ; pos: bottom-center ;animation:uk-animation-scale-up"> <i class="fas fa-folder icon-medium"></i>  Files </a>
                        </li>
                        <li>
                            <a href="#" uk-tooltip="title: Course Exercise ; delay: 200 ; pos: bottom-right ;animation:uk-animation-scale-up"> <i class="fas fa-file-archive icon-medium"></i> Exercise</a>
                        </li>
                    </ul>
                    <!-- Sidebar contents -->
                    <ul class="uk-switcher">
                        <!-- Course Video tab  -->
                        <li>
                            <div class="demo1 tab-video" data-simplebar>
                                <ul uk-accordion>
                                    <!-- section one -->
                                    <li class="uk-open tm-course-lesson-section uk-background-default">
                                        <a class="uk-accordion-title  uk-padding-small" href="#"><h6> section  one</h6> <h4 class="uk-margin-remove"> Introduction to basic HTML</h4> </a>
                                        <div class="uk-accordion-content uk-margin-remove-top">
                                            <div class="tm-course-section-list">
                                                <ul>
                                                    <a href="#" class="uk-link-reset tablinks" onclick="openTabs(event,'one')" id="defaultOpen" uk-toggle="target: #course-1-1; cls: watched">
                                                        <li id="course-1-1" class="watched">
                                                            <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                            <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-large-right">Lesson 1 Introduction to html ...</div>
                                                            <a class="uk-icon-button uk-link-reset uk-margin-small-right uk-icon uk-button-success uk-position-center-right uk-animation-scale-up" href="#" style="display:none"> <i class="fas fa-check-circle icon-small  uk-text-white"></i> </a>
                                                            <span class="uk-position-center-right time uk-margin-medium-right">  2 min</span>
                                                        </li>
                                                    </a>
                                                    <a href="#" class="uk-link-reset tablinks" onclick="openTabs(event,'two')" uk-toggle="target: #course-1-2; cls: watched">
                                                        <li id="course-1-2">
                                                            <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                            <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-large-right">Lesson 2 Creating first page ...</div>
                                                            <a class="uk-icon-button uk-link-reset uk-margin-small-right uk-icon uk-button-success uk-position-center-right uk-animation-slide-right-small" href="#" style="display:none"> <i class="fas fa-check-circle icon-small  uk-text-white"></i> </a>
                                                            <span class="uk-position-center-right time uk-margin-medium-right">  2 min</span>
                                                        </li>
                                                    </a>
                                                    <a href="#" class="uk-link-reset tablinks" onclick="openTabs(event,'three')" uk-toggle="target: #course-1-3; cls: watched">
                                                        <li id="course-1-3">
                                                            <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                            <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-large-right">Lesson 3 adding some pargraph ...</div>
                                                            <a class="uk-icon-button uk-link-reset uk-margin-small-right uk-icon uk-button-success uk-position-center-right uk-animation-slide-right-small" href="#" style="display:none"> <i class="fas fa-check-circle icon-small  uk-text-white"></i> </a>
                                                            <span class="uk-position-center-right time uk-margin-medium-right">  2 min</span>
                                                        </li>
                                                    </a>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- section two  -->
                                    <li class="tm-course-lesson-section uk-margin-remove-top uk-background-default">
                                        <a class="uk-accordion-title  uk-padding-small" href="#"><h6> section  two </h6> <h4 class="uk-margin-remove"> HTML5 Continud</h4> </a>
                                        <div class="uk-accordion-content uk-margin-remove-top">
                                            <div class="tm-course-section-list">
                                                <ul>
                                                    <a href="#" class="uk-link-reset tablinks" onclick="openTabs(event,'Four')" uk-toggle="target: #course-2-1; cls: watched">
                                                        <li id="course-2-1">
                                                            <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                            <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Lesson 1 Tags and Elements...</div>
                                                            <span class="uk-position-center-right time  uk-margin-right">  2 min</span>
                                                        </li>
                                                    </a>
                                                    <a href="#" class="uk-link-reset tablinks" onclick="openTabs(event,'Five')" uk-toggle="target: #course-2-2; cls: watched">
                                                        <li id="course-2-2">
                                                            <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                            <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Lesson 2 Form Elements ...</div>
                                                            <span class="uk-position-center-right time  uk-margin-right">  2 min</span>
                                                        </li>
                                                    </a>
                                                    <a href="#" class="uk-link-reset tablinks" onclick="openTabs(event,'Six')" uk-toggle="target: #course-2-3; cls: watched">
                                                        <li id="course-2-3">
                                                            <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                            <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Lesson 3 Table ...</div>
                                                            <span class="uk-position-center-right time  uk-margin-right">  2 min</span>
                                                        </li>
                                                    </a>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- section three  this section is simple with out advance link  -->
                                    <li class="tm-course-lesson-section uk-margin-remove-top uk-background-default">
                                        <a class="uk-accordion-title  uk-padding-small" href="#"><h6> section  three</h6> <h4 class="uk-margin-remove"> HTML5  features </h4> </a>
                                        <div class="uk-accordion-content uk-margin-remove-top">
                                            <div class="tm-course-section-list">
                                                <ul>
                                                    <a href="#" class="uk-link-reset tablinks" onclick="openTabs(event,'video-1')">
                                                        <li>
                                                            <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                            <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Lesson 1 ...</div>
                                                            <span class="uk-position-center-right time  uk-margin-right">  2 min</span>
                                                        </li>
                                                    </a>
                                                    <a href="#" class="uk-link-reset tablinks" onclick="openTabs(event,'video-2')">
                                                        <li>
                                                            <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                            <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Lesson 1 ...</div>
                                                            <span class="uk-position-center-right time  uk-margin-right">  2 min</span>
                                                        </li>
                                                    </a>
                                                    <a href="#" class="uk-link-reset tablinks" onclick="openTabs(event,'video-3')">
                                                        <li>
                                                            <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                            <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Lorem ipsum dolor sit amet, consectetur ...</div>
                                                            <span class="uk-position-center-right time  uk-margin-right">  2 min</span>
                                                        </li>
                                                    </a>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- section Four  this section is simple   -->
                                    <li class="tm-course-lesson-section uk-margin-remove-top uk-background-default">
                                        <a class="uk-accordion-title  uk-padding-small" href="#"><h6> section  four</h6> <h4 class="uk-margin-remove"> Introduction Course</h4> </a>
                                        <div class="uk-accordion-content uk-margin-remove-top">
                                            <div class="tm-course-section-list">
                                                <ul>
                                                    <a href="#" class="uk-link-reset tablinks" onclick="openTabs(event,'video-1')">
                                                        <li>
                                                            <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                            <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Lorem ipsum dolor sit amet, consectetur ...</div>
                                                            <span class="uk-position-center-right time  uk-margin-right">  2 min</span>
                                                        </li>
                                                    </a>
                                                    <a href="#" class="uk-link-reset tablinks" onclick="openTabs(event,'video-2')">
                                                        <li>
                                                            <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                            <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Lorem ipsum dolor sit amet, consectetur ...</div>
                                                            <span class="uk-position-center-right time  uk-margin-right">  2 min</span>
                                                        </li>
                                                    </a>
                                                    <a href="#" class="uk-link-reset tablinks" onclick="openTabs(event,'video-3')">
                                                        <li>
                                                            <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                            <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Lorem ipsum dolor sit amet, consectetur ...</div>
                                                            <span class="uk-position-center-right time  uk-margin-right">  2 min</span>
                                                        </li>
                                                    </a>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- section five  this section is simple   -->
                                    <li class="tm-course-lesson-section uk-margin-remove-top uk-background-default">
                                        <a class="uk-accordion-title  uk-padding-small" href="#"><h6> section  five</h6> <h4 class="uk-margin-remove"> Introduction Course</h4> </a>
                                        <div class="uk-accordion-content uk-margin-remove-top">
                                            <div class="tm-course-section-list">
                                                <ul>
                                                    <a href="#" class="uk-link-reset tablinks" onclick="openTabs(event,'video-1')">
                                                        <li>
                                                            <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                            <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Lorem ipsum dolor sit amet, consectetur ...</div>
                                                            <span class="uk-position-center-right time  uk-margin-right">  2 min</span>
                                                        </li>
                                                    </a>
                                                    <a href="#" class="uk-link-reset tablinks" onclick="openTabs(event,'video-2')">
                                                        <li>
                                                            <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                            <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Lorem ipsum dolor sit amet, consectetur ...</div>
                                                            <span class="uk-position-center-right time  uk-margin-right">  2 min</span>
                                                        </li>
                                                    </a>
                                                    <a href="#" class="uk-link-reset tablinks" onclick="openTabs(event,'video-3')">
                                                        <li>
                                                            <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                            <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Lorem ipsum dolor sit amet, consectetur ...</div>
                                                            <span class="uk-position-center-right time  uk-margin-right">  2 min</span>
                                                        </li>
                                                    </a>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!--  Course resource  tab  -->
                        <li>
                            <div class="demo1 uk-background-default" data-simplebar>
                                <img src="#" width="200" class="uk-margin-remove-bottom uk-align-center uk-width-2-3" alt="">
                                <p class="uk-padding-small uk-margin-remove uk-text-center uk-padding-remove-top">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod dolore .</p>
                                <h4 class="uk-heading-line uk-text-center uk-margin-top"><span>Requirements </span></h4>
                                <p class="uk-padding-small uk-margin-remove  uk-padding-remove-top uk-text-center">Etiam sit amet augue non velit aliquet consectetur molestie eros mauris  .</p>
                                <h5 class="uk-padding-small uk-margin-remove uk-background-muted uk-text-black">  Web browser</h5>
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-4  uk-margin-small-top">
                                        <img src="#" alt="Image" class="uk-align-center img-small">
                                    </div>
                                    <div class="uk-width-3-4 uk-padding-remove-left">
                                        <p class="uk-margin-remove-bottom uk-text-bold  uk-text-small uk-margin-small-top">Firefox  </p>
                                        <p class="uk-margin-remove-top uk-margin-small-bottom">Lorem ipsum dolor adipiscing elit, sed do eiusmod tempor ...</p>
                                        <a class="Course-tags uk-margin-small-right border-radius-6" href="#"> Official site </a>
                                        <a class="Course-tags uk-margin-small-right  border-radius-6 tags-active" href="#"> Download </a>
                                    </div>
                                </div>
                                <hr class="uk-margin-remove-bottom">
                                <div class="uk-grid-small uk-margin-small-top" uk-grid>
                                    <div class="uk-width-1-4  uk-margin-small-top">
                                        <img src="#" alt="Image" class="uk-align-center img-small">
                                    </div>
                                    <div class="uk-width-3-4 uk-padding-remove-left">
                                        <p class="uk-margin-remove-bottom uk-text-bold  uk-text-small uk-margin-small-top">Google Chrome  </p>
                                        <p class="uk-margin-remove-top uk-margin-small-bottom">Lorem ipsum dolor adipiscing elit, sed do eiusmod tempor ...</p>
                                        <a class="Course-tags uk-margin-small-right border-radius-6" href="#"> Official site </a>
                                        <a class="Course-tags uk-margin-small-right  border-radius-6 tags-active" href="#"> Download </a>
                                    </div>
                                </div>
                                <hr class="uk-margin-remove-bottom">
                                <div class="uk-grid-small uk-margin-small-top" uk-grid>
                                    <div class="uk-width-1-4  uk-margin-small-top">
                                        <img src="#" alt="Image" class="uk-align-center img-small">
                                    </div>
                                    <div class="uk-width-3-4 uk-padding-remove-left">
                                        <p class="uk-margin-remove-bottom uk-text-bold  uk-text-small uk-margin-small-top">UCBrwoser    </p>
                                        <p class="uk-margin-remove-top uk-margin-small-bottom">Lorem ipsum dolor adipiscing elit, sed do eiusmod tempor ...</p>
                                        <a class="Course-tags uk-margin-small-right border-radius-6" href="#"> Official site </a>
                                        <a class="Course-tags uk-margin-small-right  border-radius-6 tags-active" href="#"> Download </a>
                                    </div>
                                </div>
                                <h5 class="uk-padding-small uk-margin-remove-bottom uk-background-muted uk-text-black"> Text Editor </h5>
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-4  uk-margin-small-top">
                                        <img src="#" alt="Image" class="uk-align-center img-small">
                                    </div>
                                    <div class="uk-width-3-4 uk-padding-remove-left">
                                        <p class="uk-margin-remove-bottom uk-text-bold  uk-text-small uk-margin-small-top">Atom  </p>
                                        <p class="uk-margin-remove-top uk-margin-small-bottom">Lorem ipsum dolor adipiscing elit, sed do eiusmod tempor ...</p>
                                        <a class="Course-tags uk-margin-small-right border-radius-6" href="#"> Official site </a>
                                        <a class="Course-tags uk-margin-small-right  border-radius-6 tags-active" href="#"> Download </a>
                                    </div>
                                </div>
                                <hr class="uk-margin-remove-bottom">
                                <div class="uk-grid-small uk-margin-small-top" uk-grid>
                                    <div class="uk-width-1-4  uk-margin-small-top">
                                        <img src="#" alt="Image" class="uk-align-center img-small">
                                    </div>
                                    <div class="uk-width-3-4 uk-padding-remove-left">
                                        <p class="uk-margin-remove-bottom uk-text-bold  uk-text-small uk-margin-small-top">Dreamweaver </p>
                                        <p class="uk-margin-remove-top uk-margin-small-bottom">Lorem ipsum dolor adipiscing elit, sed do eiusmod tempor ...</p>
                                        <a class="Course-tags uk-margin-small-right border-radius-6" href="#"> Official site </a>
                                        <a class="Course-tags uk-margin-small-right  border-radius-6 tags-active" href="#"> Download </a>
                                    </div>
                                </div>
                                <hr class="uk-margin-remove-bottom">
                                <div class="uk-grid-small uk-margin-small-top" uk-grid>
                                    <div class="uk-width-1-4  uk-margin-small-top">
                                        <img src="#" alt="Image" class="uk-align-center img-small">
                                    </div>
                                    <div class="uk-width-3-4 uk-padding-remove-left">
                                        <p class="uk-margin-remove-bottom uk-text-bold  uk-text-small uk-margin-small-top">Sublime   </p>
                                        <p class="uk-margin-remove-top uk-margin-small-bottom">Lorem ipsum dolor adipiscing elit, sed do eiusmod tempor ...</p>
                                        <a class="Course-tags uk-margin-small-right border-radius-6" href="#"> Official site </a>
                                        <a class="Course-tags uk-margin-small-right  border-radius-6 tags-active" href="#"> Download </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- Exicse  tab  -->
                        <li>
                            <div class="demo1 uk-background-muted" data-simplebar>
                                <ul class="uk-padding-small" uk-accordion>
                                    <li class="tm-course-lesson-section  uk-background-default uk-open">
                                        <a class="uk-accordion-title   uk-padding-small" href="#"> <h6> section  one </h6> <h4 class="uk-margin-remove"> Introduction Course</h4></a>
                                        <div class="uk-accordion-content uk-margin-remove-top">
                                            <!-- Exerice files-->
                                            <ul class="uk-active uk-background-default" uk-accordion>
                                                <li class="uk-open tm-course-lesson-section">
                                                    <a class="uk-accordion-title  uk-padding-small uk-background-muted uk-padding-remove-bottom" href="#"> <h6> <i class="fas fa-folder"></i>   Lesson  one</h6> </a>
                                                    <div class="uk-accordion-content uk-margin-remove-top">
                                                        <div class="tm-course-section-list">
                                                            <ul>
                                                                <li>
                                                                    <i class="fas fa-file-alt   uk-margin-small-right icon-medium"></i>
                                                                    File one
                                                                    <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 500 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                                </li>
                                                                <li>
                                                                    <i class="fas fa-file-alt   uk-margin-small-right icon-medium"></i>
                                                                    File two
                                                                    <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 500 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                                </li>
                                                                <li>
                                                                    <i class="fas fa-file-alt   uk-margin-small-right icon-medium"></i>
                                                                    File three
                                                                    <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 500 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="tm-course-lesson-section uk-margin-remove-top">
                                                    <a class="uk-accordion-title  uk-padding-small uk-background-muted uk-padding-remove-bottom" href="#"> <h6> <i class="fas fa-folder"></i>  lesson  one</h6> </a>
                                                    <div class="uk-accordion-content uk-margin-remove-top">
                                                        <div class="tm-course-section-list">
                                                            <ul>
                                                                <li>
                                                                    <i class="fas fa-file-alt   uk-margin-small-right icon-medium"></i>
                                                                    File one
                                                                    <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 500 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                                </li>
                                                                <li>
                                                                    <i class="fas fa-file-alt   uk-margin-small-right icon-medium"></i>
                                                                    File two
                                                                    <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 500 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="tm-course-lesson-section  uk-background-default">
                                        <a class="uk-accordion-title   uk-padding-small" href="#"> <h6> section  Two </h6> <h4 class="uk-margin-remove"> Introduction Course</h4></a>
                                        <div class="uk-accordion-content uk-margin-remove-top">
                                            <!-- Exerice files-->
                                            <ul class="uk-active uk-background-default" uk-accordion>
                                                <li class="uk-open tm-course-lesson-section">
                                                    <a class="uk-accordion-title  uk-padding-small uk-background-muted uk-padding-remove-bottom" href="#"> <h6> <i class="fas fa-folder"></i>   Lesspm  one</h6> </a>
                                                    <div class="uk-accordion-content uk-margin-remove-top">
                                                        <div class="tm-course-section-list">
                                                            <ul>
                                                                <li>
                                                                    <i class="fas fa-file-alt   uk-margin-small-right icon-medium"></i>
                                                                    File one
                                                                    <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 500 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                                </li>
                                                                <li>
                                                                    <i class="fas fa-file-alt   uk-margin-small-right icon-medium"></i>
                                                                    File two
                                                                    <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 500 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                                </li>
                                                                <li>
                                                                    <i class="fas fa-file-alt   uk-margin-small-right icon-medium"></i>
                                                                    File three
                                                                    <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 500 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="tm-course-lesson-section uk-margin-remove-top">
                                                    <a class="uk-accordion-title  uk-padding-small uk-background-muted uk-padding-remove-bottom" href="#"> <h6> <i class="fas fa-folder"></i>  Lesson  two</h6> </a>
                                                    <div class="uk-accordion-content uk-margin-remove-top">
                                                        <div class="tm-course-section-list">
                                                            <ul>
                                                                <li>
                                                                    <i class="fas fa-file-alt   uk-margin-small-right icon-medium"></i>
                                                                    File one
                                                                    <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 200 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                                </li>
                                                                <li>
                                                                    <i class="fas fa-file-alt   uk-margin-small-right icon-medium"></i>
                                                                    File two
                                                                    <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 200 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--InfoBox starts her-->
    <div id="infoBox" class="info-box uk-background-default uk-position-bottom-right uk-position-fixed uk-animation-slide-right-medium">
        <header class="uk-background-grey">
            <h6 class="uk-margin-small-top uk-margin-small-bottom uk-text-white uk-animation-fade">  Information Center </h6>
            <div class="uk-button-group uk-position-top-right">
                <button class="uk-visible@m" uk-toggle="target: #infoBox; cls: info-box-small" uk-tooltip="title: Minimze; pos: top-right">
                    <i class="far fa-window-maximize icon-medium"></i>
                </button>
                <button class="uk-visible@m" uk-toggle="target: #infoBox; cls: info-box-big" uk-tooltip="title: Resize ; pos: top-right">
                    <i class="fas fa-expand icon-medium"></i>
                </button>
                <button uk-toggle="target: #infoBox; cls: infoBox-active" uk-tooltip="title: Close ; pos: top-right">
                    <i class="far fa-window-close icon-medium"></i>
                </button>
            </div>
        </header>
        <div class="info-content">
            <!-- Home tab -->
            <div id="Home-tab" class="infotabcontent tab-default-open">
                <!-- view more -->
                <div class="uk-position-bottom-center Veiw-more uk-animation-slide-bottom-medium uk-visible@m uk-background-muted" uk-toggle="target: #infoBox; cls: info-box-big">
                    <span> Veiw More  </span>
                </div>
                <div class="uk-padding-small uk-background-grey info-box-hero">
                    <h3 class="uk-text-white uk-animation-slide-bottom-medium  uk-margin-small-left"> <i class="fas fa-exclamation icon-large"></i> Knowledge Base </h3>
                    <h6 class="  uk-text-white uk-margin-small  uk-margin-small-left"> <a class="Course-tags uk-text-white" style="background: #ffffff33; border: 0" href="#"> View more </a> </h6>
                </div>
                <div class="uk-padding-small  uk-padding-remove-top uk-clearfix" uk-scrollspy="target: > div; cls:uk-animation-slide-bottom-small; delay: 100">
                    <div class="uk-card-small uk-text-center boxes uk-card-hover uk-padding-small uk-inline-clip border-radius-6 scale-up" onclick="InfoTabs(event, 'tabOne')">
                        <i class="fas fa-user-shield info-big-icon"></i>
                        <p class="uk-margin-small-top uk-margin-remove-bottom   uk-text-small uk-text-center"> Privacy </p>
                    </div>
                    <div class="uk-card-small boxes uk-card-hover uk-padding-small uk-inline-clip border-radius-6 scale-up" onclick="InfoTabs(event, 'tabTwo')">
                        <i class="fas fa-user-plus info-big-icon"></i>
                        <p class="uk-margin-small-top uk-margin-remove-bottom   uk-text-small uk-text-center"> Membership</p>
                    </div>
                    <div class="uk-card-small uk-text-center boxes uk-card-hover uk-padding-small uk-inline-clip border-radius-6 scale-up" onclick="InfoTabs(event, 'tabOne')">
                        <i class="fas fa-question	 info-big-icon"></i>
                        <p class="uk-margin-small-top uk-margin-remove-bottom   uk-text-small uk-text-center"> Help</p>
                    </div>
                    <div class="uk-card-small uk-text-center boxes uk-card-hover uk-padding-small uk-inline-clip border-radius-6 scale-up" onclick="InfoTabs(event, 'tabTwo')">
                        <i class="fas fa-comment-dots info-big-icon"></i>
                        <p class="uk-margin-small-top uk-margin-remove-bottom   uk-text-small uk-text-center"> Terms</p>
                    </div>
                    <div class="uk-card-small uk-text-center boxes uk-card-hover uk-padding-small uk-inline-clip border-radius-6 scale-up" onclick="InfoTabs(event, 'tabOne')">
                        <i class="fas fa-wallet info-big-icon"></i>
                        <p class="uk-margin-small-top uk-margin-remove-bottom   uk-text-small uk-text-center"> Peyments</p>
                    </div>
                    <div class="uk-card-small uk-text-center boxes uk-card-hover uk-padding-small uk-inline-clip border-radius-6 scale-up" onclick="InfoTabs(event, 'tabTwo')">
                        <i class="fas fa-shield-alt info-big-icon"></i>
                        <p class="uk-margin-small-top uk-margin-remove-bottom   uk-text-small uk-text-center">  Secure</p>
                    </div>
                    <div class="uk-card-small uk-text-center boxes uk-card-hover uk-padding-small uk-inline-clip border-radius-6 scale-up" onclick="InfoTabs(event, 'tabOne')">
                        <i class="fas fa-user-shield info-big-icon"></i>
                        <p class="uk-margin-small-top uk-margin-remove-bottom   uk-text-small uk-text-center">  Privacy</p>
                    </div>
                    <div class="uk-card-small uk-text-center boxes uk-card-hover uk-padding-small uk-inline-clip border-radius-6 scale-up" onclick="InfoTabs(event, 'tabTwo')">
                        <i class="fas fa-user info-big-icon"></i>
                        <p class="uk-margin-small-top uk-margin-remove-bottom   uk-text-small uk-text-center"> Account</p>
                    </div>
                </div>
                <div uk-grid>
                    <div class="uk-width-1-2@m">
                        <ul class="uk-list uk-list-striped uk-text-center">
                            <li>
                                <a href="#" class="uk-link-reset"> How do I sign up?</a>
                            </li>
                            <li>
                                <a href="#" class="uk-link-reset">Can I remove a post? </a>
                            </li>
                            <li>
                                <a href="#" class="uk-link-reset"> How do reviews work?</a>
                            </li>
                        </ul>
                    </div>
                    <div class="uk-width-1-2@m  uk-padding-remove-left uk-text-center">
                        <ul class="uk-list uk-list-striped">
                            <li>
                                <a href="#" class="uk-link-reset"> How i can be instructure </a>
                            </li>
                            <li>
                                <a href="#" class="uk-link-reset">Can I remove a post? </a>
                            </li>
                            <li>
                                <a href="#" class="uk-link-reset"> How do reviews work?</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <a href="#" class="uk-align-center uk-text-center uk-margin-small-top"> Visit Our Faq page  </a>
            </div>
            <!-- tab One -->
            <div id="tabOne" class="infotabcontent">
                <div class="uk-background-grey tab-subheader">
                    <a href="#" class="uk-link-reset  uk-animation-slide-right" onclick="InfoTabs(event, 'Home-tab')"><i class="far fa-angle-left icon-medium"></i> </a>
                    PRIVACY
                </div>
                <div class="demo1 tab-content   uk-animation-slide-right-small  uk-margin-small-top" data-simplebar>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <h4 class="uk-margin-small"> Can I specify my own private key? </h4>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <h4> My files are missing! How do I get them back? </h4>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <h4> How can I access my account data? </h4>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <a href="#" style="margin-bottom: 130px;" class="uk-align-center uk-text-center uk-h5 uk-link-heading"> Visit Our PRIVACY page </a>
                </div>
            </div>
            <!-- tab Two  -->
            <div id="tabTwo" class="infotabcontent">
                <div class="uk-background-grey tab-subheader">
                    <a href="#" class="uk-link-reset  uk-animation-slide-right" onclick="InfoTabs(event, 'Home-tab')"><i class="far fa-angle-left icon-medium"></i> </a>
                    PAYMENTS
                </div>
                <div class="demo1 tab-content uk-animation-slide-right-small  uk-margin-small-top" data-simplebar>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <h4> Can I have an invoice for my subscription?</h4>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <h4> Why did my credit card or PayPal payment fail? </h4>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <h4> Why does my bank statement show multiple charges for one upgrade? </h4>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <a href="#" style="margin-bottom: 130px;" class="uk-align-center uk-text-center uk-h5 uk-link-heading"> Visit Our Peyment page </a>
                </div>
            </div>
        </div>
    </div>
    <!-- app end -->
    <!--  Night mood -->
    <script>
        (function (window, document, undefined) {
            'use strict';
            if (!('localStorage' in window)) return;
            var nightMode = localStorage.getItem('gmtNightMode');
            if (nightMode) {
                document.documentElement.className += ' night-mode';
            }
        })(window, document);


        (function (window, document, undefined) {

            'use strict';

            // Feature test
            if (!('localStorage' in window)) return;

            // Get our newly insert toggle
            var nightMode = document.querySelector('#night-mode');
            if (!nightMode) return;

            // When clicked, toggle night mode on or off
            nightMode.addEventListener('click', function (event) {
                event.preventDefault();
                document.documentElement.classList.toggle('night-mode');
                if ( document.documentElement.classList.contains('night-mode') ) {
                    localStorage.setItem('gmtNightMode', true);
                    return;
                }
                localStorage.removeItem('gmtNightMode');
            }, false);

        })(window, document);

        // Preloader
        var spinneroverlay = document.getElementById("spinneroverlay");
        window.addEventListener('load', function(){
            spinneroverlay.style.display = 'none';
        });


    </script>
</body>
</html>
