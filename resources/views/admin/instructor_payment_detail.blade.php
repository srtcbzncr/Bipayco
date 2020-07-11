@extends('layouts.admin_panel')
@section('content')
    <instructor-payment-detail-page
        user-id="{{Auth::user()->id}}"
        :selected-instructor="{{$instructor}}"
        promotion-payment-route="{{route('admin_instructorsFeeWithReferenceCode')}}"
    ></instructor-payment-detail-page>
@endsection
