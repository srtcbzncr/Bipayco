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
                    <p> <i class="fas fa-graduation-cap uk-text-white" style="font-size:60px"></i> </p>
                    <h1><a href="{{ route('home') }}" class="uk-text-white uk-margin-small" style="text-decoration: none;">Bipayco</a> </h1>
                    <!--<h5 class="uk-margin-small uk-text-muted uk-text-bold uk-text-nowrap">'front/auth.bipayco_description'</h5>-->
                </div>
                <div>
                    <form method="POST" action="{{ route('registerPost') }}">
                        @csrf
                        <div class="uk-card-default uk-padding uk-card-small">
                            <div id="register" class="tabcontent animation: uk-animation-slide-left-medium">
                                <h2 class="uk-text-bold">  @lang('front/auth.register')  </h2>
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <p class="uk-text-muted uk-margin-remove-top uk-margin-small-bottom">@lang('front/auth.register_description')</p>
                                <div class="uk-child-width-1-2@l uk-grid">
                                    <div class="uk-margin-small-bottom">
                                        <input id="first_name" class="uk-input form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus placeholder=" @lang('front/auth.first_name') " type="text">
                                        @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <input id="last_name" class="uk-input form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus placeholder=" @lang('front/auth.last_name') " type="text">
                                        @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="uk-child-width-1-2@l uk-grid uk-margin-small">
                                    <div class="uk-margin-small-bottom">
                                        <input id="email" class="uk-input form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="@lang('front/auth.email')" type="text">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <input id="phone_number" class="uk-input form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="phone_number" autofocus placeholder="@lang('front/auth.phone_number')" type="text">
                                        @error('phone_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="uk-margin-small">
                                    <provinces
                                        city-default="@lang('front/auth.province')"
                                        district-default="@lang('front/auth.district')"
                                    ></provinces>
                                </div>
                                <div class="uk-child-width-1-2@l uk-grid uk-margin-small">
                                    <div class="uk-margin-small-bottom uk-inline uk-flex align-items-center">
                                        <input id="username" class="uk-input form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="@lang('front/auth.username')" type="text">
                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <div class="uk-inline uk-flex align-items-center">
                                            <input id="password" class="uk-input form-control @error('password') is-invalid @enderror" name="password" required autocomplete="password" placeholder="@lang('front/auth.password')" type="password">
                                            <a class="fas fa-eye" onclick="togglePassword('password')" style="margin-left: -30px"></a>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label>
                                        <input class="uk-checkbox" type="checkbox" required>
                                        <span class="checkmark uk-text-small"> I agree to the </span>
                                        <a href="#modal-overflow" class="uk-text-bold uk-text-small" uk-toggle> Terms and Conditions </a>
                                    </label>
                                </div>
                                <div class=" uk-flex-middle" uk-grid>
                                    <div class="uk-width-expand@m">
                                        <input class="uk-button uk-button-success button" type="submit" value="@lang('front/auth.register')">
                                    </div>
                                    <div class="uk-width-auto@m">
                                        <span class="uk-text-small"> @lang('front/auth.registered') <a href="{{ route('loginGet') }}" class="tablinks uk-text-bold" >@lang('front/auth.sign_in')</a>  </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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
