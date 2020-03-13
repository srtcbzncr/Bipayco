@extends('layouts.admin')
@section('content')
    <div class="uk-container uk-margin-medium-top">
        <div>
            <a href="{{route('questionSource_create')}}" class="uk-button uk-button-success uk-width">
                <i class="fas fa-plus uk-margin-small-right"> </i>
                @lang('front/auth.create_new_question')
            </a>
        </div>
    </div>
@endsection
