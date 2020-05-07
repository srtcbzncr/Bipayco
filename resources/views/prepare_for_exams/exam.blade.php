@extends('layouts.app')
@section('content')
    <div class="hero-bg" style="background-color: #3b8895; margin-top: -80px">
        <div uk-grid>
            <div class="uk-width-1-2@m">
                <h1 class="uk-animation-fade">{{$exam->name}}</h1>
                <div class="uk-visible@m uk-animation-slide-bottom-small uk-margin-medium-top" uk-grid>
                    <div class="uk-width-1-3@m uk-flex align-items-center">
                        <i class="fas fa-book-open icon-xxlarge text-white uk-margin-small-right"></i>
                        <span class="uk-text-middle uk-text-white">{{$courseCount}} @lang('front/auth.course') </span>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-2@m uk-visible@m">
                <div class="video-responsive">
                    <div class="uk-cover-container">
                        <img src="{{$category->image}}" alt="" uk-cover>
                        <canvas style="max-height: 400px; max-width:600px;" width="600" height="400"></canvas>
                    </div>
                </div>
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
        category-name="{{$exam->name}}"
        :course-count = "{{$courseCount}}"
        id="{{$exam->id}}"
        :paginate-course = "9"
        name="Exams"
        has-no-content="@lang('front/auth.not_found_content')"
        module-name="prepareExams"
        module="pe"
        @if(Auth::check())
        is-login
        user-id="{{Auth::user()->id}}"
        @endif
    ></lesson-pagination>
@endsection
