@extends('layouts.admin_panel')
@section('content')
    <div class="uk-margin-medium-top">
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <h2>@lang('front/auth.cookies_policy')</h2>
            <form method="POST" action="{{route('admin_contract_post')}}">
                <div class="uk-flex align-items-center ">
                    <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-width">
                        <input id="cookies" type="file" accept="application/pdf,application/vnd.ms-excel" required>
                        <input class="uk-input" type="text" tabindex="-1" placeholder="@lang('front/auth.select_file')" disabled>
                    </div>
                    <button class="uk-button uk-button-secondary">@lang('front/auth.save')</button>
                </div>
            </form>
        </div>
    </div>
@endsection
