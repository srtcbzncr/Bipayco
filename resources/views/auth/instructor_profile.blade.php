@extends('layouts.app')
@section('content')
    <div class="uk-container uk-margin-medium-top">
        <div uk-grid>
            <div class="uk-width-1-4@m">
                <div class="uk-card uk-card-default border-radius-6 uk-card uk-padding-small  uk-box-shadow-medium" uk-sticky="offset: 90; bottom: true; media: @m;">
                    <div class="uk-flex uk-flex-center">
                        <img src="{{asset($instructor->user->avatar)}}" class="uk-margin uk-height-small uk-width-small uk-border-circle">
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
            <instructor-profile-courses
                @if(Auth::check())
                    auth-check
                    user-id="{{Auth::user()->id}}"
                @endif
                bio="{{$instructor->bio}}"
                bio-text="@lang('front/auth.bio')"
                prepare-lessons-text="@lang('front/auth.prepare_for_lessons')"
                prepare-exams-text="@lang('front/auth.prepare_for_exams')"
                general-education-text="@lang('front/auth.general_education')"
            ></instructor-profile-courses>
        </div>
    </div>
@endsection
