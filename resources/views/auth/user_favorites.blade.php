@extends('layouts.app')
@section('content')
    <favorites-paginate
        favorites-text="@lang('front/auth.favorites')"
        has-no-content-text="@lang('front/auth.have_no_favorite')"
        user-id="{{Auth::user()->id}}"
    ></favorites-paginate>
@endsection
