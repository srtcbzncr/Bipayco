@extends('layouts.admin')
@section('content')
    <div class="uk-container uk-margin-medium-top">
        <div class="uk-card uk-card-default">
            <div class="uk-card-header">
                <a href="{{route('questionSource_show')}}" class="uk-margin-remove"><i class="fas fa-arrow-alt-circle-left"></i> @lang('front/auth.back')</a>
                <h4 class="uk-margin-medium-top">@lang('front/auth.create_new_question')</h4>
            </div>
            <div class="uk-card-body uk-padding-medium">
                <add-question
                    instructor-id="{{Auth::user()->instructor->id}}"
                    save-text="@lang('front/auth.save')"
                    question-type-text="@lang('front/auth.question_type')"
                    choose-question-type-text="@lang('front/auth.choose_question_type')"
                    single-choice-text="@lang('front/auth.single_choice')"
                    multi-choice-text="@lang('front/auth.multi_choice')"
                    fill-blank-text="@lang('front/auth.fill_in_the_blank')"
                    question-source-route="{{route('questionSource_show')}}"
                > </add-question>
            </div>
        </div>
    </div>
@endsection
