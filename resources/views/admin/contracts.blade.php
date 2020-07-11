@extends('layouts.admin_panel')
@section('content')
    <div class="uk-margin-medium-top">
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <h3>@lang('front/auth.cookies_policy')</h3>
            <form method="POST" action="{{route('admin_contract_post')}}">
                @csrf
                <div class="uk-flex uk-flex-wrap align-items-center ">
                    <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-width-1-2@m">
                        <input id="cookies" name="cookies_policy" type="file" accept="application/pdf,application/vnd.ms-excel" required>
                        <input class="uk-input" type="text" tabindex="-1" placeholder="@lang('front/auth.select_file')" disabled>
                    </div>
                    <button class="uk-button uk-button-secondary uk-width-1-6@m">@lang('front/auth.save')</button>
                </div>
            </form>
        </div>
    </div>
@endsection
