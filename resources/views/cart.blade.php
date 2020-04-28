@extends('layouts.app')
@section('content')
    <div class="uk-container uk-margin-medium-top">
        <cart-page
            user-id="{{Auth::user()->id}}"
        ></cart-page>
    </div>
@endsection
