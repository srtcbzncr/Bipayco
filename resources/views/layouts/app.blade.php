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
            general-education="@lang('front/auth.general_education')"
            all-of-category="@lang('front/auth.all_of_category')"
        ></side-bar>
    </div>
    <div id="spinneroverlay">
        <div class="spinner"></div>
    </div>
    <div class="app">
        <main>
            <top-bar
                home-route="{{route('home')}}"
                logout-route="{{route('logout')}}"
                settings-route="{{route('settings')}}"
                register-route="{{route('registerGet')}}"
                login-route="{{route('loginGet')}}"
                register-name="@lang('front/auth.register')"
                login-name="@lang('front/auth.login')"
                @if(Auth::check())
                    has-login
                    user-id="{{Auth::user()->id}}"
                    profile-route="{{route('student_profile', Auth::user()->id)}}"
                    profile-image='{{asset(Auth::user()->avatar)}}'
                    user-name="{{Auth::user()->first_name}} {{Auth::user()->last_name}}"
                    user-city="{{Auth::user()->district->name}}, {{Auth::user()->district->city->name}}"
                @endif
                settings="@lang('front/auth.settings')"
                log-out="@lang('front/auth.log_out')"
                profile="@lang('front/auth.profile')"
            ></top-bar>
            @yield('content')
            <app-footer></app-footer>
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
