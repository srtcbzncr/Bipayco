<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{asset('/images/Bipayco.ico')}}">
    <title> Bipayco </title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.2.6/dist/js/uikit.min.js"></script>
    <script src="{{asset('js/uikit.js')}}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/uikit.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin.css')}}" rel="stylesheet">
    <link href="{{asset('css/dropzone.css')}}" rel="stylesheet">
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
    <link href="{{asset('css/fontawesome.css')}}" rel="stylesheet">
</head>
<body>
@if(session('result_message'))
    @if(session('error'))
        <script>UIkit.notification({message: '{{session('message')}}', status: 'danger'});</script>
    @else
        <script>UIkit.notification({message: '{{session('message')}}', status: 'success'});</script>
    @endif
@endif
<div id="app1">
    <div class="side-nav uk-animation-slide-left-medium" id="side-nav">
        <span class="uk-animation-fade tm-mobile-close-icon" uk-toggle="target: #side-nav; cls: side-nav-active"> <i class="fas fa-times icon-large"></i></span>
        <side-bar
            general-education-route="{{route('ge_index')}}"
            prepare-lessons-route="{{route('pl_index')}}"
            prepare-exams-route="{{route('pe_index')}}"
            home-route="{{route('home')}}"
            logo="{{asset('images/logo.png')}}"
            general-education-text="@lang('front/auth.general_education')"
            prepare-lesson-text="@lang('front/auth.prepare_for_lessons')"
            prepare-exams-text="@lang('front/auth.prepare_for_exams')"
            books-text="@lang('front/auth.books')"
            exams-text="@lang('front/auth.exams')"
            all-of-category="@lang('front/auth.all_of_category')"
        ></side-bar>
    </div>
    <div id="spinneroverlay">
        <div class="spinner"></div>
    </div>
    <div class="app">
        <main class="uk-height-viewport">
            <!--  Top bar nav -->
            <nav class="tm-mobile-header uk-navbar uk-padding-remove-top uk-padding-remove-bottom">
                <!-- mobile icon for side nav on nav-mobile-->
                <span class="uk-hidden@m tm-mobile-menu-icon" uk-toggle="target: #side-nav; cls: side-nav-active"><i class="fas fa-bars icon-large"></i></span>
                <!-- mobile icon for user icon on nav-mobile -->
                <span class="uk-hidden@m tm-mobile-user-icon uk-align-right" uk-toggle="target: #tm-show-on-mobile; cls: tm-show-on-mobile-active"><i class="far fa-user icon-large"></i></span>
                <!-- mobile logo -->
                <a class="uk-hidden@m uk-logo" href="{{route('home')}}">Bipayco</a>
{{--                <div class="uk-navbar-left uk-visible@m uk-flex-center">--}}
{{--                @if(Auth::check())--}}
{{--                    @if(!isSet(Auth::user()->instructor))--}}
{{--                        <a href="{{route('instructor_create_get')}}" class="uk-navbar-item uk-button-text back-to-dashboard uk-margin-small-top"> @lang('front/auth.be_instructor') </a>--}}
{{--                    @else--}}
{{--                        <a href="{{route('instructor_courses')}}" class="uk-navbar-item uk-button-text back-to-dashboard uk-margin-small-top">@lang('front/auth.instructor_mode')</a>--}}
{{--                    @endif--}}
{{--                    @if(isSet(Auth::user()->admin))--}}
{{--                            <a href="{{route('adminDashboard')}}" class="uk-navbar-item uk-button-text back-to-dashboard uk-margin-small-top"> @lang('front/auth.admin_mode') </a>--}}
{{--                    @endif--}}
{{--                @endif--}}
{{--                </div>--}}
                <div class="uk-navbar-right tm-show-on-mobile uk-flex-right" id="tm-show-on-mobile" >
                    <!-- this will clouse after display user icon -->
                    <span class="uk-hidden@m tm-mobile-user-close-icon uk-align-right" uk-toggle="target: #tm-show-on-mobile; cls: tm-show-on-mobile-active"><i class="fas fa-times icon-large"></i></span>
                    <ul class="uk-navbar-nav uk-flex-middle">
                        <li>
                            <a href="#modal-full" uk-toggle><i style="color: #424242" class="fas fa-search icon-medium"></i></a>
                        </li>
                        @if(Auth::check())
                        <li>
                            <!-- your courses -->
                            <a href="#"> <i style="color: #424242" class="fas fa-play icon-medium" uk-tooltip="title: Kurslarım ; delay: 500 ; pos: bottom ;animation:	uk-animation-scale-up"></i></a>
                            <your-courses
                                user-id="{{Auth::user()->id}}"
                                profile-route="{{route('student_profile', Auth::user()->id)}}"
                                no-content-text="@lang('front/auth.have_no_course')"
                                see-all-text="@lang('front/auth.see_all')"
                                my-courses-text="@lang('front/auth.my_courses')"
                            > </your-courses>
                        </li>
                        <li>
                            <!-- messages -->
                            <a href="#"><i style="color: #424242" class="fas fa-shopping-cart icon-medium" uk-tooltip="title: Sepetim ; delay: 500 ; pos: bottom ;animation:	uk-animation-scale-up"></i></a>
                            <div uk-dropdown="pos: top-right ;mode : click; animation: uk-animation-slide-bottom-small" class="uk-dropdown uk-dropdown-top-right  tm-dropdown-medium border-radius-6 uk-padding-remove uk-box-shadow-large angle-top-right">
                                <h5 class="uk-padding-small uk-margin-remove uk-text-bold  uk-text-left"> Sepetim </h5>
                                <messages-small-card
                                    user-id="{{Auth::user()->id}}"
                                > </messages-small-card>
                                <hr class=" uk-margin-remove">
                                <h5 class="uk-padding-small uk-margin-remove uk-text-bold uk-text-center"><a class="uk-link-heading" href="{{route('get_basket')}}"> Sepete Git </a> </h5>
                            </div>
                        </li>
                            <!-- Notifications -->
                            <notification-area
                                notification-text="@lang('front/auth.notification')"
                                remove-all-text="@lang('front/auth.remove_all')"
                                have-no-new-notification-text="@lang('front/auth.have_no_new_notification')"
                                user-id="{{Auth::user()->id}}"
                            ></notification-area>
                        <li>
                            <!-- User profile -->
                            <a href="#">
                                <img src="{{asset(Auth::user()->avatar)}}" alt="" class="uk-border-circle user-profile-tiny">
                            </a>
                            <user-profile-dropdown-nav
                                @if(!isSet(Auth::user()->instructor))
                                instructor-mode-route="{{route('instructor_create_get')}}"
                                instructor-mode="@lang('front/auth.be_instructor')"
                                @else
                                instructor-mode="@lang('front/auth.instructor_mode')"
                                instructor-mode-route="{{route('instructor_courses')}}"
                                @endif
                                @if(isSet(Auth::user()->admin))
                                admin-mode="@lang('front/auth.admin_mode')"
                                admin-mode-route="{{route('adminDashboard')}}"
                                is-admin
                                @endif
                                @if(isSet(Auth::user()->guardian))
                                guardian-mode="@lang('front/auth.guardian_mode')"
                                guardian-mode-route="{{route('guardian_students')}}"
                                is-guardian
                                @endif
                                favorites="@lang('front/auth.favorites')"
                                favorites-route="{{route('get_favorite')}}"
                                settings-route="{{route('settings')}}"
                                logout-route="{{route('logout')}}"
                                settings="@lang('front/auth.settings')"
                                log-out="@lang('front/auth.log_out')"
                                profile="@lang('front/auth.profile')"
                                profile-route="{{route('student_profile', Auth::user()->id)}}"
                                profile-image='{{asset(Auth::user()->avatar)}}'
                                user-name="{{Auth::user()->first_name}} {{Auth::user()->last_name}}"
                                user-city="{{Auth::user()->district->name}}, {{Auth::user()->district->city->name}}"
                            > </user-profile-dropdown-nav>
                        </li>
                        @else
                        <li>
                            <a href="{{route('loginGet')}}" class="uk-padding-remove uk-margin-small-left"><button class="uk-button uk-button-primary uk-padding-small uk-padding-remove-vertical">@lang('front/auth.login')</button></a>
                        </li>
                        <li>
                            <a href="{{route('registerGet')}}" class="uk-padding-remove uk-margin-small-left"><button class="uk-button uk-button-danger uk-padding-small uk-padding-remove-vertical">@lang('front/auth.register')</button></a>
                        </li>
                        @endif
                    </ul>
                </div>
                <div id="modal-full" class="uk-modal-full uk-modal uk-animation-scale-down" uk-modal>
                    <div class="uk-modal-dialog uk-flex uk-flex-center" uk-height-viewport>
                        <button class="uk-modal-close-full" type="button" uk-close> </button>
                        <form method="POST" action="{{ route('search') }}" class="uk-search uk-margin-small-left uk-margin-xlarge-top uk-search-large uk-flex-center uk-animation-slide-bottom-medium">
                            @csrf
                            <i class="fas fa-search uk-position-absolute uk-margin-top icon-xxlarge"> </i>
                            <input class="uk-search-input uk-margin-large-left uk-width-medium" name="search" type="search" placeholder="Search..." autofocus>
                        </form>
                    </div>
                </div>
            </nav>
            <div class="uk-margin-remove uk-padding-remove">
                @yield('content')
            </div>
            <div class="uk-section-small uk-margin-medium-top">
                <hr class="uk-margin-remove">
                <div class="uk-container uk-align-center uk-margin-remove-bottom uk-position-relative">
                    <div uk-grid>
                        <div class="uk-width-1-3@m uk-width-1-2@s uk-first-column">
                            <a class="" href="{{route('home')}}"> <img class="uk-logo uk-width-small@s uk-width-medium@m" src="{{asset('images/logo2.png')}}"/> </a>
                            <div class="uk-width-xlarge tm-footer-description">Bilgi paylaştıkça çoğalır.</div>
                            <p class="uk-text-small"><i class="fas fa-at"></i> info@bipayco.com </p>

                        </div>
                        <div class="uk-width-expand@m uk-width-1-2@s">
                            <ul class="uk-list  tm-footer-list">
                            </ul>
                        </div>
                        <div class="uk-width-expand@m uk-width-1-3@s">
                            <ul class="uk-list tm-footer-list">
                                <li>
                                    <h5>Bölümler</h5>
                                </li>
                                <li>
                                    <a href="{{route('ge_index')}}">Genel Eğitim Modülü </a>
                                </li>
                                <li>
                                    <a href="{{route('pl_index')}}"> Derslere Hazırlık Modülü </a>
                                </li>
                                <li>
                                    <a href="#">Sınavlara Hazırlık Modülü  </a>
                                </li>
                                <li>
                                </li>
                                <li>
                                </li>
                            </ul>
                        </div>
                        <div class="uk-width-expand@m uk-width-1-3@s">
                            <ul class="uk-list  tm-footer-list">
                                <li>
                                    <h5>Hakkımızda </h5>
                                </li>
                                <li>
                                    <a href="{{asset('/contracts/whoWeAre.pdf')}}" target="_blank"> Biz Kimiz? </a>
                                </li>
                                <li>
                                    <a href="{{asset('/contracts/preInformationForm.pdf')}}" target="_blank"> Ön Bilgilendirme Formu </a>
                                </li>
                                <li>
                                    <a href="{{asset('/contracts/subscription.pdf')}}" target="_blank"> Abonelik Sözleşmesi </a>
                                </li>
                                <li>
                                    <a href="{{asset('/contracts/salesContract.pdf')}}" target="_blank"> Satış Sözleşmesi </a>
                                </li>
                                <li>
                                    <a href="{{asset('/contracts/kvkkAydinlatma.pdf')}}" target="_blank"> KVKK Aydınlatma Metni </a>
                                </li>
                            </ul>
                        </div>
                        <div class="uk-width-expand@m uk-width-1-3@s">
                            <ul class="uk-list  tm-footer-list">
                                <li>
                                    <h5></h5>
                                </li>
                                <li>
                                    <a href="{{asset('/contracts/fikriMulkiyetPolitikasi.pdf')}}" target="_blank"> Fikri Mülkiyet Politikası </a>
                                </li>
                                <li>
                                    <a href="{{asset('/contracts/gizlilikPolitikasi.pdf')}}" target="_blank"> Gizlilik Politikası </a>
                                </li>
                                <li>
                                    <a href="{{asset('/contracts/kullanimKosullari.pdf')}}" target="_blank"> Kullanım Koşulları </a>
                                </li>
                                <li>
                                    <a href="{{asset('/contracts/uyeHukumleri.pdf')}}" target="_blank"> Üye Hükümleri ve Koşulları </a>
                                </li>
                                <li>
                                    <a href="{{asset('/contracts/cookiesPolicy.pdf')}}" target="_blank"> Çerez Politikamız </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <div class="uk-margin-medium uk-margin-remove-right" uk-grid>
                        <div class="uk-width-1-3@m uk-width-1-1@s uk-first-column">
                            <p class="uk-text-small"><i class="fas fa-copyright"></i> 2020 <span class="uk-text-bold">Bipayco</span>  Bütün hakları saklıdır.</p>
                            <img class="uk-width-1-5@s uk-width-1-4@m uk-width-1-6" src="{{asset('/images/visa-master.png')}}">
                        </div>
                        <div class="uk-width-1-3@m uk-width-1-1@s">
                            <a href="#" class="uk-icon-button uk-link-reset"><i class="fab fa-youtube" style=" color: #fb7575  !important;"></i></a>
                            <a href="#" class="uk-icon-button uk-link-reset"><i class="fab fa-facebook" style=" color: #9160ec  !important;"></i></a>
                            <a href="#" class="uk-icon-button uk-link-reset"><i class="fab fa-instagram" style=" color: #dc2d2d  !important;"></i></a>
                            <a href="#" class="uk-icon-button uk-link-reset"><i class="fab fa-linkedin " style=" color: #6949a5  !important;"></i></a>
                            <a href="#" class="uk-icon-button uk-link-reset"><i class="fab fa-twitter" style=" color: #6f23ff !important;"></i></a>
                        </div>
                        <div class="uk-width-1-3@m uk-width-1-1@s">
                            <p><a href="http://sanalist.com.tr/"  class="uk-text-bold uk-link-reset"> Sanalist </a> tarafından geliştirildi. </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<script>
    (function (window, document, undefined) {
        'use strict';
        if (!('localStorage' in window)) return;
        var nightMode = localStorage.getItem('gmtNightMode');
        if (nightMode) {
            document.documentElement.className += ' night-mode';
        }
    })(window, document);

    // Preloader
    var spinneroverlay = document.getElementById("spinneroverlay");
    window.addEventListener('load', function(){
      spinneroverlay.style.display = 'none';
    });

    //scrollTop
    // When the user scrolls down 20px from the top of the document, show the button
    /*window.onscroll = function() {scrollFunction()};
    function scrollFunction() {
      if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("scrollTop").style.display = "block";
      } else {
        document.getElementById("scrollTop").style.display = "none";
      }
    }
    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }*/
</script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    function togglePassword(name) {
        var passwordInput= document.getElementById(name);
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }
    function copyToClipboard(idName) {
        var textBox = document.getElementById(idName);
        textBox.select();
        document.execCommand("copy");
        UIkit.notification({message:"@lang('front/auth.copied_successfully')", status: 'success'});
    }
    function beGuardian(userId) {
        axios.post('/api/guardian/createGuardian', {'userId': userId})
            .then((res)=>{
                if(!res.error){
                    UIkit.notification({message:"@lang('front/auth.guardian_profile_created_successfully')", status: 'success'});
                }else{
                    UIkit.notification({message:res.errorMessage, status: 'danger'});
                }
            });
        setTimeout(()=>{this.window.location.reload()}, '1500');
    }
</script>
</body>
</html>
