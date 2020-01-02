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
<body>
    <div id="app1">
        <side-bar
            home-route="{{route('home')}}"
            general-education="@lang('front/auth.general_education')"
            all-of-category="@lang('front/auth.all_of_category')"
        ></side-bar>
        <div id="app">
            <div class="uk-grid-collapse" id="course-fliud" uk-grid>
                <div class="uk-width-3-4@m uk-margin-auto">
                    <header class="tm-course-content-header uk-background-grey">
                        <a href="Course-resume.html" class="back-to-dhashboard uk-margin-large-left" uk-tooltip="title: Back to Course Dashboard  ; delay: 200 ; pos: bottom-left ;animation:uk-animation-scale-up ; offset:20"> Course Dhashboard</a>
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
                    <ul class="uk-switcher">
                        <!-- Course Videos tab-->
                        <li>
                            <!--   Videos tab 1 -->
                            <div class="tabcontent tab-default-open uk-padding  animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium" id="one">
                                <div class="video-responsive">
                                    <iframe src="https://www.youtube.com/embed/9gTw2EDkaDQ" frameborder="0" uk-video="automute: true" allowfullscreen uk-responsive></iframe>
                                </div>
                            </div>
                            <!--   Videos tab 2  to make outplay add ( uk-video="automute: true" ) -->
                            <div class="tabcontent uk-padding animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium" id="two">
                                <div class="video-responsive">
                                    <iframe src="https://www.youtube.com/embed/YcApt9RgiT0" frameborder="0" allowfullscreen uk-responsive></iframe>
                                </div>
                            </div>
                            <!--   Videos tab 3  -->
                            <div class="tabcontent uk-padding animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium" id="three">
                                <div class="video-responsive">
                                    <iframe src="https://www.youtube.com/embed/CGSdK7FI9MY" frameborder="0" allowfullscreen uk-responsive></iframe>
                                </div>
                            </div>
                            <!--   Videos tab 4 -->
                            <div class="tabcontent uk-padding animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium" id="Four">
                                <div class="video-responsive">
                                    <iframe src="https://www.youtube.com/embed/4I1WgJz_lmA" frameborder="0" allowfullscreen uk-responsive></iframe>
                                </div>
                            </div>
                            <!--   Videos tab 5  -->
                            <div class="tabcontent uk-padding animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium" id="Five">
                                <div class="video-responsive">
                                    <iframe src="https://www.youtube.com/embed/dDn9uw7N9Xg" frameborder="0" allowfullscreen uk-responsive></iframe>
                                </div>
                            </div>
                            <!--   Videos tab 6  -->
                            <div class="tabcontent uk-padding animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium" id="Six">
                                <div class="video-responsive">
                                    <iframe src="https://www.youtube.com/embed/CPcS4HtrUEU" frameborder="0" allowfullscreen uk-responsive></iframe>
                                </div>
                            </div>
                            <!--   you can add another tab by giving  the tab new (id) also you can chenge the animation of the tab ..   -->
                        </li>
                        <!--   Discussions tab -->
                        <li>
                            <div class="demo1 scrollbar-light" style="margin-top:-2px" data-simplebar>
                                <div class="uk-section uk-background-grey tm-discussions-header uk-section-small">
                                    <div class="uk-container-small uk-margin-auto uk-light uk-text-center">
                                        <h1> Discussions </h1>
                                        <p>Share what you was Learn with other Students .</p>
                                        <div class="uk-inline  uk-width-1-1">
                                            <span class="uk-form-icon"><i class="fas fa-search  uk-margin-small-left"></i></span>
                                            <input class="uk-input  uk-form-large" type="text" placeholder="Search Something ... ">
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-container-small uk-margin-auto uk-light uk-margin-medium-top">
                                    <!-- post one -->
                                    <div class="uk-card uk-card-default uk-card-small">
                                        <div class="uk-card-header">
                                            <img src="../assets/images/avatures/avature-2.png" alt="" class="uk-border-circle uk-align-left uk-margin-remove-bottom uk-margin-small-right img-small">
                                            <h5 class="uk-text-black uk-margin-small-top"> Hastie fley</h5>
                                        </div>
                                    </div>
                                    <!-- post two -->
                                    <div class="uk-card uk-card-default uk-card-small  uk-margin-medium-top">
                                        <div class="uk-card-header">
                                            <img src="../assets/images/avatures/avature-4.png" alt="" class="uk-border-circle uk-align-left uk-margin-remove-bottom uk-margin-small-right img-small">
                                            <h5 class="uk-text-black uk-margin-small-top"> Hastie fley</h5>
                                        </div>
                                        <div class="uk-card-body">
                                            <p class="uk-margin-small-top">Eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                                            <pre><code id="code-jnpr9ply" class="lang-html hljs xml"><span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">uk-margin</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"uk-button uk-button-default"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"#"</span>&gt;</span>Link<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">button</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"uk-button uk-button-default"</span>&gt;</span>Button<span class="hljs-tag">&lt;/<span class="hljs-name">button</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">button</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"uk-button uk-button-default"</span> <span class="hljs-attr">disabled</span>&gt;</span>Disabled<span class="hljs-tag">&lt;/<span class="hljs-name">button</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span></code></pre>
                                        </div>
                                        <div class="uk-card-footer">
                                            <a href="#" class="uk-button uk-button-text">Read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
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
                                    <img src="../assets/images/courses/course-lesson-icon.jpg" width="200" class="uk-margin-remove-bottom uk-align-center uk-width-2-3" alt="">
                                    <p class="uk-padding-small uk-margin-remove uk-text-center uk-padding-remove-top">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod dolore .</p>
                                    <h4 class="uk-heading-line uk-text-center uk-margin-top"><span>Requirements </span></h4>
                                    <p class="uk-padding-small uk-margin-remove  uk-padding-remove-top uk-text-center">Etiam sit amet augue non velit aliquet consectetur molestie eros mauris  .</p>
                                    <h5 class="uk-padding-small uk-margin-remove uk-background-muted uk-text-black">  Web browser</h5>
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-1-4  uk-margin-small-top">
                                            <img src="../assets/images/icons/software-icon.jpg" alt="Image" class="uk-align-center img-small">
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
                                            <img src="../assets/images/icons/software-icon.jpg" alt="Image" class="uk-align-center img-small">
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
                                            <img src="../assets/images/icons/software-icon.jpg" alt="Image" class="uk-align-center img-small">
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
                                            <img src="../assets/images/icons/software-icon.jpg" alt="Image" class="uk-align-center img-small">
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
                                            <img src="../assets/images/icons/software-icon.jpg" alt="Image" class="uk-align-center img-small">
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
                                            <img src="../assets/images/icons/software-icon.jpg" alt="Image" class="uk-align-center img-small">
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
    </div>
</body>
</html>
