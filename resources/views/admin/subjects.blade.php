@extends('layouts.admin_panel')
@section('content')
    <subject-page
        lessons-route="{{route('adminLesson')}}"
        selected-lesson-id="{{$data['lessonId']}}"
    ></subject-page>
@endsection
