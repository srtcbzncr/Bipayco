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
                    <a class="" href="{{ route('home') }}"> <img class="uk-logo uk-width-small" src="{{asset('images/logo1.png')}}"/> </a>
                    <!--<h5 class="uk-margin-small uk-text-muted uk-text-bold uk-text-nowrap">'front/auth.bipayco_description'</h5>-->
                </div>
                <div>
                    <form method="POST" action="{{ route('instructor_create_post') }}">
                        @csrf
                        <div class="uk-card-default uk-padding uk-card-small">
                            <div id="register" class="tabcontent animation: uk-animation-slide-left-medium">
                                <h2 class="uk-text-bold">  @lang('front/auth.be_instructor')  </h2>
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <p class="uk-text-muted uk-margin-remove-top uk-margin-small-bottom"></p>
                                <div class="uk-child-width-1-2@l uk-grid">
                                    <div>
                                        <div class="uk-form-label">@lang('front/auth.identification_number') </div>
                                        <input class="uk-input form-control @error('identification_number') is-invalid @enderror" type="text" placeholder="@lang('front/auth.id_num')"  name="identification_number" required>
                                        @error('identification_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <div class="uk-form-label"> @lang('front/auth.title')  </div>
                                        <input class="uk-input form-control @error('title') is-invalid @enderror" type="text" placeholder="@lang('front/auth.title_example')" name="title" required>
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="uk-child-width-1-2@l uk-grid uk-margin-remove-top">
                                    <div>
                                        <div class="uk-form-label"> @lang('front/auth.iban')  </div>
                                        <input class="uk-input form-control @error('iban') is-invalid @enderror" type="text" placeholder="@lang('front/auth.iban')" name="iban" required>
                                        @error('iban')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <div class="uk-form-label">@lang('front/auth.reference_code') <i class="fas fa-question-circle" uk-tooltip="title: @lang('front/auth.reference_code_explain') ; delay: 500 ; pos: bottom ; animation: uk-animation-scale-up"></i></div>
                                        <input class="uk-input" type="text" name="reference_code" placeholder="@lang('front/auth.reference_code')">
                                        @error('reference_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <div class="uk-form-label"> @lang('front/auth.bio')</div>
                                    <textarea class="uk-textarea form-control @error('bio') is-invalid @enderror" type="text" rows="5" name="bio" style=" resize: none" placeholder="@lang('front/auth.bio')" required> </textarea>
                                    @error('bio')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
                                        <input class="uk-button uk-button-success button" type="submit" value="@lang('front/auth.be_instructor')">
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
