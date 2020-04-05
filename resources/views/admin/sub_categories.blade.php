@extends('layouts.admin_panel')
@section('content')
    <sub-categories-page
        default-image-path="{{asset('images/courses/course-1.jpg')}}"
        categories-route="{{route('adminCategories')}}"
        selected-category-id="{{$data['categoryId']}}"
    ></sub-categories-page>
@endsection
