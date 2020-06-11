@extends('layouts.app')
@section('content')
    <purchase-history-page
        user-id="{{Auth::user()->id}}"
    ></purchase-history-page>
@endsection
