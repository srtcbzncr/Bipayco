@extends('layouts.auth')
@section('content')
    <form method="POST" action="{{ route('forgotPasswordPostReset') }}">
        @csrf
        <div class="uk-card-default uk-padding uk-card-small">
            <!-- Login tab tab -->
            <div id="resetPassword" class="tabcontent tab-default-open animation: uk-animation-slide-right-medium">
                <h2 class="uk-text-bold">@lang('front/auth.reset_password')</h2>
                <p class="uk-text-muted uk-margin-remove-top uk-margin-medium-bottom">@lang('front/auth.reset_password_description')</p>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <input id="email" class="uk-input uk-form-width-large uk-hidden uk-disabled form-control @error('email') is-invalid @enderror" name="email" type="text" value="{{$email}}">
                <div class="uk-margin-small">
                    <div class="uk-inline uk-flex align-items-center">
                        <input id="password" class="uk-input uk-form-width-large form-control @error('password') is-invalid @enderror" name="password" required autocomplete="password" placeholder="@lang('front/auth.new_password')" type="password">
                        <a class="fas fa-eye" onclick="togglePassword('password')" style="margin-left: -30px;"></a>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="uk-margin-small">
                    <div class="uk-inline uk-flex align-items-center">
                        <input id="passwordAgain" class="uk-input uk-form-width-large form-control @error('passwordAgain') is-invalid @enderror" name="passwordAgain" required autocomplete="password" placeholder="@lang('front/auth.new_password_repeat')" type="password">
                        <a class="fas fa-eye" onclick="togglePassword('passwordAgain')" style="margin-left: -30px;"></a>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="uk-flex-middle" uk-grid>
                    <div class="uk-width-expand@m">
                        <input class="uk-button uk-button-success button" type="submit" value="@lang('front/auth.save')">
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
