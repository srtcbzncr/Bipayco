@extends('layouts.admin_panel')
@section('content')
    <sales-page
        user-id="{{Auth::user()->id}}"
    ></sales-page>
@endsection
