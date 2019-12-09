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
</head>
<body>
<div id="app">
    <div uk-height-viewport="offset-top: true; offset-bottom: true" class="uk-flex uk-flex-middle">
        <div class="uk-width-2-3@m uk-width-1-2@s uk-margin-auto  border-radius-6 ">
            <div class="uk-child-width-1-2@m uk-background-grey uk-grid-collapse" uk-grid>
                <div class="uk-text-middle uk-margin-auto-vertical uk-text-center uk-padding-small uk-animation-scale-up">
                    <p> <i class="fas fa-graduation-cap uk-text-white" style="font-size:60px"></i> </p>
                    <h1><a href="{{ route('home') }}" class="uk-text-white uk-margin-small" style="text-decoration: none;">Bipayco</a> </h1>
                    <h5 class="uk-margin-small uk-text-muted uk-text-bold uk-text-nowrap"> Bilgi Paylaştıkça Çoğalır. </h5>
                </div>
                <div>
                    <div class="uk-card-default uk-padding uk-card-small">
                        <form method="POST" action="{{ route('loginPost') }}">
                            <!-- Login tab tab -->
                            <div id="login" class="tabcontent tab-default-open animation: uk-animation-slide-right-medium">
                                <h2 class="uk-text-bold"> {{ __('Login') }} </h2>
                                <p class="uk-text-muted uk-margin-remove-top uk-margin-small-bottom"> Fill blank to log your account</p>
                                <div class="uk-form-label">{{ __('E-Mail Address') }}</div>
                                <div class="uk-inline">
                                    <span class="uk-form-icon"><i class="far fa-User icon-medium"></i></span>
                                    <input id="email" type="email" class="uk-input uk-form-width-large form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="uk-flex-middle" uk-grid>
                                    <div class="uk-width-expand@m uk-margin-small-bottom">
                                        <div class="uk-form-label">{{ __('Password') }}</div>
                                    </div>
                                    <div class="uk-width-auto@m">
                                        <a href="#" class="tablinks uk-text-small " onclick="openTabs(event, 'forget')"> Şifreni mi unuttun? </a>
                                    </div>
                                </div>
                                <div class="uk-inline uk-margin-small-bottom">
                                    <span class="uk-form-icon"><i class="fas fa-key icon-medium"></i></span>
                                    <input class="uk-input uk-form-width-large form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password" type="password" required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div>
                                    <label>
                                        <input class="uk-checkbox" name="remember" type="checkbox">
                                        <span class="checkmark uk-text-small"> Beni Hatırla  </span>
                                    </label>
                                </div>
                                <div class="uk-margin uk-text-small">
                                    Üye değil misin?
                                    <a href="{{ route('registerGet') }}" class="tablinks uk-text-bold"> Create account  </a>
                                </div>
                                <div class="uk-flex-middle" uk-grid>
                                    <div class="uk-width-expand@m">
                                        <input class="uk-button uk-button-success button" type="submit" value="Sign in">
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
</html>
