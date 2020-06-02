@extends('layouts.app')
@section('content')
    <search-page
        @if(Auth::check())
            user-id="{{Auth::user()->id}}"
        @endif
    ></search-page>
@endsection
