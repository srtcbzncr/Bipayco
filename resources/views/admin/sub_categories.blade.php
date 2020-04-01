@extends('layouts.admin_panel')
@section('content')
    <div class="uk-margin-large-top">
        <div class="text-right">
            <button class="uk-button uk-button-success"><i class="fas fa-plus"></i> @lang('front/auth.add_sub_category')</button>
        </div>
        <div class="uk-background-default uk-padding-remove uk-margin-small-top border-radius-6">
            <data-table></data-table>
        </div>
    </div>
@endsection
