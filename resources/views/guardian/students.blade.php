@extends('layouts.guardian_panel')
@section('content')
<students-page
    user-id="{{Auth::user()->id}}"
> </students-page>
@endsection
