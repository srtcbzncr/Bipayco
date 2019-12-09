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
                    <form method="POST" action="{{ route('registerGet') }}">
                        @csrf
                        <div class="uk-card-default uk-padding uk-card-small">
                            <div id="register" class="tabcontent animation: uk-animation-slide-left-medium">
                                <h2 class="uk-text-bold"> {{ __('Register') }} </h2>
                                <p class="uk-text-muted uk-margin-remove-top uk-margin-small-bottom"> Create your free account</p>
                                <div class="uk-form-label">{{ __('Name') }}</div>
                                <div class="uk-inline">
                                    <span class="uk-form-icon"><i class="far fa-User icon-medium"></i></span>
                                    <input id="name" class="uk-input uk-form-width-large form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Full name" type="text">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="uk-form-label">{{ __('E-Mail Address') }}</div>
                                <div class="uk-inline">
                                    <span class="uk-form-icon"><i class="far fa-envelope icon-medium"></i></span>
                                    <input id="email" class="uk-input uk-form-width-large form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="name@example.com" type="text">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <form class="uk-child-width-1-2@m uk-grid-small" uk-grid>
                                    <div>
                                        <div class="uk-form-label">{{ __('Password') }}</div>
                                        <input class="uk-input uk-form-width-large form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password" type="Password" id="password-1">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <div class="uk-form-label">{{ __('Confirm Password') }}</div>
                                        <input class="uk-input uk-form-width-large form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Password" type="Password"  id="password-2">
                                    </div>
                                </form>
                                <div>
                                    <label>
                                        <input class="uk-checkbox" type="checkbox" data-show-pw="#password-1 ,#password-2">
                                        <span class="checkmark uk-text-small"> Show passwords </span>
                                    </label>
                                </div>
                                <div class="uk-margin">
                                    <label>
                                        <input class="uk-checkbox" type="checkbox" checked>
                                        <span class="checkmark uk-text-small"> I agree to the </span>
                                        <a href="#modal-overflow" class="uk-text-bold uk-text-small" uk-toggle> Terms and Conditions  </a>
                                    </label>
                                </div>
                                <div class=" uk-flex-middle" uk-grid>
                                    <div class="uk-width-expand@m">
                                        <input class="uk-button uk-button-success button" type="submit" value="{{ __('Register') }}">
                                    </div>
                                    <div class="uk-width-auto@m">
                                        <span class="uk-text-small"> Already registered? <a href="{{ route('loginGet') }}" class="tablinks uk-text-bold" > Sign in </a>  </span>
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
</body>
</html>
