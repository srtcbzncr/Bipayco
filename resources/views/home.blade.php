@extends('layouts.app')

@section('content')
    <div src="/public/images/backgrounds/Homepage-logo.jpg" style="background-color: #3e474f57;background-blend-mode: color-burn;" uk-img class="tm-hero uk-height-large uk-background-norepeat  uk-background-center-center uk-section uk-flex uk-flex-bottom uk-background-cover">
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
                <h2>Browse Web development courses</h2>
                <p>Adipisici elit, sed eiusmod tempor incidunt ut labore et</p>
            </div>
            <div class="uk-float-right">
                <a href="blog-video-one.html" class="uk-button uk-button-default">See more</a>
            </div>
        </div>
    </div>
    <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
        <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
            <li class="uk-active">
                <course-card
                    title=""
                    description="Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                     sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                     Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                     nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                     reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                     pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                     culpa qui officia deserunt mollit anim id est laborum."
                    img-path=../../public/images/courses/course-1.jpg"
                    prev-price="10.00"
                    current-price="5.00"
                    rank="4.5"
                    page-link="#"
                    discount></course-card>
            </li>
            <li class="uk-active">
                <course-card/>
            </li>
            <li class="uk-active">
                <course-card/>
            </li>
            <li>
                <course-card/>
            </li>
            <li>
                <course-card/>
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
    <div class="uk-container">
        <div class="section-heading uk-position-relative uk-margin-medium-top none-border uk-clearfix">
            <div class="uk-float-left">
                <h2>Browse Web development courses</h2>
                <p>Adipisici elit, sed eiusmod tempor incidunt ut labore et</p>
            </div>
            <div class="uk-float-right">
                <a href="blog-video-one.html" class="uk-button uk-button-default">See more</a>
            </div>
        </div>
    </div>
    <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
        <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
            <li class="uk-active">
                <course-card></course-card>
            </li>
            <li class="uk-active">
                <course-card/>
            </li>
            <li class="uk-active">
                <course-card/>
            </li>
            <li>
                <course-card/>
            </li>
            <li>
                <course-card/>
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
    <div class="uk-container">
        <div class="section-heading uk-position-relative uk-margin-medium-top none-border uk-clearfix">
            <div class="uk-float-left">
                <h2>Browse Web development courses</h2>
                <p>Adipisici elit, sed eiusmod tempor incidunt ut labore et</p>
            </div>
            <div class="uk-float-right">
                <a href="blog-video-one.html" class="uk-button uk-button-default">See more</a>
            </div>
        </div>
    </div>
    <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
        <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
            <li class="uk-active">
                <course-card></course-card>
            </li>
            <li class="uk-active">
                <course-card/>
            </li>
            <li class="uk-active">
                <course-card/>
            </li>
            <li>
                <course-card/>
            </li>
            <li>
                <course-card/>
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
@endsection
