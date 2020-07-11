@extends('layouts.admin_panel')
@section('content')
    <promotion-payment-page
        user-id="{{Auth::user()->id}}"
    ></promotion-payment-page>
@endsection
