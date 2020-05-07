@extends('layouts.app')
@section('content')
    <div class="uk-container">
        <div class=" uk-margin-medium-top uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match uk-margin" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div ; delay: 200" uk-grid>
            @foreach($exams as $exam)
                <div>
                    <category-card
                        background-color="#3b8895"
                        sub-category-name="{{$exam->name}}"
                        explore="@lang('front/auth.explore')"
                        sub-category-route="{{route('pe_sub_category_courses', $exam->id)}}"
                        sub-category-img="{{$exam->symbol}}"
                        course="@lang('front/auth.course')"
                        course-count="{{$exam->courseCount}}"
                    ></category-card>
                </div>
            @endforeach
        </div>
    </div>
@endsection
