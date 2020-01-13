<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{asset('js/simplebar.js')}}"></script>
    <script src="{{asset('js/dropzone.min.js')}}"></script>
    <script src="{{asset('js/uikit.js')}}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/uikit.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin.css')}}" rel="stylesheet">
    <link href="{{asset('css/dropzone.css')}}" rel="stylesheet">
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
    <link href="{{asset('css/fontawesome.css')}}" rel="stylesheet">
</head>
<body>
    <!-- sidebar -->
    <div class="admin-side" id="admin-side">
        <div class="uk-flex uk-flex-center uk-margin-small-top">
            <a class="" href="{{route('home')}}">
                <img class="uk-logo uk-width-small" src="{{asset('images/logo1.png')}}"/>
            </a>
        </div>
        <ul>
            <li>
                <a href="{{route('instructor_courses')}}"> <i class="fas fa-user"></i>  @lang('front/auth.my_courses') </a>
            </li>
            <li>
                <a href="{{route('instructor_books')}}"> <i class="fas fa-book-open"></i>@lang('front/auth.my_books')</a>
            </li>
            <li>
                <a href="{{route('instructor_exams')}}"> <i class="fas fa-user"></i>@lang('front/auth.my_exams')</a>
            </li>
            <li>
                <a href="{{route('instructor_homeworks')}}"> <i class="fas fa-code"></i>@lang('front/auth.my_homework_packages')</a>
            </li>
            <li>
                <a href="{{route('instructor_performance')}}"> <i class="fas fa-play"></i>@lang('front/auth.performance')</a>
            </li>
            <li>
                <a href="{{route('instructor_questions')}}"> <i class="fas fa-user"></i>@lang('front/auth.questions')</a>
            </li>
            <li>
                <a href="{{route('logout')}}"> <i class="fas fa-sign-out-alt"></i>@lang('front/auth.log_out')</a>
            </li>
        </ul>
    </div>
    <!-- mobile  header -->
    <div class="admin-mobile-headder uk-hidden@m">
        <span uk-toggle="target: #admin-side; cls: admin-side-active" class="uk-padding-small uk-text-white uk-float-right"><i class="fas fa-bars"></i></span>
        <a class="" href="{{route('home')}}"> <img class="uk-width-small" src="{{asset('images/logo2.png')}}"/> </a>
    </div>
    <!-- main contant -->
    <div class="admin-content">
        <div id="app1" class="admin-content-inner">
            <!--general education-->
            <div class="uk-container">
                <div class="section-heading uk-position-relative uk-margin-medium-top none-border uk-clearfix">
                    <div class="uk-float-left">
                        <h2>@lang('front/auth.general_education')</h2>
                        <p>@lang('front/auth.popular_in_category')</p>
                    </div>
                    <div class="uk-float-right">
                        <a href="{{route('ge_index')}}" class="uk-button uk-button-grey">@lang('front/auth.see_more')</a>
                    </div>
                </div>
            </div>
            @if($data['ge']==null || count($data['ge'])==0)
            <div class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                <h4 class="uk-text-bold uk-margin-remove-top">@lang('front/auth.not_found_content')</h4>
            </div>
            @else
            <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
                <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                    @foreach($data['ge'] as $course)
                    <li>
                        <div class="uk-card-default uk-card-hover uk-card-small uk-width Course-card uk-inline-clip uk-transition-toggle" tabindex="0">
                            <a href="{{route('ge_course', $course->id)}}" class="uk-link-reset">
                                <img src="{{$course->image}}" class="course-img">
                                <div class="uk-card-body">
                                    <h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">{{$course->name}}</h4>
                                    <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="uk-height-small">{{$course->description}}</p>
                                    <hr class="uk-margin-remove-top">
                                    <div class="uk-grid uk-child-width-1-2">
                                        <div>
                                            <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right"><i class="fas fa-user-graduate uk-margin-small-right"></i>{{$course->studentCount()}} @lang('front/auth.student')</p>
                                            <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right"><i class="fas fa-calendar-alt uk-margin-small-right"></i>{{date("d/m/Y", strtotime($course->created_at))}}</p>
                                        </div>
                                        <div class="uk-flex justify-content-sm-between align-items-center ">
                                            <a class="uk-button-text uk-button" href="#"><i class="fas fa-cog"></i></a>
                                            @if($course->active)
                                                <a class="uk-button-text uk-button" href="#"><i class="fas fa-times-circle"></i></a>
                                            @else
                                                <a class="uk-button-text uk-button" href="#"><i class="fas fa-check-circle"></i></a>
                                            @endif
                                            <a class="uk-button uk-button-text" href="#"> <i class="fas fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <a class="uk-position-center-left uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-next uk-slider-item="next"></a>
                <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin">
                    <li uk-slider-item="0" class="">
                        <a href="#"></a>
                    </li>
                </ul>
            </div>
            @endif
            <!--prepare for lessons-->
            <div class="uk-container">
                <div class="section-heading uk-position-relative uk-margin-medium-top none-border uk-clearfix">
                    <div class="uk-float-left">
                        <h2>@lang('front/auth.prepare_for_lessons')</h2>
                        <p>@lang('front/auth.popular_in_category')</p>
                    </div>
                    <div class="uk-float-right">
                        <a href="{{route('ge_index')}}" class="uk-button uk-button-grey">@lang('front/auth.see_more')</a>
                    </div>
                </div>
            </div>
            @if($data['pl']==null || count($data['pl'])==0)
            <div class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                <h4 class="uk-text-bold uk-margin-remove-top">@lang('front/auth.not_found_content')</h4>
            </div>
            @else
            <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
                <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                    @foreach($data['pl'] as $course)
                        <li>
                            <div class="uk-card-default uk-card-hover uk-card-small uk-width Course-card uk-inline-clip uk-transition-toggle" tabindex="0">
                                <a href="{{route('ge_course', $course->id)}}" class="uk-link-reset">
                                    <img src="{{$course->image}}" class="course-img">
                                    <div class="uk-card-body">
                                        <h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">{{$course->name}}</h4>
                                        <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="uk-height-small">{{$course->description}}</p>
                                        <hr class="uk-margin-remove-top">
                                        <div class="uk-grid uk-child-width-1-2">
                                            <div>
                                                <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right"><i class="fas fa-user-graduate uk-margin-small-right"></i>{{$course->studentCount()}} @lang('front/auth.student')</p>
                                                <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right"><i class="fas fa-calendar-alt uk-margin-small-right"></i>{{date("d/m/Y", strtotime($course->created_at))}}</p>
                                            </div>
                                            <div class="uk-flex justify-content-sm-between align-items-center ">
                                                <a class="uk-button-text uk-button" href="#"><i class="fas fa-cog"></i></a>
                                                @if($course->active)
                                                    <a class="uk-button-text uk-button" href="#"><i class="fas fa-times-circle"></i></a>
                                                @else
                                                    <a class="uk-button-text uk-button" href="#"><i class="fas fa-check-circle"></i></a>
                                                @endif
                                                <a class="uk-button uk-button-text" href="#"> <i class="fas fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <a class="uk-position-center-left uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-next uk-slider-item="next"></a>
                <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin">
                    <li uk-slider-item="0" class="">
                        <a href="#"></a>
                    </li>
                </ul>
            </div>
            @endif
            <!--prepare for exams-->
            <div class="uk-container">
                <div class="section-heading uk-position-relative uk-margin-medium-top none-border uk-clearfix">
                    <div class="uk-float-left">
                        <h2>@lang('front/auth.prepare_for_exams')</h2>
                        <p>@lang('front/auth.popular_in_category')</p>
                    </div>
                    <div class="uk-float-right">
                        <a href="{{route('ge_index')}}" class="uk-button uk-button-grey">@lang('front/auth.see_more')</a>
                    </div>
                </div>
            </div>
            @if($data['pe']==null || count($data['pe'])==0)
            <div class="uk-container uk-flex uk-flex-center uk-margin-medium-top">
                <h4 class="uk-text-bold uk-margin-remove-top">@lang('front/auth.not_found_content')</h4>
            </div>
            @else
            <div class="uk-position-relative uk-visible-toggle  uk-container uk-padding-medium" uk-slider>
                <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                    @foreach($data['pe'] as $course)
                        <li>
                            <div class="uk-card-default uk-card-hover uk-card-small uk-width Course-card uk-inline-clip uk-transition-toggle" tabindex="0">
                                <a href="{{route('ge_course', $course->id)}}" class="uk-link-reset">
                                    <img src="{{$course->image}}" class="course-img">
                                    <div class="uk-card-body">
                                        <h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 16px; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">{{$course->name}}</h4>
                                        <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; line-height: 16px; max-height: 32px; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="uk-height-small">{{$course->description}}</p>
                                        <hr class="uk-margin-remove-top">
                                        <div class="uk-grid uk-child-width-1-2">
                                            <div>
                                                <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right"><i class="fas fa-user-graduate uk-margin-small-right"></i>{{$course->studentCount()}} @lang('front/auth.student')</p>
                                                <p class="uk-margin-remove-bottom uk-margin-remove-left uk-margin-remove-top uk-margin-small-right"><i class="fas fa-calendar-alt uk-margin-small-right"></i>{{date("d/m/Y", strtotime($course->created_at))}}</p>
                                            </div>
                                            <div class="uk-flex justify-content-sm-between align-items-center ">
                                                <a class="uk-button-text uk-button" href="#"><i class="fas fa-cog"></i></a>
                                                @if($course->active)
                                                    <a class="uk-button-text uk-button" href="#"><i class="fas fa-times-circle"></i></a>
                                                @else
                                                    <a class="uk-button-text uk-button" href="#"><i class="fas fa-check-circle"></i></a>
                                                @endif
                                                <a class="uk-button uk-button-text" href="#"> <i class="fas fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <a class="uk-position-center-left uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small uk-hidden-hover uk-hidden-hover uk-icon-button" href="#" uk-slidenav-next uk-slider-item="next"></a>
                <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin">
                    <li uk-slider-item="0" class="">
                        <a href="#"></a>
                    </li>
                </ul>
            </div>
            @endif
            <div class="uk-section-small uk-margin-medium-top">
                <hr class="uk-margin-remove">
                <div class="uk-container uk-align-center uk-margin-remove-bottom uk-position-relative">
                    <div uk-grid>
                        <div class="uk-width-1-3@m uk-width-1-2@s uk-first-column">
                            <a class="" href="{{route('home')}}"> <img class="uk-logo uk-width-small@s uk-width-medium@m" src="{{asset('images/logo2.png')}}"/> </a>
                            <div class="uk-width-xlarge tm-footer-description">Bilgi paylaştıkça çoğalır.</div>
                        </div>
                        <div class="uk-width-expand@m uk-width-1-2@s">
                            <ul class="uk-list  tm-footer-list">

                            </ul>
                        </div>
                        <div class="uk-width-expand@m uk-width-1-2@s">
                            <ul class="uk-list tm-footer-list">
                                <li>
                                    <a href="{{route('ge_index')}}">Genel Eğitim Modülü </a>
                                </li>
                                <li>
                                    <a href="#">Sınavlara Hazırlık Modülü  </a>
                                </li>
                                <li>
                                    <a href="#"> Derslere Hazırlık Modülü </a>
                                </li>
                            </ul>
                        </div>
                        <div class="uk-width-expand@m uk-width-1-2@s">
                            <ul class="uk-list  tm-footer-list">
                                <li>
                                    <a href="#"> Denemeler </a>
                                </li>
                                <li>
                                    <a href="#"> Ödemeler </a>
                                </li>
                                <li>
                                    <a href="#"> İletişim </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <div class="uk-margin-medium uk-margin-remove-right" uk-grid>
                        <div class="uk-width-1-3@m uk-width-1-1@s uk-first-column">
                            <p class="uk-text-small"><i class="fas fa-copyright"></i> 2020 <span class="uk-text-bold">Bipayco</span>  Bütün hakları saklıdır.</p>
                        </div>
                        <div class="uk-width-1-3@m uk-width-1-1@s">
                            <a href="#" class="uk-icon-button uk-link-reset" uk-tooltip="title: Our Youtube Chanal; pos: top-center"><i class="fab fa-youtube" style=" color: #fb7575  !important;"></i></a>
                            <a href="#" class="uk-icon-button uk-link-reset" uk-tooltip="title: Our Facebook; pos: top-center"><i class="fab fa-facebook" style=" color: #9160ec  !important;"></i></a>
                            <a href="#" class="uk-icon-button uk-link-reset" uk-tooltip="title: Our Instagram; pos: top-center"><i class="fab fa-instagram" style=" color: #dc2d2d  !important;"></i></a>
                            <a href="#" class="uk-icon-button uk-link-reset" uk-tooltip="title: Our linkedin; pos: top-center"><i class="fab fa-linkedin " style=" color: #6949a5  !important;"></i></a>
                            <a href="#" class="uk-icon-button uk-link-reset" uk-tooltip="title: Our Twitter; pos: top-center"><i class="fab fa-twitter" style=" color: #6f23ff !important;"></i></a>
                        </div>
                        <div class="uk-width-1-3@m uk-width-1-1@s">
                            <p><a href="#"  class="uk-text-bold uk-link-reset"> Sanalist </a> tarafından geliştirildi. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
