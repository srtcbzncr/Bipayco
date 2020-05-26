@extends('layouts.app')
@section('content')
    <favorites-paginate
        favorites-text="@lang('front/auth.favorites')"
        user-id="{{Auth::user()->id}}"
    ></favorites-paginate>
@endsection
