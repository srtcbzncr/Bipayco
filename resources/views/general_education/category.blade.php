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
                        <span class="uk-text-middle uk-text-white">{{$course_count}} Courses </span>
                    </div>
                    <div class="uk-width-1-3@m uk-flex align-items-center">
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
    <course-card-pagination
        :course-count = "{{$course_count}}"
        category-id="{{$category->id}}"
        :paginate-course = "9"
    ></course-card-pagination>
@endsection
