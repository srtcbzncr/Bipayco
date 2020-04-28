@extends('layouts.app')
@section('content')
    <div class="uk-container">
        <div class="uk-flex align-items-center">
            <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin" uk-grid>
                <div class="uk-card-media-left uk-cover-container">
                    <img src="images/light.jpg" alt="" uk-cover>
                    <canvas width="600" height="400"></canvas>
                </div>
                <div>
                    <div class="uk-card-body">
                        <h3 class="uk-card-title">Media Left</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>

                    </div>
                </div>
            </div>
            <i class="fas fa-trash-alt text-danger"></i>
        </div>
    </div>
@endsection
