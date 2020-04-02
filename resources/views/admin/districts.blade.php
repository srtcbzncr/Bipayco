@extends('layouts.admin_panel')
@section('content')
    <districts-page
        cities-route="{{route('adminCities')}}"
    ></districts-page>
@endsection
