@extends('layouts.auth')
@section('content')
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
                        <a href="{{asset('contracts/salesContract.pdf')}}" target="blank_" class="uk-text-bold uk-text-small" > Satış sözleşmesini </a>
                        <span class="checkmark uk-text-small"> kabul ediyorum </span>
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
@endsection
