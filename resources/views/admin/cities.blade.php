@extends('layouts.admin_panel')
@section('content')
    <cities-page
        districts-route="{{route('adminDistricts')}}"
    ></cities-page>
@endsection
