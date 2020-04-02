@extends('layouts.admin_panel')
@section('content')
    <subject-page
        lessons-route="{{route('adminLesson')}}"
    ></subject-page>
@endsection
