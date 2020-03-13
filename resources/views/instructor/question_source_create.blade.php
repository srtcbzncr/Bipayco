@extends('layouts.admin')
@section('content')
    <div class="uk-container uk-margin-medium-top">
        <div class="uk-card uk-card-default">
            <div class="uk-card-header">
                <a href="{{route('questionSource_show')}}" class="uk-margin-remove"><i class="fas fa-arrow-alt-circle-left"></i> @lang('front/auth.back')</a>
                <h4 class="uk-margin-medium-top">@lang('front/auth.create_new_question')</h4>
            </div>
            <div class="uk-card-body uk-padding-medium">
                <div class="">
                    <div class="uk-form-label"> @lang('front/auth.question_type')</div>
                    <select class="uk-width uk-select">
                        <option selected disabled hidden>@lang('front/auth.question_type')</option>
                        <option>@lang('front/auth.single_choice')</option>
                        <option>@lang('front/auth.multi_choice')</option>
                        <option>@lang('front/auth.fill_in_the_blank')</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
@endsection
