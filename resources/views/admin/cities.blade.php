@extends('layouts.admin_panel')
@section('content')
    <cities-page
        districts-route="{{route('admindistricts')}}"
    ></cities-page>
@endsection