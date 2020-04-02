@extends('layouts.admin_panel')
@section('content')
    <categories-page
        sub-categories-route="{{route('admindistricts')}}"
    > </categories-page>
@endsection
