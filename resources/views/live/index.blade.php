@extends('layouts.app')
@section('content')
    <div class="uk-container">
        <div class=" uk-margin-medium-top uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match uk-margin" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div ; delay: 200" uk-grid>
            @foreach($lives as $live)
                <div>
                    <category-card
                        background-color="#3b8895"
                        sub-category-name="{{$live->name}}"
                        explore="@lang('front/auth.explore')"
                        sub-category-route="{{route('pe_sub_category_courses', $live->id)}}"
{{--                        sub-category-img="{{$exam->symbol}}"--}}
                        course="@lang('front/auth.course')"
                        course-count="{{$live->courseCount}}"
                    ></category-card>
                </div>
            @endforeach
        </div>
    </div>
@endsection
