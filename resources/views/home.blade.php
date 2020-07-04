@extends('layouts.app')

@section('content')
    <div class="uk-position-relative uk-visible-toggle uk-light"     tabindex="-1" uk-slideshow="autoplay:true; autoplay-interval: 7000; finite: false; pause-on-hover: true; min-height: 250; max-height: 500; animation:fade">
        <ul class="uk-slideshow-items">
            <li>
                <img src="{{asset("/images/homepage-slider/1.jpg")}}" alt="" uk-cover>
                <div class="uk-overlay uk-overlay-primary uk-position-bottom-left uk-text-center">
                    <h2 class="uk-margin-remove">Türkiye'nin en büyük online eğitim platformu</h2>
                </div>
            </li>
            <li>
                <img src="{{asset("/images/homepage-slider/2.jpg")}}" alt="" uk-cover>
                <div class="uk-overlay uk-overlay-primary uk-position-bottom-left uk-text-center">
                    <h2 class="uk-margin-remove">Türkiye'nin en büyük online eğitim platformu</h2>
                </div>
            </li>
            <li>
                <img src="{{asset("/images/homepage-slider/3.jpg")}}" alt="" uk-cover>
                <div class="uk-overlay uk-overlay-primary uk-position-bottom-left uk-text-center">
                    <h2 class="uk-margin-remove">Türkiye'nin en büyük online eğitim platformu</h2>
                </div>
            </li>
            <li>
                <img src="{{asset("/images/homepage-slider/4.jpg")}}" alt="" uk-cover>
                <div class="uk-overlay uk-overlay-primary uk-position-bottom-left uk-text-center">
                    <h2 class="uk-margin-remove">Türkiye'nin en büyük online eğitim platformu</h2>
                </div>
            </li>
        </ul>

        <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
        <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
    </div>
 <!--<div src="/images/slider_bg.jpg" style="background-image: url(../images/slider_bg.jpg); margin-top:-80px" uk-img class="uk-height-large uk-background-norepeat  uk-background-center-center uk-section uk-flex uk-flex-bottom uk-background-cover">
     <div class="uk-width-1-1 uk-container uk-margin-large-top uk-margin-large-left ">
         <h1 class="uk-text-bold uk-text-white uk-margin-small-bottom"> Türkiye'nin en büyük <br>  online eğitim platformu</h1>
         <h4 class="uk-text-bold uk-light uk-margin-remove-top"></h4>
         <a class="uk-button tm-button-grey" uk-scroll>
             Keşfet </a>
     </div>
 </div>-->
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
        live-streams-text="@lang('front/auth.live_streams')"
        live-stream-text="@lang('front/auth.live_stream')"
        expected-date-text="@lang('front/auth.expected_date')"
    ></homepage-content>
@endsection
