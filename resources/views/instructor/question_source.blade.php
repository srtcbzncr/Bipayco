@extends('layouts.admin')
@section('content')
    <div class="uk-container uk-margin-medium-top">
        <div>
            <a href="{{route('questionSource_create')}}" class="uk-button uk-button-success uk-width">
                <i class="fas fa-plus uk-margin-small-right"> </i>
                @lang('front/auth.create_new_question')
            </a>
        </div>
        <question-source-list
            user-id="{{Auth::user()->id}}"
            question-text="@lang('front/auth.question')"
            lesson-text="@lang('front/auth.lesson')"
            difficulty-text="@lang('front/auth.difficulty')"
            edit-text="@lang('front/auth.edit')"
            delete-text="@lang('front/auth.delete')"
        > </question-source-list>
    </div>
@endsection
