@extends('layouts.admin')
@section('content')
    <questions-page
        user-id="{{Auth::user()->id}}"
    ></questions-page>
@endsection
