@extends('layouts.app')
@section('content')
    <div>
        <!-- lesson view area -->
        <div class="uk-margin-left uk-margin-right uk-margin-top uk-margin-bottom uk-margin-medium-bottom">
            <watch
                course-id="{{$course->id}}"
                first-lesson-id="{{$course->sections[0]->lessons[0]->id}}"
            > </watch>
        </div>
        <!-- Q & A area -->
        <h3 class="uk-heading-line uk-text-center"><span>Soru Cevap</span></h3>
        <div>
            <div class="uk-container">
                <textarea class="uk-textarea uk-width uk-height-small" style="resize:none;" placeholder="@lang('front/auth.ask_a_question')" id="questionArea" > </textarea>
                <button  class="uk-button uk-button-primary uk-margin-small-top uk-float-right "> @lang('front/auth.send') </button>
            </div>
        </div>
    @for($i = 0; $i < 10; $i++)
        <div class="uk-container uk-margin-top">
            <div class="uk-card uk-padding-small uk-card-default">
                <div class="uk-card-body uk-padding-small uk-flex align-items-center">
                    <div class="uk-width-1-6@m uk-visible@m justify-content-center">
                        <img class="uk-border-circle " src="{{asset(Auth::user()->avatar)}}" style="width: 125px; height:125px;">
                    </div>
                    <div class="uk-grid-stack uk-width-5-6@m">
                        <h4 class="uk-margin-remove">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h4>
                        <hr class="uk-margin-small-bottom uk-margin-small-top">
                        <p class="uk-margin-remove">
                            yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum
                            yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum
                            yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum
                            yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum
                            yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum
                            yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum
                            yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum
                        </p>
                    </div>
                </div>
            </div>
            <div uk-grid>
                <div class="uk-width-1-6"></div>
                <div class="uk-card uk-card-primary uk-padding-small uk-width-5-6">
                    <div class="uk-card-body uk-padding-small uk-flex align-items-center">
                        <div class="uk-width-1-6@m uk-visible@m justify-content-center">
                            <img class="uk-border-circle " src="{{asset(Auth::user()->avatar)}}" style="width: 125px; height:125px;">
                        </div>
                        <div class="uk-grid-stack uk-width-5-6@m">
                            <h4 class="uk-margin-remove">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h4>
                            <hr class="uk-margin-small-bottom uk-margin-small-top">
                            <p class="uk-margin-remove">
                                yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum
                                yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum
                                yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum yorum
                                yorum yorum yorum yorum
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>
@endsection
