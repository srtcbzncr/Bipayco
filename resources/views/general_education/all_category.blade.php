@extends('layout.app')
@section('content')
    <div class="uk-container uk-margin-medium-top">

            <div class="section-heading uk-position-relative uk-margin-medium-top none-border uk-clearfix">
                <div class="uk-float-left">
                    <h2>{{$category->name}}</h2>
                    <p>{{$category->description}}</p>
                </div>
                <div class="uk-float-right">
                    <a href="#" class="uk-button uk-button-grey">@lang('front/auth.see_more')</a>
                </div>
            </div>
            @if($prepare_for_exams === null || count($prepare_for_exams) === 0)
                <div class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                    <h4 class="uk-text-bold uk-margin-remove-top">@lang('front/auth.not_found_content')</h4>
                </div>
            @else
                <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
                    <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                        <li>

                                <category-card
                                    sub-category-name="name"
                                    sub-category-desc="lorem ipsum"
                                    explore="@lang('front/auth.explore')"
                                    sub-category-route="#"
                                    sub-category-img="#"
                                    course="@lang('front/auth.course')"
                                    course-count="sub-category-course-count"
                                ></category-card>

                        </li>
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

    </div>
@endsection
