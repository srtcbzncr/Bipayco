@extends('layouts.app')
@section('content')
    <div class="course-dhashboard topic{{rand(1,10)}}" style="margin-top: -80px">
        <div uk-grid>
            <div class="uk-width-1-2@m uk-padding-remove-left uk-visible@m">
                <div class="course-video-demo uk-position-relative">
                    <div class="video-responsive">
                        <img src="{{$course->image}}" alt="">
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
                @if(Auth::check() && Auth::user()->can('entry',$course))
                    <div class="uk-grid-small" uk-grid>
                        <div class="uk-width-auto">
                            <a class="uk-button uk-button-white uk-float-left" href="Course-lesson.html" uk-tooltip="title: Star This course now  ; delay: 300 ; pos: top ;animation:	uk-animation-slide-bottom-small"> @lang('front/auth.continue')</a>
                        </div>
                        <div class="uk-width-expand">
                            <span class="uk-light uk-text-small uk-text-bold"> @lang('front/auth.my_progress') </span>
                            <progress id="js-progressbar" class="uk-progress progress-green uk-margin-small-bottom uk-margin-small-top" value="{{$progress}}" max="100" style="height: 8px;"> </progress>
                        </div>
                    </div>
                @else
                    <div class="uk-grid-small" uk-grid>
                        <div class="uk-width-auto">
                            <a class="uk-button uk-button-white uk-float-left" href="Course-lesson.html" uk-tooltip="title: Star This course now  ; delay: 300 ; pos: top ;animation:	uk-animation-slide-bottom-small"> Satın Al</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <ul class="uk-child-width-expand course-dhashboard-subnav" uk-tab>
        <li class="uk-active">
            <a href="#" class="tablinks" onclick="openTabs(event, 'Description')"> @lang('front/auth.description')  </a>
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
    <div class="uk-container tm-hero">
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
                <!-- Course-Videos tab  -->
                <div id="Course-Videos" class="tabcontent  animation: uk-animation-slide-right-medium">
                    <ul uk-accordion="" class="uk-accordion">
                        @forelse($course->sections as $section)
                        <li class="tm-course-lesson-section uk-background-default">
                            <a class="uk-accordion-title uk-padding-small" href="#"><h6> @lang('front/auth.section') {{$section->no}}</h6> <h4 class="uk-margin-remove"> {{$section->name}}</h4> </a>
                            <div class="uk-accordion-content uk-margin-remove-top">
                                <div class="tm-course-section-list">
                                    <ul>
                                        @forelse($section->lessons as $lesson)
                                        <li>
                                            <a href="#modal-media-video" class="uk-link-reset" uk-toggle>
                                                <!-- Play icon  -->
                                                <span>
                                                    @if(Auth::check()&& in_array($lesson->id, $completed) )
                                                        <i style="color:#2ED24A" class="fas fa-check-circle icon-medium" uk-tooltip="title: @lang('front/auth.watch_again')  ; delay: 300 ; pos: top ;animation:	uk-animation-slide-bottom-small"></i>
                                                    @elseif($lesson->is_video)
                                                        <i style="color:#666666" class="fas fa-play-circle icon-medium" uk-tooltip="title: @lang('front/auth.watch')  ; delay: 300 ; pos: top ;animation:	uk-animation-slide-bottom-small"></i>
                                                    @else
                                                        <i style="color:#666666" class="fas fa-file-alt icon-medium" uk-tooltip="title: @lang('front/auth.watch')  ; delay: 300 ; pos: top ;animation:	uk-animation-slide-bottom-small"></i>
                                                    @endif
                                                </span>
                                                <!-- Course title  -->
                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">{{$lesson->name}}</div>
                                                </a>
                                            @if($lesson->preview)
                                               <!-- preview link -->
                                                <a style="color:#666666" class="uk-link-reset uk-margin-xlarge-right uk-position-center-right uk-padding-small uk-text-small uk-visible@s"
                                                > <i class="fas fa-play icon-small uk-text-grey"></i> @lang('front/auth.preview')  </a>
                                               <!-- time -->
                                                @if($lesson->is_video)
                                                   <span style="color:#666666" class="uk-visible@m uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i>  {{$lesson->long}}</span>
                                                @endif
                                            @elseif($lesson->is_video)
                                                    <span style="color:#666666" class="uk-visible@m uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i>  {{$lesson->long}}</span>
                                            @endif
                                        </li>
                                        @empty
                                            <p>@lang('front/auth.have_no_requirement')</p>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </li>
                        @empty
                            <p>@lang('front/auth.have_no_requirement')</p>
                        @endforelse
                    </ul>

                    <!-- Model  Preview videos-->
                    <course-previews
                        course-id="{{$course->id}}"
                        module-name="generalEducation"
                    > </course-previews>
                </div>
                <!-- Reviews  -->
                <div id="Reviews" class="tabcontent animation: uk-animation-slide-right-medium">
                    <h3 style="tab-index: 1">@lang('front/auth.reviews')</h3>
                    @if(Auth::check() && Auth::user()->can('comment', $course))
                        <review course-id="{{$course->id}}"
                                user-id="{{Auth::user()->id}}"
                                send-text="@lang('front/auth.send')"
                                comment-text="@lang('front/auth.comment')"
                        > </review>
                    @endif
                    <div class="uk-margin-medium-top">
                        <course-review
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
                                <a href="{{route('instructor_profile', $instructor->id)}}"><img alt="Image" class="uk-width-2-3 uk-margin-small-top uk-margin-small-bottom uk-border-circle uk-box-shadow-large  uk-animation-scale-up" src="{{asset($instructor->user->avatar)}}"></a>
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
            <div class="uk-width-1-3@m uk-visible@m">
                <h3 class="uk-text-bold">@lang('front/auth.related_courses') </h3>
                @foreach($similar_courses as $similar_course)
                    <div class="uk-margin-medium-bottom">
                        <course-card
                            title="{{$similar_course->name}}"
                            description="{{$similar_course->description}}"
                            img-path="{{$similar_course->image}}"
                            @if($similar_course->price!=$similar_course->price_with_discount)
                            discount
                            :current-price="{{$similar_course->price_with_discount}}"
                            :prev-price="{{$similar_course->price}}"
                            @else
                            :current-price="{{$similar_course->price}}"
                            @endif
                            :rate="{{$similar_course->point}}"
                            page-link="{{route('ge_course',$similar_course->id)}}"
                            style-full-star-color="#F4C150"
                            style-empty-star-color="#C1C1C1"
                            :course-id="{{$similar_course->id}}"
                            module-name="generalEducation"
                        ></course-card>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

