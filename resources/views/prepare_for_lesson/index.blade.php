@extends('layouts.app')
@section('content')
    <div class="uk-container">
        <div class=" uk-margin-medium-top uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match uk-margin" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div ; delay: 200" uk-grid>
            @foreach($lessons as $lesson)
                <div>
                    <category-card
                        background-color="#3e474f"
                        sub-category-name="{{$lesson->name}}"
                        explore="@lang('front/auth.explore')"
                        sub-category-route="{{route('pl_sub_category_courses', $lesson->id)}}"
                        sub-category-img="{{$lesson->symbol}}"
                        course="@lang('front/auth.course')"
                        course-count="{{$lesson->courseCount}}"
                    ></category-card>
                </div>
            @endforeach
        </div>
    </div>
@endsection
