<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{asset('/images/Bipayco.ico')}}">
    <title> Bipayco </title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.2.3/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.2.3/dist/js/uikit-icons.min.js"></script>
    <script src="{{asset('js/simplebar.js')}}"></script>
    <script src="{{asset('js/uikit.js')}}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/uikit.css')}}" rel="stylesheet">
    <link href="{{asset('css/fontawesome.css')}}" rel="stylesheet">
</head>
<body>
<div id="app1">
    <div uk-height-viewport="offset-top: true; offset-bottom: true" class="uk-flex uk-flex-middle">
        <div class="uk-width-2-3@m uk-width-1-2@s uk-margin-auto  border-radius-6 ">
            <div class="uk-background-grey uk-grid-collapse" uk-grid>
                <div class="uk-width uk-text-middle uk-margin-auto-vertical uk-text-center uk-padding-small uk-animation-scale-up">
                    <a class="" href="{{ route('home') }}"> <img class="uk-logo uk-width-medium" src="{{asset('images/logo1.png')}}"/> </a>
                </div>
                <div class="uk-width uk-card-default uk-padding uk-card-small">
                    <div class="uk-flex-column uk-flex align-items-center justify-content-center">
                        @if($data)
                            <div style="border-radius: 6px" class="uk-width-1-2@m uk-padding-medium uk-card-default uk-background-success text-white">
                                <p class="uk-margin-remove"><span class="fas fa-check-circle icon-small"></span> @lang('front/auth.payment_successfully')</p>
                            </div>
                        @else
                            <div style="border-radius: 6px" class="uk-width-1-2@m uk-padding-medium uk-background-danger text-white">
                                <p class="uk-margin-remove"><span class="fas fa-minus-circle icon-small"></span> @lang('front/auth.payment_error')</p>
                            </div>
                        @endif
                        <a href="{{route('home')}}"><button class=" uk-margin-top uk-button uk-button-default">@lang('front/auth.return_homepage')</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
