@extends('layouts.admin_panel')
@section('content')
    <categories-page
        sub-categories-route="{{route('adminSubCategories')}}"
    > </categories-page>
@endsection
