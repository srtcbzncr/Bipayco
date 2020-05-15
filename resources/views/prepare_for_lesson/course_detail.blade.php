@extends('layouts.app')
@section('content')
    <div class="course-dhashboard topic{{rand(1,10)}}" style="margin-top: -80px">
        <div uk-grid>
            <div class="uk-width-1-2@m uk-padding-remove-left uk-visible@m">
                <div class="course-video-demo uk-position-relative">
                    <div class="video-responsive">
                        <div class="uk-cover-container">
                            <img src="{{$course->image}}" alt="" uk-cover>
                            <canvas width="600" height="400"></canvas>
                        </div>
                        <!--<iframe src="#" class="uk-padding-remove" uk-video="automute: true" frameborder="0" allowfullscreen uk-responsive></iframe>-->
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

                <stars-rating :rating="{{$course->point}}" style-full-star-color="#F4C150" style-rate-color="color:#C1C1C1" style-empty-star-color="#C1C1C1"></stars-rating>
                <!-- students images  -->
                <div class="avatar-group uk-margin uk-margin-remove-top" uk-scrollspy="target: > img; cls:uk-animation-slide-right; delay: 200">
                    @foreach($entries as $entry)
                        <img src="{{$entry->student->user->avatar}}">
                    @endforeach
                    <span class="uk-text-bold uk-light"> {{$student_count}} @lang('front/auth.enrolled_student')</span>
                </div>
                @if(Auth::check() && Auth::user()->can('entryControl', $course))
                    <div class="uk-grid-small" uk-grid>
                        <div class="uk-width-auto">
                            <a class="uk-button uk-button-white uk-float-left" href="{{route('learn_pl_course_get', $course->id)}}"> @lang('front/auth.continue')</a>
                        </div>
                        <div class="uk-width-expand">
                            <span class="uk-light uk-text-small uk-text-bold"> @lang('front/auth.my_progress') </span>
                            <progress id="js-progressbar" class="uk-progress progress-green uk-margin-small-bottom uk-margin-small-top" value="{{$course->progress}}" max="100" style="height: 8px;"> </progress>
                        </div>
                    </div>
                @else
                    <add-cart-button
                        module-name="prepareLessons"
                        module="pl"
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
            <a href="#" class="tablinks" onclick="openTabs(event, 'Course-Videos')"> <!--<span class="uk-visible@m"> Kurs </span>-->  @lang('front/auth.videos_course') </a>
        </li>
        <li>
            <a href="#" class="tablinks" onclick="openTabs(event, 'Reviews')"> @lang('front/auth.reviews') </a>
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
                            <p>@lang('front/auth.have_no_achievement')</p>
                        @endforelse
                    </ul>
                </div>
                <!-- Course-Videos tab  -->

                <course-previews
                    course-id="{{$course->id}}"
                    module-name="prepareLessons"
                    :sections="{{$course->sections}}"
                    preview-text="@lang('front/auth.preview')"
                    no-content-text="@lang('front/auth.no_content')"
                    section-text="@lang('front/auth.section')"
                ></course-previews>
                <!-- Reviews  -->
                <div id="Reviews" class="tabcontent animation: uk-animation-slide-right-medium">
                    <h3 style="tab-index: 1">@lang('front/auth.reviews')</h3>
                    @if(Auth::check() && Auth::user()->can('comment', $course))
                        <review
                            module-name="prepareLessons"
                            course-id="{{$course->id}}"
                            user-id="{{Auth::user()->id}}"
                            send-text="@lang('front/auth.send')"
                            comment-text="@lang('front/auth.comment')"
                        > </review>
                    @endif
                    <div class="uk-margin-medium-top">
                        <course-review
                            @if(Auth::check())
                            user-id="{{Auth::user()->id}}"
                            @endif
                            module-name="prepareLessons"
                            course-id="{{$course->id}}"
                            :review-count="{{$course->commentCount()}}"
                            :paginate-review="10"
                        ></course-review>
                    </div>
                </div>
                <!-- Instructor  -->
                <div id="Instructor" class="tabcontent animation: uk-animation-slide-right-medium">
                    <h2 class="uk-heading-line uk-text-center"><span> @lang('front/auth.meet_instructor')  </span></h2>
                    @foreach($course->instructors as $instructor)
                        <div class="uk-grid-small  uk-margin-medium-top uk-padding-small" uk-grid>
                            <div class="uk-width-1-4@m uk-first-column">
                                <a href="{{route('instructor_profile', $instructor->id)}}">
                                    <img src="{{asset($instructor->user->avatar)}}" class="uk-margin uk-height-small uk-width-small uk-border-circle">
                                </a>
                                <div class="uk-text-small uk-margin-small-top">
                                    <p> <i class="fas fa-play"></i> {{$instructor->courseCount()}} @lang('front/auth.course') </p>
                                </div>
                            </div>
                            <div class="uk-width-3-4@m uk-padding-remove-left">
                                <h4 class="uk-margin-remove"> {{$instructor->user->first_name}} {{$instructor->user->last_name}} </h4>
                                <span class="uk-text-small">  {{$instructor->title}} </span>
                                <hr class="uk-margin-small">
                                <p class="uk-margin-remove-top uk-margin-small-bottom">{{$instructor->bio}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- side contant -->
                <similar-course-card
                    @if(Auth::check())
                    auth-check
                    user-id="{{Auth::user()->id}}"
                    @endif
                    course-id="{{$course->id}}"
                    module-name="prepareLessons"
                    module="pl"
                    related-courses-text="@lang('front/auth.related_courses')"
                > </similar-course-card>
        </div>
    </div>
@endsection

