@extends('layouts.app')
@section('content')
    <div class="course-dhashboard topic{{rand(1,10)}}" style="margin-top: -80px">
        <div uk-grid>
            <div class="uk-width-1-2@m uk-padding-remove-left uk-visible@m">
                <div class="course-video-demo uk-position-relative">
                    <div class="uk-cover-container">
                        <img src="{{$course->image}}" alt="" uk-cover>
                        <canvas width="600" height="400"></canvas>
                    </div>
                    <!--  Local video
                    <video loop muted playsinline controls uk-video="autoplay: inview">
                        <source src="videos/course-intro.mp4" type="video/mp4">
                    </video>
                    -->
                </div>
            </div>
            <div class="uk-width-1-2@m uk-padding uk-margin-medium-top">
                <h2 class="uk-light uk-text-uppercase uk-text-bold uk-text-white"> {{$course->name}} </h2>
                <!-- students images  -->
                <div class="avatar-group uk-margin uk-margin-remove-top" uk-scrollspy="target: > img; cls:uk-animation-slide-right; delay: 200">
                    @foreach($entries as $entry)
                        <img src="{{$entry->student->user->avatar}}">
                    @endforeach
                    <span class="uk-text-bold uk-light"> {{$student_count}} @lang('front/auth.enrolled_student')</span>
                </div>
                @if(Auth::check() && Auth::user()->can('entryControl', $course))
                    <live-stream-button
                        open-stream-text="@lang('front/auth.open_live_stream')"
                        stream-password-text="@lang('front/auth.live_stream_password')"
                        user-id="{{Auth::user()->id}}"
                        course-id="{{$course->id}}"
                    ></live-stream-button>
                @else
                    <add-cart-button
                        module-name="live"
                        module="live"
                        @if(Auth::check())
                        user-id="{{Auth::user()->id}}"
                        is-login
                        @endif
                        @if($course->inBasket)
                        in-cart
                        @endif
                        login-route="{{route('loginGet')}}"
                        add-cart-text="@lang('front/auth.add_cart')"
                        remove-cart-text="@lang('front/auth.remove_cart')"
                        course-id="{{$course->id}}"
                    > </add-cart-button>
                @endif
            </div>
        </div>
    </div>
    <ul class="uk-child-width-expand course-dhashboard-subnav" uk-tab>
        <li class="uk-active">
            <a class="tablinks" onclick="openTabs(event, 'Description')"> @lang('front/auth.description')  </a>
        </li>
        <li>
            <a href="#" class="tablinks" onclick="openTabs(event, 'Instructor')"> @lang('front/auth.instructor') </a>
        </li>
    </ul>
    <div class="uk-padding-large uk-padding-remove-top tm-hero">
        <div uk-grid>
            <!-- page contant -->
            <div class="uk-width-2-3@m uk-first-column">
                <!-- Discription tab  -->
                <div id="Description" class="tabcontent tab-default-open animation: uk-animation-slide-right-medium">
                    <h3> @lang('front/auth.about_this_course')</h3>
                    <p>{{$course->description}}</p>
                    <h4> @lang('front/auth.requirements')</h4>
                    <ul class="uk-list uk-list-bullet">
                        @forelse($course->requirements as $requirement)
                                <li>{{$requirement->content}}</li>
                        @empty
                            <p>@lang('front/auth.have_no_requirement')</p>
                        @endforelse
                    </ul>
                    <h4>  @lang('front/auth.achievements')</h4>
                    <ul class="uk-list uk-list-bullet">
                        @forelse($course->achievements as $achievement)
                            <li>{{$achievement->content}}</li>
                        @empty
                            <p>@lang('front/auth.have_no_requirement')</p>
                        @endforelse
                    </ul>
                </div>
                <!-- Instructor  -->
                <div id="Instructor" class="tabcontent animation: uk-animation-slide-right-medium">
                    <h2 class="uk-heading-line uk-text-center"><span> @lang('front/auth.meet_instructor')  </span></h2>
                    <div class="uk-grid-small  uk-margin-medium-top uk-padding-small" uk-grid>
                        <div class="uk-width-1-4@m uk-first-column">
                            <a href="{{route('instructor_profile', $course->instructor->id)}}">
                                <img src="{{asset($course->instructor->user->avatar)}}" class="uk-margin uk-height-small uk-width-small uk-border-circle">
                            </a>
                            <div class="uk-text-small uk-margin-small-top">
                                <p> <i class="fas fa-play"></i> {{$course->instructor->courseCount()}} @lang('front/auth.course') </p>
                            </div>
                        </div>
                        <div class="uk-width-3-4@m uk-padding-remove-left">
                            <h4 class="uk-margin-remove"> {{$course->instructor->user->first_name}} {{$course->instructor->user->last_name}} </h4>
                            <span class="uk-text-small">  {{$course->instructor->title}} </span>
                            <hr class="uk-margin-small">
                            <p class="uk-margin-remove-top uk-margin-small-bottom">{{$course->instructor->bio}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- side contant -->
            <similar-course-card
                @if(Auth::check())
                auth-check
                user-id="{{Auth::user()->id}}"
                @endif
                course-id="{{$course->id}}"
                module-name="live"
                module="live"
                related-courses-text="@lang('front/auth.related_courses')"
            > </similar-course-card>
        </div>
    </div>
@endsection

