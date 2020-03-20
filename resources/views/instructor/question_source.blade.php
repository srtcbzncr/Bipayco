@extends('layouts.admin')
@section('content')
    <div class="uk-container uk-margin-medium-top">
        <div>
            <a href="{{route('questionSource_create')}}" class="uk-button uk-button-success uk-width">
                <i class="fas fa-plus uk-margin-small-right"> </i>
                @lang('front/auth.create_new_question')
            </a>
        </div>
        <div class="uk-grid align-items-center justify-content-center uk-margin-top">
            <div class="uk-width-1-6">
                <div class="uk-form-label"> Sayı </div>
            </div>
            <div class="uk-width-1-2">
                <div class="uk-form-label"> Soru </div>
            </div>
            <div class="uk-width-1-6">
                <div class="uk-form-label"> Ders </div>
            </div>
            <div class="uk-width-1-6">
                <div class="uk-form-label"> Zorluk </div>
            </div>
        </div>
        <hr>
        <question-source-list
            user-id="{{Auth::user()->id}}"
        > </question-source-list>
    </div>
@endsection
