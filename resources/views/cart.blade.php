@extends('layouts.app')
@section('content')
    <div class="uk-container uk-margin-medium-top">
        <cart-page
            user-id="{{Auth::user()->id}}"
            invoice-info-route="{{route('iyzico_billing')}}"
        ></cart-page>
    </div>
@endsection
