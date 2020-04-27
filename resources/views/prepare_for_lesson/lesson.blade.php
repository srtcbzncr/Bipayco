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
    <ul uk-switcher="connect: #courses" class="uk-flex-center uk-margin-medium-top uk-subnav uk-subnav-pill uk-margin-remove-bottom">
        @if(count($grades)< 7)
            @foreach($grades as $grade)
                <li><a href="#">{{$grade->name}}</a></li>
            @endforeach
        @else
            @foreach($grades as $grade)
                @if($loop->index < 5)
                    <li><a href="#">{{$grade->name}}</a></li>
                @endif
            @endforeach
            <li>
                <a href="#">@lang('front/auth.more') <span class="fas fa-angle-down uk-margin-small-left icon-small"></span></a>
                <div uk-dropdown="mode: click">
                    <ul class="uk-nav uk-dropdown-nav" uk-switcher="connect: #courses">
                        @foreach($grades as $grade)
                            @if($loop->index >= 5)
                                <li><a href="#">{{$grade->name}}</a></li>
                            @else
                                <li class="uk-hidden"></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </li>
        @endif
    </ul>
    <course-card-pagination
        newest="@lang('front/auth.newest')"
        by-inc="@lang('front/auth.by_inc')"
        by-desc="@lang('front/auth.by_dec')"
        by-purchases="@lang('front/auth.by_purchases')"
        sort="@lang('front/auth.sort_by')"
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
        @if(Auth::check())
            is-login
            user-id="{{Auth::user()->id}}"
        @endif
    ></course-card-pagination>
@endsection
