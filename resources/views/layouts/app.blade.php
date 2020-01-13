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
@if(session('result_message'))
    @if(session('error'))
        <script>UIkit.notification({message: '{{session('message')}}', status: 'danger'});</script>
    @else
        <script>UIkit.notification({message: '{{session('message')}}', status: 'success'});</script>
    @endif
@endif
<div id="app1">
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
    <div id="spinneroverlay">
        <div class="spinner"></div>
    </div>
    <div class="app">
        <main>
            <!--  Top bar nav -->
            <nav class=" tm-mobile-header uk-animation-slide-top uk-background-blend-lighten uk-position-z-index" uk-navbar >
                <!-- mobile icon for side nav on nav-mobile-->
                <span class="uk-hidden@m tm-mobile-menu-icon" uk-toggle="target: #side-nav; cls: side-nav-active"><i class="fas fa-bars icon-large"></i></span>
                <!-- mobile icon for user icon on nav-mobile -->
                <span class="uk-hidden@m tm-mobile-user-icon uk-align-right" uk-toggle="target: #tm-show-on-mobile; cls: tm-show-on-mobile-active"><i class="far fa-user icon-large"></i></span>
                <!-- mobile logo -->
                <a class="uk-hidden@m uk-logo" href="{{route('home')}}">Bipayco</a>
                @if(Auth::check())
                @endif
                <div class="uk-navbar-right tm-show-on-mobile uk-flex-right uk-margin-small-bottom" id="tm-show-on-mobile" >
                    <!-- this will clouse after display user icon -->
                    <span class="uk-hidden@m tm-mobile-user-close-icon uk-align-right" uk-toggle="target: #tm-show-on-mobile; cls: tm-show-on-mobile-active"><i class="fas fa-times icon-large"></i></span>
                    <ul class="uk-navbar-nav uk-flex-middle  uk-margin-small-top">
                        <li>
                            <a href="#modal-full" uk-toggle><i style="color: #424242" class="fas fa-search icon-medium"></i></a>
                        </li>
                        @if(Auth::check())
                        <li>
                            <!-- your courses -->
                            <a href="#"> <i style="color: #424242" class="fas fa-play icon-medium" uk-tooltip="title: Kurslarım ; delay: 500 ; pos: bottom ;animation:	uk-animation-scale-up"></i></a>
                            <your-courses
                                user-id="{{Auth::user()->id}}"
                            > </your-courses>
                        </li>
                        <li>
                            <!-- messages -->
                            <a href="#"><i style="color: #424242" class="fas fa-shopping-cart icon-medium" uk-tooltip="title: Sepetim ; delay: 500 ; pos: bottom ;animation:	uk-animation-scale-up"></i></a>
                            <div uk-dropdown="pos: top-right ;mode : click; animation: uk-animation-slide-bottom-small" class="uk-dropdown uk-dropdown-top-right  tm-dropdown-medium border-radius-6 uk-padding-remove uk-box-shadow-large angle-top-right">
                                <h5 class="uk-padding-small uk-margin-remove uk-text-bold  uk-text-left"> Sepetim </h5>
                                <a href="#" class="uk-position-top-right uk-link-reset"> <i class="fas fa-trash uk-align-right   uk-text-small uk-padding-small"> Hepsini Temizle</i> </a>
                                <hr class=" uk-margin-remove">
                                <div class="uk-text-left uk-height-medium">
                                    <div uk-scrollspy="target: > div; cls:uk-animation-slide-bottom-small; delay: 100"  style="overflow-y:auto" data-simplebar>
                                        <messages-small-card> </messages-small-card>
                                        <hr class=" uk-margin-remove">
                                        <messages-small-card> </messages-small-card>
                                        <hr class=" uk-margin-remove">
                                        <messages-small-card> </messages-small-card>
                                        <hr class=" uk-margin-remove">
                                        <messages-small-card> </messages-small-card>
                                        <hr class=" uk-margin-remove">
                                        <messages-small-card> </messages-small-card>
                                        <hr class=" uk-margin-remove">
                                        <messages-small-card> </messages-small-card>
                                        <hr class="uk-margin-remove">
                                    </div>
                                </div>
                                <hr class=" uk-margin-remove">
                                <h5 class="uk-padding-small uk-margin-remove uk-text-bold uk-text-center"><a class="uk-link-heading" href=""> Satın Al </a> </h5>
                            </div>
                        </li>
                        <li>
                            <!-- Notifications -->
                            <a href="#"><i style="color: #424242" class="fas fa-bell icon-medium" uk-tooltip="title: Bildirimler ; delay: 500 ; pos: bottom ;animation:	uk-animation-scale-up"> </i></a>
                            <div uk-dropdown="pos: top-right ;mode : click; animation: uk-animation-slide-bottom-small" class="uk-dropdown uk-dropdown-top-right  tm-dropdown-small border-radius-6 uk-padding-remove uk-box-shadow-large angle-top-right">
                                <h5 class="uk-padding-small uk-margin-remove uk-text-bold  uk-text-left"> Bildirimler </h5>
                                <a href="#" class="uk-position-top-right uk-link-reset"> <i class="fas fa-trash uk-align-right   uk-text-small uk-padding-small"> Hepsini Temizle</i></a>
                                <hr class=" uk-margin-remove">
                                <div class="uk-text-left uk-height-medium">
                                    <div data-simplebar style="overflow-y:auto">
                                        <div class="uk-padding-small"  uk-scrollspy="target: > div; cls:uk-animation-slide-bottom-small; delay: 100">
                                            <notification-card> </notification-card>
                                            <hr class="uk-margin-remove">
                                            <notification-card> </notification-card>
                                            <hr class="uk-margin-remove">
                                            <notification-card> </notification-card>
                                            <hr class="uk-margin-remove">
                                            <notification-card> </notification-card>
                                            <hr class="uk-margin-remove">
                                            <notification-card> </notification-card>
                                            <hr class="uk-margin-remove">
                                            <notification-card> </notification-card>
                                            <hr class="uk-margin-remove">
                                            <notification-card> </notification-card>
                                            <hr class="uk-margin-remove">
                                            <notification-card> </notification-card>
                                            <hr class="uk-margin-remove">
                                            <notification-card> </notification-card>
                                            <hr class="uk-margin-remove">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <!-- User profile -->
                            <a href="#">
                                <img src="{{asset(Auth::user()->avatar)}}" alt="" class="uk-border-circle user-profile-tiny">
                            </a>
                            <user-profile-dropdown-nav
                                settings-route="{{route('settings')}}"
                                logout-route="{{route('logout')}}"
                                settings="@lang('front/auth.settings')"
                                log-out="@lang('front/auth.log_out')"
                                profile="@lang('front/auth.profile')"
                                profile-route="{{route('student_profile', Auth::user()->id)}}"
                                profile-image='{{asset(Auth::user()->avatar)}}'
                                user-name="{{Auth::user()->first_name}} {{Auth::user()->last_name}}"
                                user-city="{{Auth::user()->district->name}}, {{Auth::user()->district->city->name}}"
                            > </user-profile-dropdown-nav>
                        </li>
                        @else
                        <li>
                            <a href="{{route('loginGet')}}" class="uk-padding-remove uk-margin-small-left"><button class="uk-button uk-button-primary uk-padding-small uk-padding-remove-vertical">@lang('front/auth.login')</button></a>
                        </li>
                        <li>
                            <a href="{{route('registerGet')}}" class="uk-padding-remove uk-margin-small-left"><button class="uk-button uk-button-danger uk-padding-small uk-padding-remove-vertical">@lang('front/auth.register')</button></a>
                        </li>
                        @endif
                    </ul>
                </div>
                <div id="modal-full" class="uk-modal-full uk-modal uk-animation-scale-down" uk-modal>
                    <search></search>
                </div>
            </nav>
            @yield('content')
            <div class="uk-section-small uk-margin-medium-top">
                <hr class="uk-margin-remove">
                <div class="uk-container uk-align-center uk-margin-remove-bottom uk-position-relative">
                    <div uk-grid>
                        <div class="uk-width-1-3@m uk-width-1-2@s uk-first-column">
                            <a class="" href="{{route('home')}}"> <img class="uk-logo uk-width-small@s uk-width-medium@m" src="{{asset('images/logo2.png')}}"/> </a>
                            <div class="uk-width-xlarge tm-footer-description">Bilgi paylaştıkça çoğalır.</div>
                        </div>
                        <div class="uk-width-expand@m uk-width-1-2@s">
                            <ul class="uk-list  tm-footer-list">

                            </ul>
                        </div>
                        <div class="uk-width-expand@m uk-width-1-2@s">
                            <ul class="uk-list tm-footer-list">
                                <li>
                                    <a href="{{route('ge_index')}}">Genel Eğitim Modülü </a>
                                </li>
                                <li>
                                    <a href="#">Sınavlara Hazırlık Modülü  </a>
                                </li>
                                <li>
                                    <a href="#"> Derslere Hazırlık Modülü </a>
                                </li>
                            </ul>
                        </div>
                        <div class="uk-width-expand@m uk-width-1-2@s">
                            <ul class="uk-list  tm-footer-list">
                                <li>
                                    <a href="#"> Denemeler </a>
                                </li>
                                <li>
                                    <a href="#"> Ödemeler </a>
                                </li>
                                <li>
                                    <a href="#"> İletişim </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <p class="uk-postion-absoult uk-margin-remove uk-position-bottom-right" style="bottom: 8px;right: 60px;" uk-tooltip="title: Visit Our Site; pos: top-center"><a href="#"  class="uk-text-bold uk-link-reset"> Sanalist </a> tarafından geliştirildi. </p>
                    <div class="uk-margin-small" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-2@s uk-first-column">
                            <p class="uk-text-small"><i class="fas fa-copyright"></i> 2020 <span class="uk-text-bold">Bipayco</span>  Bütün hakları saklıdır.</p>
                        </div>
                        <div class="uk-width-1-3@m uk-width-1-2@s">
                            <a href="#" class="uk-icon-button uk-link-reset" uk-tooltip="title: Our Youtube Chanal; pos: top-center"><i class="fab fa-youtube" style=" color: #fb7575  !important;"></i></a>
                            <a href="#" class="uk-icon-button uk-link-reset" uk-tooltip="title: Our Facebook; pos: top-center"><i class="fab fa-facebook" style=" color: #9160ec  !important;"></i></a>
                            <a href="#" class="uk-icon-button uk-link-reset" uk-tooltip="title: Our Instagram; pos: top-center"><i class="fab fa-instagram" style=" color: #dc2d2d  !important;"></i></a>
                            <a href="#" class="uk-icon-button uk-link-reset" uk-tooltip="title: Our linkedin; pos: top-center"><i class="fab fa-linkedin " style=" color: #6949a5  !important;"></i></a>
                            <a href="#" class="uk-icon-button uk-link-reset" uk-tooltip="title: Our Twitter; pos: top-center"><i class="fab fa-twitter" style=" color: #6f23ff !important;"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
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

    //scrollTop
    // When the user scrolls down 20px from the top of the document, show the button
    /*window.onscroll = function() {scrollFunction()};
    function scrollFunction() {
      if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("scrollTop").style.display = "block";
      } else {
        document.getElementById("scrollTop").style.display = "none";
      }
    }
    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }*/
</script>
<script>
    function togglePassword(name) {
        var passwordInput= document.getElementById(name);
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }
</script>
</body>
</html>
