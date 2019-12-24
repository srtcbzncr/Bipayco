@extends('layouts.app')
@section('content')

    <div class="hero-bg" style="background: {{$category->color}}">
        <div uk-grid>
            <div class="uk-width-1-2@m">
                <h1 class="uk-animation-fade">{{$category->name}}</h1>
                <p> {{$category->description}} </p>
                <div class="uk-visible@m uk-animation-slide-bottom-small uk-margin-medium-top" uk-grid>
                    <div class="uk-width-1-3@m">
                        <i class="fas fa-book-open icon-xxlarge text-white uk-margin-small-right"></i>
                        <span class="uk-text-middle uk-text-white">{{$course_count}} Courses </span>
                    </div>
                    <div class="uk-width-1-2@m">
                        <i class="fas fa-tags icon-xxlarge text-white uk-margin-small-right"></i>
                        <span class="uk-text-middle uk-text-white">{{$sub_categories_count}} Sub Categories </span>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-2@m uk-visible@m">
                <img src="#" alt="" class="uk-align-right img-xxlarge">
            </div>
        </div>
    </div>
    <div class="uk-container">
        <div class="uk-clearfix boundary-align uk-margin-medium-top">
            <div class="uk-float-left section-heading none-border">
                <h2>Browse Web development courses</h2>
                <p>Adipisici elit, sed eiusmod tempor incidunt ut labore et</p>
            </div>
            <div class="uk-float-right">
                <span class="uk-text-small uk-text-uppercase"> Sort by :</span>
                <button class="uk-button uk-button-default uk-background-default uk-button-small" type="button" uk-tooltip="title: Sort; pos: top-right"> Newest  </button>
                <div uk-dropdown="pos: top-right ;mode : click" class="uk-dropdown  uk-dropdown-top-right" style="left: -141px; top: -267px;">
                    <ul class="uk-nav uk-dropdown-nav">
                        <li class="uk-active">
                            <a href="#">Best Courses</a>
                        </li>
                        <li>
                            <a href="#">Newest Courses</a>
                        </li>
                        <li>
                            <a href="#">Most Courses takes </a>
                        </li>
                        <li>
                            <a href="#">Oldest Courses</a>
                        </li>
                        <li class="uk-nav-divider"></li>
                        <li>
                            <a href="#">trending Courses</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match uk-margin" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div ; delay: 200" uk-grid>
            <course-card></course-card>
            <course-card></course-card>
            <course-card></course-card>
            <course-card></course-card>
            <course-card></course-card>
            <course-card></course-card>
            <course-card></course-card>
            <course-card></course-card>
            <course-card></course-card>
        </div>
        <ul class="uk-pagination uk-flex-center uk-margin-medium">
            <li class="uk-active">
                <span>1</span>
            </li>
            <li>
                <a href="#">2</a>
            </li>
            <li>
                <a href="#">3</a>
            </li>
            <li>
                <a href="#">4</a>
            </li>
            <li>
                <a href="#">5</a>
            </li>
            <li>
                <a href="#"><i class="fas fa-ellipsis-h uk-margin-small-top"></i></a>
            </li>
            <li>
                <a href="#">12</a>
            </li>
        </ul>
    </div>
@endsection
