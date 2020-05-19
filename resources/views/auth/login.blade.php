@extends('layouts.auth')
@section('content')
    <form method="POST" action="{{ route('loginPost') }}">
        @csrf
        <div class="uk-card-default uk-padding uk-card-small">
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
                        <a href="{{route('forgotPasswordGet')}}" class="tablinks uk-text-small" >@lang('front/auth.forget_password')</a>
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
        </div>
    </form>
@endsection
