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
            <div class="uk-child-width-1-2@m uk-background-grey uk-grid-collapse" uk-grid>
                <div class="uk-text-middle uk-margin-auto-vertical uk-text-center uk-padding-small uk-animation-scale-up">
                    <a class="" href="{{ route('home') }}"> <img class="uk-logo uk-width-medium" src="{{asset('images/logo1.png')}}"/> </a>
                </div>
                <div>
                    <form method="POST" action="{{ route('iyzico_check_out') }}">
                        @csrf
                        <input class="uk-hidden" name="user_id" id="user_id" value="{{$data['user_id']}}">
                        <input class="uk-hidden" name="coupon" id="coupon" value="{{$data['coupon']}}">
                        <div class="uk-card-default uk-padding uk-card-small">
                            <div id="register" class="tabcontent animation: uk-animation-slide-left-medium">
                                <h2 class="uk-text-bold">  @lang('front/auth.invoice_informations')  </h2>
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <div class="uk-child-width-1-2@l uk-grid">
                                    <div class="uk-margin-small-bottom">
                                        <div class="uk-form-label uk-margin-remove-top"> @lang('front/auth.first_name')</div>
                                        <input id="first_name" class="uk-input form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus placeholder=" @lang('front/auth.first_name') " type="text">
                                        @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <div class="uk-form-label uk-margin-remove-top"> @lang('front/auth.last_name')</div>
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
                                        <div class="uk-form-label uk-margin-remove-top"> @lang('front/auth.email')</div>
                                        <input id="email" class="uk-input form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="@lang('front/auth.email')" type="text">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <div class="uk-form-label uk-margin-remove-top"> @lang('front/auth.phone_number')</div>
                                        <input id="phone_number" class="uk-input form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="phone_number" autofocus placeholder="@lang('front/auth.phone_number')" type="text">
                                        @error('phone_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="uk-child-width-1-2@l uk-grid uk-margin-small">
                                    <div class="uk-margin-small-bottom">
                                        <div class="uk-form-label uk-margin-remove-top"> @lang('front/auth.identity_number')</div>
                                        <input id="identity_number" class="uk-input form-control @error('identity_number') is-invalid @enderror" name="identity_number" value="{{ old('identity_number') }}" required autocomplete="identity_number" placeholder="@lang('front/auth.identity_number')" type="text">
                                        @error('identity_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <div class="uk-form-label uk-margin-remove-top"> @lang('front/auth.country')</div>
                                        <input id="country" class="uk-input form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country') }}" required autocomplete="country" autofocus placeholder="@lang('front/auth.country')" type="text">
                                        @error('country')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="uk-margin-small">
                                    <div class="uk-form-label uk-margin-remove-top"> @lang('front/auth.address')</div>
                                    <textarea style="resize:none; height: 150px" class="uk-textarea uk-width uk-overflow form-control @error('address') is-invalid @enderror" name="address" id="address" autocomplete="address" placeholder="@lang('front/auth.address')" required>{{ old('address') }}</textarea>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="uk-child-width-1-2@l uk-grid uk-margin-small">
                                    <div class="uk-margin-small-bottom">
                                        <div class="uk-form-label uk-margin-remove-top"> @lang('front/auth.city')</div>
                                        <input id="city" class="uk-input form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city" autofocus placeholder="@lang('front/auth.city')" type="text">
                                        @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <div class="uk-form-label uk-margin-remove-top"> @lang('front/auth.zip_code')</div>
                                        <input id="zip_code" class="uk-input form-control @error('zip_code') is-invalid @enderror" name="zip_code" value="{{ old('zip_code') }}" required autocomplete="zip_code" autofocus placeholder="@lang('front/auth.zip_code')" type="text">
                                        @error('zip_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class=" uk-flex-middle" uk-grid>
                                    <div class="uk-width-expand@m">
                                        <input class="uk-button uk-button-success button" type="submit" value="@lang('front/auth.skip_to_payment')">
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
