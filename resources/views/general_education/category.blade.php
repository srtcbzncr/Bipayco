@extends('layouts.app')
@section('content')

    <div class="hero-bg" style="background: {{$category->color}}; margin-top: -80px">
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
                <div class="video-responsive">
                    <div class="uk-cover-container">
                        <img src="{{$category->image}}" alt="" uk-cover>
                        <canvas style="max-height: 400px; max-width:600px;" width="600" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="uk-container">
        @if($sub_categories!=null && $sub_categories!=[])
            <div class="section-heading uk-position-relative uk-margin-medium-top uk-margin-remove-bottom none-border uk-clearfix">
                <div class="uk-float-left">
                    <h2>@lang('front/auth.sub_categories')</h2>
                </div>
            </div>
            <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
                <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                    @foreach($sub_categories as $sub_category)
                        <li>
                            <category-card
                                background-color="{{$sub_category->color}}"
                                sub-category-name="{{$sub_category->name}}"
                                sub-category-desc="{{$sub_category->description}}"
                                explore="@lang('front/auth.explore')"
                                sub-category-route="{{route('ge_sub_category_courses', $sub_category->id)}}"
                                sub-category-img="{{$sub_category->image}}"
                                course="@lang('front/auth.course')"
                                course-count="{{$sub_category->courseCount()}}"
                            ></category-card>
                        </li>
                    @endforeach
                </ul>
                <a class="uk-position-center-left uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-next uk-slider-item="next"></a>
                <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin">
                    <li uk-slider-item="0" class="">
                        <a href="#"></a>
                    </li>
                </ul>
            </div>
        @endif
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
            id="{{$category->id}}"
            name="Category"
            :paginate-course = "9"
            style-full-star-color="#F4C150"
            style-empty-star-color="#C1C1C1"
            module-name="generalEducation"
            module="ge"
            @if(Auth::check())
                is-login
                user-id="{{Auth::user()->id}}"
            @endif
        ></course-card-pagination>
    </div>
@endsection
