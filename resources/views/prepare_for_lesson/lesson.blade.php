@extends('layouts.app')
@section('content')
    <div class="hero-bg" style="background-color: #3b8895; margin-top: -80px">
        <div uk-grid>
            <div class="uk-width-1-2@m">
                <h1 class="uk-animation-fade">{{$name}}</h1>
                <div class="uk-visible@m uk-animation-slide-bottom-small uk-margin-medium-top" uk-grid>
                    <div class="uk-width-1-3@m uk-flex align-items-center">
                        <i class="fas fa-book-open icon-xxlarge text-white uk-margin-small-right"></i>
                        <span class="uk-text-middle uk-text-white">{{$courseCount}} @lang('front/auth.course') </span>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-2@m uk-visible@m">
            </div>
        </div>
    </div>
    <lesson-pagination
        newest="@lang('front/auth.newest')"
        by-inc="@lang('front/auth.by_inc')"
        by-desc="@lang('front/auth.by_dec')"
        by-purchases="@lang('front/auth.by_purchases')"
        sort-text="@lang('front/auth.sort_by')"
        oldest="@lang('front/auth.oldest')"
        by-trending="@lang('front/auth.by_trending')"
        by-point="@lang('front/auth.by_point')"
        category-name="{{$name}}"
        :course-count = "{{$courseCount}}"
        id="{{$id}}"
        :paginate-course = "9"
        name="Lessons"
        has-no-content="@lang('front/auth.not_found_content')"
        module-name="prepareLessons"
        module="pl"
        :grades="{{$grades}}"
        @if(Auth::check())
        is-login
        user-id="{{Auth::user()->id}}"
        @endif
    ></lesson-pagination>
@endsection
