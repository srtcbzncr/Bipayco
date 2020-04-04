<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> Bipayco </title>

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

        <style>
            @media screen and (max-width: 435px) {
                .admin-panel-inner {
                    padding: 0 !important
                }
            }
            .admin-panel-inner{
                padding: 30px ;
                max-width: 1100px;
                margin: auto;
            }
        </style>
    </head>
    <body>
        <!-- sidebar -->
        <div class="admin-side overflow-auto" id="admin-side">
            <div class="uk-flex uk-flex-center uk-margin-small-top">
                <a class="" href="{{route('home')}}">
                    <img class="uk-logo uk-width-small" src="{{asset('images/logo1.png')}}"/>
                </a>
            </div>
            <ul>
                <li>
                    <a href="{{route('adminDashboard')}}"> <i class="fas fa-chalkboard"></i>  @lang('front/auth.dashboard') </a>
                </li>
                <li>
                    <a href="{{route('adminCities')}}"> <i class="fas fa-chalkboard"></i>  @lang('front/auth.cities') </a>
                </li>
                <li>
                    <a href="{{route('adminCategories')}}"> <i class="fas fa-book"></i>@lang('front/auth.categories')</a>
                </li>
                <li>
                    <a href="{{route('adminGrade')}}"> <i class="fas fa-pencil-alt"></i>@lang('front/auth.grade')</a>
                </li>
                <li>
                    <a href="{{route('adminLesson')}}"> <i class="fas fa-book-open"></i>@lang('front/auth.lessons')</a>
                </li>
                <li>
                    <a href="{{route('student_profile', Auth::user()->id)}}"> <i class="fas fa-user"></i>@lang('front/auth.student_mode')</a>
                </li>
                <li>
                    <a href="{{route('settings')}}"> <i class="fas fa-cog"></i>@lang('front/auth.settings')</a>
                </li>
                <li>
                    <a href="{{route('logout')}}"> <i class="fas fa-sign-out-alt"></i>@lang('front/auth.log_out')</a>
                </li>
            </ul>
        </div>
        <!-- mobile  header -->
        <div class="admin-mobile-headder uk-hidden@m">
            <span uk-toggle="target: #admin-side; cls: admin-side-active" class="uk-padding-small uk-text-white uk-float-right"><i class="fas fa-bars"></i></span>
            <a class="" href="{{route('home')}}"> <img class="uk-width-small" src="{{asset('images/logo2.png')}}"/> </a>
        </div>
        <div class="admin-content uk-height-viewport">
            <div id="app1" class="admin-panel-inner">
                @yield('content')
            </div>
        </div>
    </body>
</html>
