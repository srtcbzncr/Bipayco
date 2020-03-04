@extends('layouts.admin')
@section('content')
    <!--total student counts, instructor point, total comment counts-->
    <div class="uk-container">
        <div class="uk-child-width-1-2@m uk-card-body uk-grid-small uk-grid-divider uk-grid-match" uk-grid>
            <div>
                <div class="uk-card uk-card-default uk-card-body text-center stats-card">
                    <h3 class="stats-card-title uk-card-title">@lang('front/auth.instructor_point')</h3>
                    <p><span class="fas fa-star uk-margin-small-right"></span>{{$instructorScore}}</p>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-body text-center stats-card">
                    <h3 class="stats-card-title uk-card-title">@lang('front/auth.total_student_count')</h3>
                    <p><span class="fas fa-user uk-margin-small-right"></span> {{$totalStudent}}</p>
                </div>
            </div>
        </div>
    </div>
    <!--course counts-->
    <div class="uk-container">
        <div class="uk-card">
            <h3 class="uk-heading-line uk-text-center"><span> @lang('front/auth.course_count') </span></h3>
            <div class="uk-child-width-1-3@m uk-card-body uk-child-width-1-2@s uk-grid-small uk-grid-match" uk-grid>
                <div>
                    <div class="uk-card uk-card-default uk-card-body text-center stats-card">
                        <h3 class="stats-card-title uk-card-title">@lang('front/auth.general_education')</h3>
                        <p><span class="fas fa-chalkboard-teacher uk-margin-small-right"></span>{{$geCount}}</p>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-body text-center stats-card">
                        <h3 class="stats-card-title uk-card-title">@lang('front/auth.prepare_for_lessons')</h3>
                        <p><span class="fas fa-chalkboard-teacher uk-margin-small-right"></span>{{$plCount}}</p>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-body text-center stats-card">
                        <h3 class="stats-card-title uk-card-title">@lang('front/auth.prepare_for_exams')</h3>
                        <p><span class="fas fa-chalkboard-teacher uk-margin-small-right"></span>{{$peCount}}</p>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-body text-center stats-card">
                        <h3 class="stats-card-title uk-card-title">@lang('front/auth.exams')</h3>
                        <p><span class="fas fa-chalkboard-teacher uk-margin-small-right"></span>{{$praticeExamsCount}}</p>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-body text-center stats-card">
                        <h3 class="stats-card-title uk-card-title">@lang('front/auth.books')</h3>
                        <p><span class="fas fa-chalkboard-teacher uk-margin-small-right"></span>{{$qbCount}}</p>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-body text-center stats-card">
                        <h3 class="stats-card-title uk-card-title">@lang('front/auth.homeworks')</h3>
                        <p><span class="fas fa-chalkboard-teacher uk-margin-small-right"></span>{{$homeworkCount}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--total earnings-->
    <div class="uk-container uk-margin-top">
        <div class="uk-card">
            <h3 class="uk-heading-line uk-text-center"><span> @lang('front/auth.total_earning') </span></h3>
            <div class="uk-child-width-1-3@m uk-card-body uk-grid-small uk-grid-divider uk-grid-match" uk-grid>
                <div>
                    <div class="uk-card uk-card-default uk-card-body text-center stats-card">
                        <h3 class="stats-card-title uk-card-title">@lang('front/auth.monthly')</h3>
                        <p><span class="fas fa-lira-sign uk-margin-small-right"></span>{{$totalMonthPrice}}</p>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-body text-center stats-card">
                        <h3 class="stats-card-title uk-card-title">@lang('front/auth.yearly')</h3>
                        <p><span class="fas fa-lira-sign uk-margin-small-right"></span>{{$totalYearPrice}}</p>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-body text-center stats-card">
                        <h3 class="stats-card-title uk-card-title">@lang('front/auth.total')</h3>
                        <p><span class="fas fa-lira-sign uk-margin-small-right"></span>{{$totalPrice}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--total earnings-->
    <div class="uk-container uk-margin-top">
        <div class="uk-card">
            <h3 class="uk-heading-line uk-text-center"><span> @lang('front/auth.comments') </span></h3>
            <div class="uk-child-width-1-2@m uk-card-body uk-grid-small uk-grid-divider uk-grid-match" uk-grid>
                <div>
                    <div class="uk-card uk-card-default uk-card-body text-center stats-card">
                        <h3 class="stats-card-title uk-card-title">@lang('front/auth.total')</h3>
                        <p><span class="fas fa-comment uk-margin-small-right"></span>20000</p>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-body text-center stats-card">
                        <h3 class="stats-card-title uk-card-title">@lang('front/auth.wait_for_response')</h3>
                        <p><span class="fas fa-comment-dots uk-margin-small-right"></span>20000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
