@extends('layouts.app')
@section('content')
    <div class="uk-container uk-margin-medium-top">
        <div uk-grid>
            <div class="uk-width-1-4@m">
                <div class="uk-card uk-card-default border-radius-6 uk-card uk-padding-small  uk-box-shadow-medium" uk-sticky="offset: 90; bottom: true; media: @m;">
                    <div class=" uk-width-1-3 uk-width-1-4@s uk-width-1-2@m  uk-margin-small-bottom  uk-margin-small-top uk-margin-auto uk-visible-toggle uk-position-relative uk-border-circle uk-overflow-hidden uk-light">
                        <img class="uk-width-1-1" src="{{asset($instructor->user->avatar)}}">
                    </div>
                    <div class="uk-h4 uk-margin-remove uk-text-center uk-margin-small-top">{{$instructor->user->first_name}} {{$instructor->user->last_name}}</div>
                    <div class="uk-text-meta uk-text-center">{{$instructor->title}}</div>
                    <ul class="uk-list uk-list-divider uk-margin-remove-bottom uk-margin-small-top uk-text-center uk-text-small" style="margin: -15px;">
                        <li>
                            <p> <span class="fas fa-play icon small"></span> {{$instructor->courseCount()}} @lang('front/auth.course')   </p>
                        </li>
                        <li>
                            <p> <span class="fas fa-envelope icon-small"> </span>   {{$instructor->user->email}} </p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="uk-width-3-4@m">
                <h3 class="uk-heading-line uk-text-center"><span>@lang('front/auth.bio') </span></h3>
                <div class="uk-margin-medium-top uk-padding-small">
                    <p class="uk-margin-remove-top uk-margin-small-bottom">{{$instructor->bio}}</p>
                </div>

                <h3 class="uk-heading-line uk-text-center uk-margin-large-top"><span>@lang('front/auth.general_education') </span></h3>
                <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
                    <ul class="uk-slider-items uk-child-width-1-2@s uk-grid">
                        @foreach($instructor->geCourses as $general_educations)
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
            </div>
        </div>
    </div>
@endsection