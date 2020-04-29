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
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.2.3/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.2.3/dist/js/uikit-icons.min.js"></script>
    <script src="{{asset('js/simplebar.js')}}"></script>
    <script src="{{asset('js/uikit.js')}}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/uikit.css')}}" rel="stylesheet">
    <link href="{{asset('css/fontawesome.css')}}" rel="stylesheet">
</head>
<body>
<div id="app1">
    <div uk-height-viewport="offset-top: true; offset-bottom: true" class="uk-flex uk-flex-middle">
        <div class="uk-width-2-3@m uk-width-1-2@s uk-margin-auto  border-radius-6 ">
            <div class="uk-child-width-1-2@m uk-background-grey uk-grid-collapse" uk-grid>
                <div class="uk-text-middle uk-margin-auto-vertical uk-text-center uk-padding-small uk-animation-scale-up">
                    <a class="" href="{{ route('home') }}"> <img class="uk-logo uk-width-medium" src="{{asset('images/logo1.png')}}"/> </a>
                </div>
                <div>
                    <div class="uk-card-default uk-padding uk-card-small">
                        <form method="POST" action="{{ route('loginPost') }}">
                            @csrf
                            <!-- Login tab tab -->
                            <div id="login" class="tabcontent tab-default-open animation: uk-animation-slide-right-medium">
                                <h2 class="uk-text-bold">@lang('front/auth.login')</h2>
                                <p class="uk-text-muted uk-margin-remove-top uk-margin-small-bottom">@lang('front/auth.login_description')</p>
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <div class="uk-margin-small">
                                    <div class="uk-inline uk-flex align-items-center">
                                        <input id="email" type="email" class="uk-input uk-form-width-large form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="@lang('front/auth.email')" required autocomplete="email" autofocus>
                                    </div>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="uk-margin-small">
                                    <div class="uk-inline uk-flex align-items-center">
                                        <input id="password" class="uk-input uk-form-width-large form-control @error('password') is-invalid @enderror" name="password" required autocomplete="password" placeholder="@lang('front/auth.password')" type="password">
                                        <a class="fas fa-eye" onclick="togglePassword('password')" style="margin-left: -30px;"></a>
                                    </div>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="uk-flex-middle uk-margin-small" uk-grid>
                                    <div class="uk-width-expand@m">
                                        <label>
                                            <input class="uk-checkbox" name="remember" type="checkbox">
                                            <span class="checkmark uk-text-small">@lang('front/auth.remember_me')</span>
                                        </label>
                                    </div>
                                    <div class="uk-width-auto@m">
                                        <a href="#" class="tablinks uk-text-small " onclick="openTabs(event, 'forget')">@lang('front/auth.forget_password')</a>
                                    </div>
                                </div>
                                <div class="uk-margin uk-text-small">
                                    <span>
                                        @lang('front/auth.dont_have_account')
                                        <a href="{{ route('registerGet') }}" class="tablinks uk-text-bold"> @lang('front/auth.create_account') </a>
                                    </span>
                                </div>
                                <div class="uk-flex-middle" uk-grid>
                                    <div class="uk-width-expand@m">
                                        <input class="uk-button uk-button-success button" type="submit" value="@lang('front/auth.sign_in')">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
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
</html>
