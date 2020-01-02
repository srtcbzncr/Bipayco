@extends('layouts.app')
@section('content')

    <div class="hero-bg" style="background: {{$category->color}}">
        <div uk-grid>
            <div class="uk-width-1-2@m">
                <h1 class="uk-animation-fade">{{$category->name}}</h1>
                <p> {{$category->description}} </p>
                <div class="uk-visible@m uk-animation-slide-bottom-small uk-margin-medium-top" uk-grid>
                    <div class="uk-width-1-3@m uk-flex align-items-center">
                        <i class="fas fa-book-open icon-xxlarge text-white uk-margin-small-right"></i>
                        <span class="uk-text-middle uk-text-white">{{$course_count}} @lang('front/auth.course') </span>
                    </div>
                    <div class="uk-width-1-3@m uk-flex align-items-center">
                        <i class="fas fa-tags icon-xxlarge text-white uk-margin-small-right"></i>
                        <span class="uk-text-middle uk-text-white">{{$sub_categories_count}} @lang('front/auth.sub_category') </span>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-2@m uk-visible@m">
                <img src="{{asset($category->image)}}" alt="" class="uk-align-right img-xxlarge">
            </div>
        </div>
    </div>
    <course-card-pagination
        newest="@lang('front/auth.newest')"
        by-inc="@lang('front/auth.by_inc')"
        by-desc="@lang('front/auth.by_dec')"
        by-purchases="@lang('front/auth.by_purchases')"
        sort="@lang('front/auth.sort_by')"
        oldest="@lang('front/auth.oldest')"
        by-trending="@lang('front/auth.by_trending')"
        by-point="@lang('front/auth.by_point')"
        has-no-content="@lang('front/auth.not_found_content')"
        category-desc="{{$category->description}}"
        category-name="{{$category->name}}"
        :course-count = "{{$course_count}}"
        category-id="{{$category->id}}"
        :paginate-course = "9"
    ></course-card-pagination>
@endsection
