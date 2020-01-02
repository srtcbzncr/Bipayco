@extends('layouts.app')
@section('content')
    <div class="uk-container uk-margin-medium-top">
        @foreach($categories as $category)
            <div class="section-heading uk-position-relative uk-margin-medium-top none-border uk-clearfix">
                <div class="uk-float-left">
                    <h2>{{$category->name}}</h2>
                    <p>{{$category->description}}</p>
                </div>
                <div class="uk-float-right">
                    <a href="{{route('ge_category_courses', $category->id)}}" class="uk-button uk-button-grey">@lang('front/auth.see_more')</a>
                </div>
            </div>
                <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
                    <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                        @foreach($category->subCategories as $sub_category)
                            <li>
                                <category-card
                                    background-color="{{$sub_category->color}}"
                                    sub-category-name="{{$sub_category->name}}"
                                    sub-category-desc="{{$sub_category->description}}"
                                    explore="@lang('front/auth.explore')"
                                    sub-category-route="{{route('ge_sub_category_courses', $sub_category->id)}}"
                                    sub-category-img="{{$sub_category->symbol}}"
                                    course="@lang('front/auth.course')"
                                    course-count="8"
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
        @endforeach
    </div>
@endsection
