@extends('layouts.auth')
@section('content')
    <form method="POST" action="{{ route('forgotPasswordPost') }}">
        @csrf
        <div class="uk-card-default uk-padding uk-card-small">
            <!-- Login tab tab -->
            <div id="login" class="tabcontent tab-default-open animation: uk-animation-slide-right-medium">
                <h2 class="uk-text-bold">@lang('front/auth.forget_password')</h2>
                <p class="uk-text-muted uk-margin-remove-top uk-margin-medium   -bottom">@lang('front/auth.forget_password_description')</p>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
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
                <div class="uk-flex-middle" uk-grid>
                    <div class="uk-width-expand@m">
                        <input class="uk-button uk-button-success button" type="submit" value="@lang('front/auth.send')">
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
