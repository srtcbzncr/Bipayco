@extends('layouts.admin_panel')
@section('content')
    <sub-categories-page
        categories-route="{{route('adminCategories')}}"
        selected-category-id="{{$data['categoryId']}}"
    ></sub-categories-page>
@endsection
