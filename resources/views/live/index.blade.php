@extends('layouts.app')
@section('content')
    <div class="hero-bg topic{{rand(1,10)}}" style=" margin-top: -80px">
        <div uk-grid>
            <div class="uk-width-1-2@m">
                <h1 class="uk-animation-fade">@lang('front/auth.live_streams')</h1>
                <div class="uk-visible@m uk-animation-slide-bottom-small uk-margin-medium-top" uk-grid>
                    <div class="uk-width-1-3@m uk-flex align-items-center">
                        <i class="fas fa-podcast icon-xxlarge text-white uk-margin-small-right"></i>
                        <span class="uk-text-middle uk-text-white">{{$course_count}} @lang('front/auth.live_stream') </span>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-2@m uk-visible@m">
            </div>
        </div>
    </div>
    <live-index-page
        live-streams-text="@lang('front/auth.live_streams')"
        has-no-content="@lang('front/auth.not_found_content')"
        module-name="live"
        module="live"
        @if(Auth::check())
        is-login
        user-id="{{Auth::user()->id}}"
        @endif
    ></live-index-page>
@endsection
