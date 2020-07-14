@extends('layouts.admin_panel')
@section('content')
    <courses-page
        user-id="{{Auth::user()->id}}"
    ></courses-page>
@endsection
