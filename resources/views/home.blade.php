@extends('layouts.app')

@section('content')
    <div src="/images/slider_bg.jpg" style="background-image: url(../images/slider_bg.jpg); margin-top:-80px" uk-img class="uk-height-large uk-background-norepeat  uk-background-center-center uk-section uk-flex uk-flex-bottom uk-background-cover">
        <div class="uk-width-1-1 uk-container uk-margin-large-top uk-margin-large-left ">
            <h1 class="uk-text-bold uk-text-white uk-margin-small-bottom"> Türkiye'nin en büyük <br>  online eğitim platformu</h1>
            <h4 class="uk-text-bold uk-light uk-margin-remove-top"></h4>
            <a class="uk-button tm-button-grey" uk-scroll>
                Keşfet </a>
        </div>
    </div>
    <homepage-content
        @if(Auth::check())
            auth-check
            user-id="{{Auth::user()->id}}"
        @endif
        no-content-text="@lang('front/auth.not_found_content')"
        see-more-text="@lang('front/auth.see_more')"
        general-education-text="@lang('front/auth.general_education')"
        prepare-lessons-text="@lang('front/auth.prepare_for_lessons')"
        prepare-exams-text="@lang('front/auth.prepare_for_exams')"
        exams-text="@lang('front/auth.exams')"
        books-text="@lang('front/auth.books')"
    ></homepage-content>
@endsection
