@extends('layouts.admin_panel')
@section('content')
    <lesson-page
        subjects-route="{{route('adminSubjects')}}"
    ></lesson-page>
@endsection
