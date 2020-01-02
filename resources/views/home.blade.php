@extends('layouts.app')

@section('content')
    <div src="/images/slider_bg.jpg" style="background-image: url(../images/slider_bg.jpg)" uk-img class="tm-hero uk-height-large uk-background-norepeat  uk-background-center-center uk-section uk-flex uk-flex-bottom uk-background-cover">
        <div class="uk-width-1-1 uk-container uk-margin-large-top uk-margin-large-left ">
            <h1 class="uk-text-bold uk-text-white uk-margin-small-bottom"> Learn to code. <br>  One project at a time</h1>
            <h4 class="uk-text-bold uk-light uk-margin-remove-top">Learn how to Build websites apps & games for free   </h4>
            <a class="uk-button tm-button-grey" href="#browse-corses" uk-scroll>
                Browse Courses </a>
        </div>
    </div>
    <div class="uk-container">
        <div class="section-heading uk-position-relative uk-margin-medium-top none-border uk-clearfix">
            <div class="uk-float-left">
                <h2>@lang('front/auth.general_education')</h2>
                <p>@lang('front/auth.popular_in_category')</p>
            </div>
            <div class="uk-float-right">
                <a href="{{route('ge_index')}}" class="uk-button uk-button-grey">@lang('front/auth.see_more')</a>
            </div>
        </div>
    </div>
    @if($general_education === null || count($general_education) === 0)
        <div class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
            <h4 class="uk-text-bold uk-margin-remove-top">@lang('front/auth.not_found_content')</h4>
        </div>
    @else
        <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
            <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
            @foreach($general_education as $general_educations)
                        <li>
                    <course-card
                        title="{{$general_educations->name}}"
                        description="{{$general_educations->description}}"
                        img-path="{{$general_educations->image}}"
                        @if($general_educations->price!=$general_educations->price_with_discount)
                        discount
                        :current-price="{{$general_educations->price_with_discount}}"
                        :prev-price="{{$general_educations->price}}"
                        @else
                        :current-price="{{$general_educations->price}}"
                        @endif
                        :rate="{{$general_educations->point}}"
                        page-link="{{route('ge_course', $general_educations->id)}}"
                        style-full-star-color="#F4C150"
                        style-empty-star-color="#C1C1C1"
                    ></course-card>
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
    <div class="uk-container">
        <div class="section-heading uk-position-relative uk-margin-medium-top none-border uk-clearfix">
            <div class="uk-float-left">
                <h2>@lang('front/auth.prepare_for_exams')</h2>
                <p>@lang('front/auth.popular_in_category')</p>
            </div>
            <div class="uk-float-right">
                <a href="#" class="uk-button uk-button-grey">@lang('front/auth.see_more')</a>
            </div>
        </div>
    </div>
    @if($prepare_for_exams === null || count($prepare_for_exams) === 0)
        <div class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
            <h4 class="uk-text-bold uk-margin-remove-top">@lang('front/auth.not_found_content')</h4>
        </div>
    @else
        <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
            <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                @foreach ($prepare_for_exams as $prepare_for_exam)
                    <li class="uk-active">
                        <course-card
                            title="{{$prepare_for_exam->name}}"
                            description="{{$prepare_for_exam->description}}"
                            img-path="{{$prepare_for_exam->image}}"
                            @if($prepare_for_exam->price!=$prepare_for_exam->price_with_discount)
                            discount
                            :current-price="{{$prepare_for_exam->price_with_discount}}"
                            :prev-price="{{$prepare_for_exam->price}}"
                            @else
                            :current-price="{{$prepare_for_exam->price}}"
                            @endif
                            :rate="{{$prepare_for_exam->point}}"
                            page-link="/ge/course/{{$prepare_for_exam->id}}"
                        ></course-card>
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
    <div class="uk-container">
        <div class="section-heading uk-position-relative uk-margin-medium-top none-border uk-clearfix">
            <div class="uk-float-left">
                <h2>@lang('front/auth.prepare_for_lessons')</h2>
                <p>@lang('front/auth.popular_in_category')</p>
            </div>
            <div class="uk-float-right">
                <a href="blog-video-one.html" class="uk-button uk-button-grey">@lang('front/auth.see_more')</a>
            </div>
        </div>
    </div>
    @if($prepare_for_lessons === null || count($prepare_for_lessons) === 0)
        <div class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
            <h4 class="uk-text-bold uk-margin-remove-top">@lang('front/auth.not_found_content')</h4>
        </div>
    @else
        <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
            <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                @foreach ($prepare_for_lessons as $prepare_for_lesson)
                    <li>
                        <course-card
                            title="{{$prepare_for_lesson->name}}"
                            description="{{$prepare_for_lesson->description}}"
                            img-path="{{$prepare_for_lesson->image}}"
                            @if($prepare_for_lesson->price!=$prepare_for_lesson->price_with_discount)
                            discount
                            :current-price="{{$prepare_for_lesson->price_with_discount}}"
                            :prev-price="{{$prepare_for_lesson->price}}"
                            @else
                            :current-price="{{$prepare_for_lesson->price}}"
                            @endif
                            :rate="{{$prepare_for_lesson->point}}"
                            page-link="/ge/course/{{$prepare_for_lesson->id}}"
                        ></course-card>
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
    <div class="uk-container">
        <div class="section-heading uk-position-relative uk-margin-medium-top none-border uk-clearfix">
            <div class="uk-float-left">
                <h2>@lang('front/auth.exams')</h2>
                <p>@lang('front/auth.popular_in_category')</p>
            </div>
            <div class="uk-float-right">
                <a href="blog-video-one.html" class="uk-button uk-button-grey">@lang('front/auth.see_more')</a>
            </div>
        </div>
    </div>
    @if($exams===null || count($exams) === 0)
        <div class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
            <h4 class="uk-text-bold uk-margin-remove-top">@lang('front/auth.not_found_content')</h4>
        </div>
    @else
        <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
            <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                @foreach($exams as $exam)
                    <li>
                        <course-card
                            title="{{$exam->name}}"
                            description="{{$exam->description}}"
                            img-path="{{$exam->image}}"
                            @if($exam->price!=$exam->price_with_discount)
                                discount
                                :current-price="{{$exam->price_with_discount}}"
                                :prev-price="{{$exam->price}}"
                            @else
                                :current-price="{{$exam->price}}"
                            @endif
                            :rate="{{$exam->point}}"
                            page-link="/ge/course/{{$exam->id}}"
                        ></course-card>
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
    <div class="uk-container">
        <div class="section-heading uk-position-relative uk-margin-medium-top none-border uk-clearfix">
            <div class="uk-float-left">
                <h2>@lang('front/auth.books')</h2>
                <p>@lang('front/auth.popular_in_category')</p>
            </div>
            <div class="uk-float-right">
                <a href="blog-video-one.html" class="uk-button uk-button-grey">@lang('front/auth.see_more')</a>
            </div>
        </div>
    </div>
    @if($books===null || count($books)===0)
        <div class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
            <h4 class="uk-text-bold uk-margin-remove-top">@lang('front/auth.not_found_content')</h4>
        </div>
    @else
        <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
            <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                @foreach ($books as $book)
                    <li>
                        <course-card
                            title="{{$book->name}}"
                            description="{{$book->description}}"
                            img-path="{{$book->image}}"
                            @if($book->price!=$book->price_with_discount)
                                discount
                                :current-price="{{$book->price_with_discount}}"
                                :prev-price="{{$book->price}}"
                            @else
                                :current-price="{{$book->price}}"
                            @endif
                            :rate="{{$book->point}}"
                            page-link="/ge/course/{{$book->id}}"
                        ></course-card>
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
@endsection
