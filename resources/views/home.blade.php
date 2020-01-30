@extends('layouts.app')

@section('content')
    <div src="/images/slider_bg.jpg" style="background-image: url(../images/slider_bg.jpg); margin-top:-70px" uk-img class="uk-height-large uk-background-norepeat  uk-background-center-center uk-section uk-flex uk-flex-bottom uk-background-cover">
        <div class="uk-width-1-1 uk-container uk-margin-large-top uk-margin-large-left ">
            <h1 class="uk-text-bold uk-text-white uk-margin-small-bottom"> Türkiye'nin en büyük <br>  online eğitim platformu</h1>
            <h4 class="uk-text-bold uk-light uk-margin-remove-top"></h4>
            <a class="uk-button tm-button-grey" href="#browse-corses" uk-scroll>
                Keşfet </a>
        </div>
    </div>
    <div class="uk-container">
        <ul uk-tab class="uk-margin-top uk-flex-center">
            <li><a href="#">@lang('front/auth.general_education')</a></li>
            <li><a href="#">@lang('front/auth.prepare_for_exams')</a></li>
            <li><a href="#">@lang('front/auth.prepare_for_lessons')</a></li>
            <li><a href="#">@lang('front/auth.exams')</a></li>
            <li><a href="#">@lang('front/auth.books')</a></li>
        </ul>

        <ul class="uk-switcher uk-margin uk-margin-medium-top">
            <li>
                @if($general_education === null || count($general_education) === 0)
                    <div class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                        <h4 class="uk-text-bold uk-margin-remove-top">@lang('front/auth.not_found_content')</h4>
                    </div>
                @else
                    <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match uk-margin" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div ; delay: 200" uk-grid>
                        @foreach($general_education as $general_educations)
                            <div>
                                <course-card
                                    title="{{$general_educations->name}}"
                                    description="{{$general_educations->description}}"
                                    img-path="{{asset($general_educations->image)}}"
                                    @if($general_educations->price!=$general_educations->price_with_discount)
                                    discount
                                    :current-price="{{$general_educations->price_with_discount}}"
                                    :prev-price="{{$general_educations->price}}"
                                    @else
                                    :current-price="{{$general_educations->price}}"
                                    @endif
                                    :rate="{{$general_educations->point}}"
                                    page-link="{{route('ge_course', $general_educations->id)}}"
                                    style-full-star-color="#F4C150"
                                    style-empty-star-color="#C1C1C1"
                                ></course-card>
                            </div>
                        @endforeach
                    </div>
                    <div class="uk-grid">
                        <span class="uk-width-1-4"></span>
                        <a href="{{route('ge_index')}}" class="uk-button uk-button-grey uk-width-1-2">@lang('front/auth.see_more')</a>
                        <span class="uk-width-1-4"></span>
                    </div>
                @endif
            </li>
            <li>
                @if($prepare_for_exams === null || count($prepare_for_exams) === 0)
                    <div class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                        <h4 class="uk-text-bold uk-margin-remove-top">@lang('front/auth.not_found_content')</h4>
                    </div>
                @else
                    <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match uk-margin" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div ; delay: 200" uk-grid>
                        @foreach ($prepare_for_exams as $prepare_for_exam)
                            <div>
                                <course-card
                                    title="{{$prepare_for_exam->name}}"
                                    description="{{$prepare_for_exam->description}}"
                                    img-path="{{asset($prepare_for_exam->image)}}"
                                    @if($prepare_for_exam->price!=$prepare_for_exam->price_with_discount)
                                    discount
                                    :current-price="{{$prepare_for_exam->price_with_discount}}"
                                    :prev-price="{{$prepare_for_exam->price}}"
                                    @else
                                    :current-price="{{$prepare_for_exam->price}}"
                                    @endif
                                    :rate="{{$prepare_for_exam->point}}"
                                    page-link="{{route('ge_course',$prepare_for_exam->id)}}"
                                ></course-card>
                            </div>
                        @endforeach
                    </div>
                    <div class="uk-grid">
                        <span class="uk-width-1-4"></span>
                        <a href="#" class="uk-button uk-button-grey uk-width-1-2">@lang('front/auth.see_more')</a>
                        <span class="uk-width-1-4"></span>
                    </div>
                @endif
            </li>
            <li>
                @if($prepare_for_lessons === null || count($prepare_for_lessons) === 0)
                    <div class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                        <h4 class="uk-text-bold uk-margin-remove-top">@lang('front/auth.not_found_content')</h4>
                    </div>
                @else
                    <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match uk-margin" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div ; delay: 200" uk-grid>
                        @foreach ($prepare_for_lessons as $prepare_for_lesson)
                            <div>
                                <course-card
                                    title="{{$prepare_for_lesson->name}}"
                                    description="{{$prepare_for_lesson->description}}"
                                    img-path="{{asset($prepare_for_lesson->image)}}"
                                    @if($prepare_for_lesson->price!=$prepare_for_lesson->price_with_discount)
                                    discount
                                    :current-price="{{$prepare_for_lesson->price_with_discount}}"
                                    :prev-price="{{$prepare_for_lesson->price}}"
                                    @else
                                    :current-price="{{$prepare_for_lesson->price}}"
                                    @endif
                                    :rate="{{$prepare_for_lesson->point}}"
                                    page-link="{{route('ge_course',$prepare_for_lesson->id)}}"
                                ></course-card>
                            </div>
                        @endforeach
                    </div>
                    <div class="uk-grid">
                        <span class="uk-width-1-4"></span>
                        <a href="{{route('ge_index')}}" class="uk-button uk-button-grey uk-width-1-2">@lang('front/auth.see_more')</a>
                        <span class="uk-width-1-4"></span>
                    </div>
                @endif
            </li>
            <li>
                @if($exams===null || count($exams) === 0)
                    <div class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                        <h4 class="uk-text-bold uk-margin-remove-top">@lang('front/auth.not_found_content')</h4>
                    </div>
                @else
                    <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match uk-margin" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div ; delay: 200" uk-grid>
                        @foreach($exams as $exam)
                            <div>
                                <course-card
                                    title="{{$exam->name}}"
                                    description="{{$exam->description}}"
                                    img-path="{{asset($exam->image)}}"
                                    @if($exam->price!=$exam->price_with_discount)
                                    discount
                                    :current-price="{{$exam->price_with_discount}}"
                                    :prev-price="{{$exam->price}}"
                                    @else
                                    :current-price="{{$exam->price}}"
                                    @endif
                                    :rate="{{$exam->point}}"
                                    page-link="{{route('ge_course',$exam->id)}}"
                                ></course-card>
                            </div>
                        @endforeach
                    </div>
                    <div class="uk-grid">
                        <span class="uk-width-1-4"></span>
                        <a href="{{route('ge_index')}}" class="uk-button uk-button-grey uk-width-1-2">@lang('front/auth.see_more')</a>
                        <span class="uk-width-1-4"></span>
                    </div>
                @endif
            </li>
            <li>
                @if($books===null || count($books)===0)
                    <div class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                        <h4 class="uk-text-bold uk-margin-remove-top">@lang('front/auth.not_found_content')</h4>
                    </div>
                @else
                    <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match uk-margin" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: > div ; delay: 200" uk-grid>
                        @foreach ($books as $book)
                            <div>
                                <course-card
                                    title="{{$book->name}}"
                                    description="{{$book->description}}"
                                    img-path="{{asset($book->image)}}"
                                    @if($book->price!=$book->price_with_discount)
                                    discount
                                    :current-price="{{$book->price_with_discount}}"
                                    :prev-price="{{$book->price}}"
                                    @else
                                    :current-price="{{$book->price}}"
                                    @endif
                                    :rate="{{$book->point}}"
                                    page-link="{{route('ge_course',$book->id)}}"
                                ></course-card>
                            </div>
                        @endforeach
                    </div>
                    <div class="uk-grid">
                        <span class="uk-width-1-4"></span>
                        <a href="{{route('ge_index')}}" class="uk-button uk-button-grey uk-width-1-2">@lang('front/auth.see_more')</a>
                        <span class="uk-width-1-4"></span>
                    </div>
                @endif
            </li>
        </ul>
    </div>
@endsection
