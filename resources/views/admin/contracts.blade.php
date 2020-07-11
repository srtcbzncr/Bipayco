@extends('layouts.admin_panel')
@section('content')
    <div class="uk-margin-medium-top">
        <div class="uk-background-default uk-padding uk-margin-small-top border-radius-6">
            <h3>@lang('front/auth.who_we_are')</h3>
            <form method="POST" action="{{route('admin_contract_post')}}" enctype="multipart/form-data">
                @csrf
                <div class="uk-flex uk-flex-wrap align-items-center ">
                    <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin-small-top uk-margin-small-right uk-width-1-2@m">
                        <input id="who_we_are" name="who_we_are" type="file" accept="application/pdf,application/vnd.ms-excel" required>
                        <input class="uk-input" type="text" tabindex="-1" placeholder="@lang('front/auth.select_file')" disabled>
                    </div>
                    <button class="uk-button uk-button-primary uk-padding-small uk-padding-remove-vertical uk-margin-small-top uk-margin-small-right uk-width-1-6@m" type="submit">@lang('front/auth.save')</button>
                </div>
            </form>
            <h3>@lang('front/auth.pre_information_form')</h3>
            <form method="POST" action="{{route('admin_contract_post')}}" enctype="multipart/form-data">
                @csrf
                <div class="uk-flex uk-flex-wrap align-items-center ">
                    <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin-small-top uk-margin-small-right uk-width-1-2@m">
                        <input id="pre_information_form" name="pre_information_form" type="file" accept="application/pdf,application/vnd.ms-excel" required>
                        <input class="uk-input" type="text" tabindex="-1" placeholder="@lang('front/auth.select_file')" disabled>
                    </div>
                    <button class="uk-button uk-button-primary uk-padding-small uk-padding-remove-vertical uk-margin-small-top uk-margin-small-right uk-width-1-6@m" type="submit">@lang('front/auth.save')</button>
                </div>
            </form>
            <h3>@lang('front/auth.frequently_asked_questions')</h3>
            <form method="POST" action="{{route('admin_contract_post')}}" enctype="multipart/form-data">
                @csrf
                <div class="uk-flex uk-flex-wrap align-items-center ">
                    <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin-small-top uk-margin-small-right uk-width-1-2@m">
                        <input id="faq" name="faq" type="file" accept="application/pdf,application/vnd.ms-excel" required>
                        <input class="uk-input" type="text" tabindex="-1" placeholder="@lang('front/auth.select_file')" disabled>
                    </div>
                    <button class="uk-button uk-button-primary uk-padding-small uk-padding-remove-vertical uk-margin-small-top uk-margin-small-right uk-width-1-6@m" type="submit">@lang('front/auth.save')</button>
                </div>
            </form>
            <h3>@lang('front/auth.cookies_policy')</h3>
            <form method="POST" action="{{route('admin_contract_post')}}" enctype="multipart/form-data">
                @csrf
                <div class="uk-flex uk-flex-wrap align-items-center ">
                    <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin-small-top uk-margin-small-right uk-width-1-2@m">
                        <input id="cookies" name="cookies_policy" type="file" accept="application/pdf,application/vnd.ms-excel" required>
                        <input class="uk-input" type="text" tabindex="-1" placeholder="@lang('front/auth.select_file')" disabled>
                    </div>
                    <button class="uk-button uk-button-primary uk-padding-small uk-padding-remove-vertical uk-margin-small-top uk-margin-small-right uk-width-1-6@m" type="submit">@lang('front/auth.save')</button>
                </div>
            </form>
            <h3>@lang('front/auth.subscription_contract')</h3>
            <form method="POST" action="{{route('admin_contract_post')}}" enctype="multipart/form-data">
                @csrf
                <div class="uk-flex uk-flex-wrap align-items-center ">
                    <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin-small-top uk-margin-small-right uk-width-1-2@m">
                        <input id="subscription" name="subscription" type="file" accept="application/pdf,application/vnd.ms-excel" required>
                        <input class="uk-input" type="text" tabindex="-1" placeholder="@lang('front/auth.select_file')" disabled>
                    </div>
                    <button class="uk-button uk-button-primary uk-padding-small uk-padding-remove-vertical uk-margin-small-top uk-margin-small-right uk-width-1-6@m" type="submit">@lang('front/auth.save')</button>
                </div>
            </form>
            <h3>@lang('front/auth.sales_contract')</h3>
            <form method="POST" action="{{route('admin_contract_post')}}" enctype="multipart/form-data">
                @csrf
                <div class="uk-flex uk-flex-wrap align-items-center ">
                    <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin-small-top uk-margin-small-right uk-width-1-2@m">
                        <input id="sales" name="sales" type="file" accept="application/pdf,application/vnd.ms-excel" required>
                        <input class="uk-input" type="text" tabindex="-1" placeholder="@lang('front/auth.select_file')" disabled>
                    </div>
                    <button class="uk-button uk-button-primary uk-padding-small uk-padding-remove-vertical uk-margin-small-top uk-margin-small-right uk-width-1-6@m" type="submit">@lang('front/auth.save')</button>
                </div>
            </form>
            <h3>@lang('front/auth.kvkk_illuminate_text')</h3>
            <form method="POST" action="{{route('admin_contract_post')}}" enctype="multipart/form-data">
                @csrf
                <div class="uk-flex uk-flex-wrap align-items-center ">
                    <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin-small-top uk-margin-small-right uk-width-1-2@m">
                        <input id="kvkk_illuminate" name="kvkk_illuminate" type="file" accept="application/pdf,application/vnd.ms-excel" required>
                        <input class="uk-input" type="text" tabindex="-1" placeholder="@lang('front/auth.select_file')" disabled>
                    </div>
                    <button class="uk-button uk-button-primary uk-padding-small uk-padding-remove-vertical uk-margin-small-top uk-margin-small-right uk-width-1-6@m" type="submit">@lang('front/auth.save')</button>
                </div>
            </form>
            <h3>@lang('front/auth.intellectual_property_policy')</h3>
            <form method="POST" action="{{route('admin_contract_post')}}" enctype="multipart/form-data">
                @csrf
                <div class="uk-flex uk-flex-wrap align-items-center ">
                    <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin-small-top uk-margin-small-right uk-width-1-2@m">
                        <input id="intellectual_property_policy" name="intellectual_property_policy" type="file" accept="application/pdf,application/vnd.ms-excel" required>
                        <input class="uk-input" type="text" tabindex="-1" placeholder="@lang('front/auth.select_file')" disabled>
                    </div>
                    <button class="uk-button uk-button-primary uk-padding-small uk-padding-remove-vertical uk-margin-small-top uk-margin-small-right uk-width-1-6@m" type="submit">@lang('front/auth.save')</button>
                </div>
            </form>
            <h3>@lang('front/auth.privacy_terms')</h3>
            <form method="POST" action="{{route('admin_contract_post')}}" enctype="multipart/form-data">
                @csrf
                <div class="uk-flex uk-flex-wrap align-items-center ">
                    <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin-small-top uk-margin-small-right uk-width-1-2@m">
                        <input id="privacy_terms" name="privacy_terms" type="file" accept="application/pdf,application/vnd.ms-excel" required>
                        <input class="uk-input" type="text" tabindex="-1" placeholder="@lang('front/auth.select_file')" disabled>
                    </div>
                    <button class="uk-button uk-button-primary uk-padding-small uk-padding-remove-vertical uk-margin-small-top uk-margin-small-right uk-width-1-6@m" type="submit">@lang('front/auth.save')</button>
                </div>
            </form>
            <h3>@lang('front/auth.term_of_use')</h3>
            <form method="POST" action="{{route('admin_contract_post')}}" enctype="multipart/form-data">
                @csrf
                <div class="uk-flex uk-flex-wrap align-items-center ">
                    <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin-small-top uk-margin-small-right uk-width-1-2@m">
                        <input id="term_of_use" name="term_of_use" type="file" accept="application/pdf,application/vnd.ms-excel" required>
                        <input class="uk-input" type="text" tabindex="-1" placeholder="@lang('front/auth.select_file')" disabled>
                    </div>
                    <button class="uk-button uk-button-primary uk-padding-small uk-padding-remove-vertical uk-margin-small-top uk-margin-small-right uk-width-1-6@m" type="submit">@lang('front/auth.save')</button>
                </div>
            </form>
            <h3>@lang('front/auth.member_obligations')</h3>
            <form method="POST" action="{{route('admin_contract_post')}}" enctype="multipart/form-data">
                @csrf
                <div class="uk-flex uk-flex-wrap align-items-center ">
                    <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin-small-top uk-margin-small-right uk-width-1-2@m">
                        <input id="member_obligations" name="member_obligations" type="file" accept="application/pdf,application/vnd.ms-excel" required>
                        <input class="uk-input" type="text" tabindex="-1" placeholder="@lang('front/auth.select_file')" disabled>
                    </div>
                    <button class="uk-button uk-button-primary uk-padding-small uk-padding-remove-vertical uk-margin-small-top uk-margin-small-right uk-width-1-6@m" type="submit">@lang('front/auth.save')</button>
                </div>
            </form>
        </div>
    </div>
@endsection
