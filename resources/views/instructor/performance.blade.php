@extends('layouts.admin')
@section('content')
    <!--course counts-->
    <div class="uk-container">
        <div class="uk-card">
            <h3 class="uk-heading-line uk-text-center"><span> @lang('front/auth.course_count') </span></h3>
            <div class="uk-child-width-1-3@m uk-card-body uk-child-width-1-2@s uk-grid-small uk-grid-match" uk-grid>
                <div>
                    <div class="uk-card uk-card-default uk-card-body text-center">
                        <h3 class="uk-card-title">@lang('front/auth.general_education')</h3>
                        <p class="">20000</p>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-body text-center">
                        <h3 class="uk-card-title">@lang('front/auth.prepare_for_lessons')</h3>
                        <p>20000</p>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-body text-center">
                        <h3 class="uk-card-title">@lang('front/auth.prepare_for_exams')</h3>
                        <p>200</p>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-body text-center">
                        <h3 class="uk-card-title">@lang('front/auth.exams')</h3>
                        <p>200</p>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-body text-center">
                        <h3 class="uk-card-title">@lang('front/auth.books')</h3>
                        <p>200</p>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-body text-center">
                        <h3 class="uk-card-title">@lang('front/auth.homeworks')</h3>
                        <p>200</p>
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
                    <div class="uk-card uk-card-default uk-card-body text-center">
                        <h3 class="uk-card-title">@lang('front/auth.monthly')</h3>
                        <p class="">20000</p>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-body text-center">
                        <h3 class="uk-card-title">@lang('front/auth.yearly')</h3>
                        <p>20000</p>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-body text-center">
                        <h3 class="uk-card-title">@lang('front/auth.total')</h3>
                        <p>20000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--total student counts, instructor point, total comment counts-->
    <div class="uk-container">
        <div class="uk-child-width-1-3@m uk-card-body uk-grid-small uk-grid-divider uk-grid-match" uk-grid>
            <div>
                <h3 class="uk-heading-line uk-text-center"><span> @lang('front/auth.instructor_point') </span></h3>
                <div class="uk-card uk-card-default uk-card-body text-center">
                    <h3 class="uk-card-title">Primary</h3>
                    <p>20000</p>
                </div>
            </div>
            <div>
                <h3 class="uk-heading-line uk-text-center"><span> @lang('front/auth.total_student_count') </span></h3>
                <div class="uk-card uk-card-default uk-card-body text-center">
                    <h3 class="uk-card-title">Default</h3>
                    <p class="">20000</p>
                </div>
            </div>
            <div>
                <h3 class="uk-heading-line uk-text-center"><span> @lang('front/auth.total_comment_count') </span></h3>
                <div class="uk-card uk-card-default uk-card-body text-center">
                    <h3 class="uk-card-title">Primary</h3>
                    <p>20000</p>
                </div>
            </div>
        </div>
    </div>
@endsection
