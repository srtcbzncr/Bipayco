@extends('layouts.app')
@section('content')
    <div class="uk-container">
        <ul uk-tab uk-switcher="connect: #subCategories" class="uk-flex-center uk-margin-medium-top">
            @if(count($categories)< 7)
                @foreach($categories as $category)
                    <li class="toggle-link"><a href="#">{{$category->name}}</a></li>
                @endforeach
            @else
                @foreach($categories as $category)
                    @if($loop->index < 5)
                        <li class="toggle-link"><a href="#">{{$category->name}}</a></li>
                    @endif
                @endforeach
                <li>
                    <a href="#">@lang('front/auth.more') <span class="fas fa-angle-down uk-margin-small-left icon-small"></span></a>
                    <div uk-dropdown="mode: click">
                        <ul class="uk-nav uk-dropdown-nav" uk-switcher="connect: #subCategories">
                            @foreach($categories as $category)
                                @if($loop->index >= 5)
                                    <li class="toggle-link"><a href="#">{{$category->name}}</a></li>
                                @else
                                    <li hidden></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </li>
            @endif
        </ul>
        <ul class="uk-switcher uk-margin-medium-top" id="subCategories">
            @foreach($categories as $category)
                <li>
                    <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match uk-margin" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div ; delay: 200" uk-grid>
                        @foreach($category->subCategories as $sub_category)
                            <div>
                                <category-card
                                    background-color="{{$sub_category->color}}"
                                    sub-category-name="{{$sub_category->name}}"
                                    sub-category-desc="{{$sub_category->description}}"
                                    explore="@lang('front/auth.explore')"
                                    sub-category-route="{{route('ge_sub_category_courses', $sub_category->id)}}"
                                    sub-category-img="{{$sub_category->image}}"
                                    course="@lang('front/auth.course')"
                                    course-count="{{$sub_category->courseCount()}}"
                                ></category-card>
                            </div>
                        @endforeach
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
