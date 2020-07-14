@extends('layouts.admin_panel')

@section('content')
    <div class="uk-child-width-1-3@l uk-child-width-1-2@m uk-child-width uk-grid-match " uk-grid>
        <div>
            <div class="uk-background-cover uk-light dashboard-card" data-src="#" uk-img>
                <i class="fas fa-laptop-code icon-xxlarge"></i>
                <p>@lang('front/auth.general_education')</p>
                <h3> {{$data['ge_courses_count']}} @lang('front/auth.course') </h3>
                <a href="{{route('ge_index')}}" class="uk-button"> @lang('front/auth.see_all') </a>
            </div>
        </div>
        <div>
            <div class="uk-background-cover uk-light dashboard-card" data-src="#" uk-img>
                <i class="fas fa-school icon-xxlarge"></i>
                <p>@lang('front/auth.prepare_for_lessons')</p>
                <h3> {{$data['pl_courses_count']}} @lang('front/auth.course') </h3>
                <a href="{{route('pl_index')}}" class="uk-button"> @lang('front/auth.see_all') </a>
            </div>
        </div>
        <div>
            <div class="uk-background-cover uk-light dashboard-card" data-src="#" uk-img>
                <i class="fas fa-user-graduate icon-xxlarge"></i>
                <p> @lang('front/auth.prepare_for_exams') </p>
                <h3> {{$data['pe_courses_count']}} @lang('front/auth.course') </h3>
                <a href="{{route('pe_index')}}" class="uk-button"> @lang('front/auth.see_all') </a>
            </div>
        </div>
        <div>
            <div class="uk-background-cover uk-light dashboard-card" data-src="#" uk-img>
                <i class="fas fa-users icon-xxlarge"></i>
                <p>@lang('front/auth.registered_users')</p>
                <h3> {{$data['users_count']}} @lang('front/auth.user') </h3>
                <a href="{{route('admin_users')}}" class="uk-button"> @lang('front/auth.see_all') </a>
            </div>
        </div>
        <div>
            <div class="uk-background-cover uk-light dashboard-card" data-src="#" uk-img>
                <i class="fas fa-chalkboard-teacher icon-xxlarge"></i>
                <p>@lang('front/auth.registered_instructors')</p>
                <h3> {{$data['instructors_count']}} @lang('front/auth.instructor') </h3>
                <a href="{{route('admin_instructor')}}" class="uk-button"> @lang('front/auth.see_all') </a>
            </div>
        </div>
        <div>
            <div class="uk-background-cover uk-light dashboard-card" data-src="#" uk-img>
                <i class="fas fa-money-bill-wave icon-xxlarge"></i>
                <p> @lang('front/auth.total_purchase') </p>
                <h3> {{$data['purchases_count']}} @lang('front/auth.course')</h3>
                <a href="{{route('admin_purchases')}}" class="uk-button"> @lang('front/auth.see_all') </a>
            </div>
        </div>
    </div>

    <div uk-grid class="uk-margin-xlarge-top uk-margin-xlarge-bottom">
        <div class="uk-width-1-2@l">
            <div class="uk-card-small uk-card-default">
                <div class="uk-card-header uk-text-bold">
                    <i class="fas fa-users uk-margin-small-right"></i> @lang('front/auth.last_registered_users')
                </div>
                <div class="uk-card-body uk-padding-remove-top">
                    <div class="uk-child-width-1-3@m uk-child-width-1-2 uk-flex uk-flex-wrap uk-flex-center"  uk-scrollspy="target: > div; cls:uk-animation-scale-up; delay: 100" uk-grid>
                        @foreach($data['last_users'] as $user)
                            <div class="uk-padding-small uk-text-center">
                                <img src="{{asset($user->avatar)}}" alt="" class="uk-border-circle user-profile-tiny">
                                <h5 class="uk-margin-remove-bottom uk-margin-remove-top ">{{$user->first_name}} {{$user->last_name}}</h5>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-width-1-2@l">
            <div class="uk-card-small uk-card-default">
                <div class="uk-card-header uk-text-bold">
                    <i class="fas fa-chalkboard-teacher uk-margin-small-right"></i> @lang('front/auth.last_registered_instructors')
                </div>
                <div class="uk-card-body uk-padding-remove-top">
                    <div class="uk-child-width-1-3@m uk-child-width-1-2 uk-grid-collapse uk-flex-center"  uk-scrollspy="target: > div; cls:uk-animation-scale-up; delay: 100" uk-grid>
                        @foreach($data['last_instructors'] as $user)
                            <div class="uk-padding-small uk-text-center">
                                <img src="{{asset($user->user->avatar)}}" alt="" class="uk-border-circle user-profile-tiny">
                                <h5 class="uk-margin-remove-bottom uk-margin-remove-top ">{{$user->user->first_name}} {{$user->user->last_name}}</h5>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
