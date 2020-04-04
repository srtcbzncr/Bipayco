@extends('layouts.admin_panel')
@section('content')
    <districts-page
        cities-route="{{route('adminCities')}}"
        selected-city-id="{{$data['cityId']}}"
    ></districts-page>
@endsection
