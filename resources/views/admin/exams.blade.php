@extends('layouts.admin_panel')
@section('content')
    <exams-page
        add-lesson-text="@lang('front/auth.add_lesson')"
        no-content-text="@lang('front/auth.no_content')"
        delete-text="@lang('front/auth.delete')"
        activate-text="@lang('front/auth.activate')"
        deactivate-text="@lang('front/auth.deactivate')"
        edit-text="@lang('front/auth.edit')"
        save-text="@lang('front/auth.save')"
        cancel-text="@lang('front/auth.cancel')"
        edit-lesson-text="@lang('front/auth.edit_lesson')"
        lesson-name-text="@lang('front/auth.lesson_name')"
        icon-text="@lang('front/auth.icon')"
        select-icon-text="@lang('front/auth.select_icon')"
    ></exams-page>
@endsection
