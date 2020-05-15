@extends('layouts.app')
@section('content')
    <div class="uk-container uk-margin-medium-top">
        <div uk-grid>
            <div class="uk-width-1-4@m">
                <div class="uk-card uk-card-default border-radius-6 uk-card uk-padding-small  uk-box-shadow-medium" uk-sticky="offset: 90; bottom: true; media: @m;">
                    <div class="uk-flex uk-flex-center">
                        <img src="{{asset(Auth::user()->avatar)}}" class="uk-margin uk-height-small uk-width-small uk-border-circle">
                    </div>
                    <div class="uk-h4 uk-margin-remove uk-text-center uk-margin-small-top">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</div>
                    <div class="uk-text-meta uk-text-center">{{Auth::user()->district->name}}, {{Auth::user()->district->city->name}}</div>
                    <div class="uk-margin-medium-bottom  uk-margin-top  uk-text-center">
                        <a class="Course-tags uk-margin-small-right border-radius-6 tags-bg-danger" href="{{route('settings')}}"><i class="fas fa-cog"></i> @lang('front/auth.settings') </a>
                        <a class="Course-tags uk-margin-small-right border-radius-6 tags-bg-danger" href="{{route('logout')}}"><i class="fas fa-sign-out-alt"></i> @lang('front/auth.log_out') </a>
                    </div>
                    <ul class="uk-list uk-list-divider uk-margin-remove-bottom uk-text-center uk-text-small" style="margin: -15px;">
                        <li>
                            <p><span class="fas fa-at"></span> {{Auth::user()->username}}</p>
                        </li>
                        <li>
                            <p><span class="fas fa-mobile-alt"></span> {{Auth::user()->phone_number}}</p>
                        </li>
                        <li>
                            <p><span class="fas fa-envelope"></span> {{Auth::user()->email}}</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="uk-width-3-4@m">
                <h3 class="uk-heading-line uk-text-center"><span> @lang('front/auth.general_education') </span></h3>
                <course-progress-card user-id="{{Auth::user()->id}}" no-content="@lang('front/auth.not_found_content')" general-education></course-progress-card>
                <h3 class="uk-heading-line uk-text-center"><span> @lang('front/auth.prepare_for_lessons') </span></h3>
                <course-progress-card user-id="{{Auth::user()->id}}" no-content="@lang('front/auth.not_found_content')" prepare-for-lessons></course-progress-card>
                <h3 class="uk-heading-line uk-text-center"><span> @lang('front/auth.prepare_for_exams') </span></h3>
                <course-progress-card user-id="{{Auth::user()->id}}" no-content="@lang('front/auth.not_found_content')" prepare-for-exams></course-progress-card>
{{--                <h3 class="uk-heading-line uk-text-center"><span> @lang('front/auth.homeworks') </span></h3>--}}
{{--                <course-progress-card user-id="{{Auth::user()->id}}" no-content="@lang('front/auth.not_found_content')" homeworks></course-progress-card>--}}
            </div>
        </div>
    </div>
@endsection
