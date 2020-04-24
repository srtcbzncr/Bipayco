@extends('layouts.app')
@section('content')
    <div class="uk-container">
        <ul class="uk-switcher uk-margin-medium-top">
            @foreach($lessons as $lesson)
                <li>
                    <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match uk-margin" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div ; delay: 200" uk-grid>
                        <div>
                            <category-card
                                background-color="{{$lesson->color}}"
                                sub-category-name="{{$lesson->name}}"
                                sub-category-desc="{{$lesson->description}}"
                                explore="@lang('front/auth.explore')"
                                sub-category-route="{{route('pl_sub_category_courses', $lesson->id)}}"
                                sub-category-img="{{$lesson->image}}"
                                course="@lang('front/auth.course')"
                                course-count="{{$lesson->courseCount()}}"
                            ></category-card>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
