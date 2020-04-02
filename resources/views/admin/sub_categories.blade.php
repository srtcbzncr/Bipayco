@extends('layouts.admin_panel')
@section('content')
    <sub-categories-page
        categories-route="{{route('adminCategories')}}"
    ></sub-categories-page>
@endsection
