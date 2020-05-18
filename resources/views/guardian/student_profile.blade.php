@extends('layouts.guardian_panel')
@section('content')
    <student-profile-page
        user-id="{{Auth::user()->id}}"
    ></student-profile-page>
@endsection
