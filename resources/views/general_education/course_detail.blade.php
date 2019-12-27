@extends('layouts.app')
@section('content')
    <div class="course-dhashboard topic{{rand(1,10)}}" >
        <div uk-grid>
            <div class="uk-width-1-2@m uk-padding-remove-left uk-visible@m">
                <div class="course-video-demo uk-position-relative">
                    <div class="video-responsive">
                        <iframe src="https://www.youtube.com/embed/nOCXXHGMezU" class="uk-padding-remove" uk-video="automute: true" frameborder="0" allowfullscreen uk-responsive></iframe>
                    </div>
                    <!--  Local video
                    <video loop muted playsinline controls uk-video="autoplay: inview">
                        <source src="videos/course-intro.mp4" type="video/mp4">
                    </video>
                    -->
                </div>
            </div>
            <div class="uk-width-1-2@m uk-padding">
                <h2 class="uk-light uk-text-uppercase uk-text-bold uk-text-white"> {{$course->name}}   </h2>
                <p class="uk-light uk-text-bold">{{$course->description}}</p>
                <p class="uk-light uk-text-bold uk-text-small"> <i class="fas fa-star icon-small icon-rate"></i> <i class="fas fa-star icon-small icon-rate"></i> <i class="fas fa-star icon-small icon-rate"></i> <i class="far fa-star icon-small icon-rate"></i> <i class="far fa-star icon-small icon-rate"></i>
                    4.0 (2282 ratings)       </p>
                <!-- students images  -->
                <div class="avatar-group uk-margin" uk-scrollspy="target: > img; cls:uk-animation-slide-right; delay: 200">
                    <img src="#" alt="">
                    <img src="#" alt="">
                    <img src="#" alt="">
                    <span class="uk-text-bold uk-light">  5134 + students enrolled </span>
                </div>
                <div class="uk-grid-small" uk-grid>
                    <div class="uk-width-auto">
                        <a class="uk-button uk-button-white uk-float-left" href="Course-lesson.html" uk-tooltip="title: Star This course now  ; delay: 300 ; pos: top ;animation:	uk-animation-slide-bottom-small"> Continue</a>
                    </div>
                    <div class="uk-width-expand">
                        <span class="uk-light uk-text-small uk-text-bold"> My progress </span>
                        <progress id="js-progressbar" class="uk-progress progress-green uk-margin-small-bottom uk-margin-small-top" value="50" max="100" style="height: 8px;"></progress>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ul class="uk-child-width-expand course-dhashboard-subnav" uk-tab>
        <li class="uk-active">
            <a href="#" class="tablinks" onclick="openTabs(event, 'Description')"> Description  </a>
        </li>
        <li>
            <a href="#" class="tablinks" onclick="openTabs(event, 'Course-Videos')"> <span class="uk-visible@m"> Course </span>  Videos </a>
        </li>
        <li>
            <a href="#" class="tablinks" onclick="openTabs(event, 'Reviews')"> Reviews </a>
        </li>
        <li>
            <a href="#" class="tablinks" onclick="openTabs(event, 'Instructor')"> Instructor </a>
        </li>
    </ul>
    <div class="uk-container tm-hero">
        <div uk-grid>
            <!-- page contant -->
            <div class="uk-width-2-3@m uk-first-column">
                <!-- Discription tab  -->
                <div id="Description" class="tabcontent tab-default-open animation: uk-animation-slide-right-medium">
                    <h3> About this Course</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Nulla facilisi. Aenean pharetra fringilla nunc a finibus. Nulla vitae pretium nunc. Pellentesque sagittis sollicitudin turpis id aliquam.</p>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                    <p> Etiam sit amet augue non velit aliquet consectetur. Proin gravida, odio in facilisis pharetra, neque enim aliquam eros, vitae gravida orci elit vel magna. Integer viverra a purus id gravida. Donec laoreet mi ac auctor ultricies. Pellentesque ullamcorper est et erat ullamcorper gravida. In hac habitasse platea dictumst.</p>
                    <p>  Pellentesque justo mauris, mollis at tortor ut, commodo venenatis elit. Curabitur suscipit pellentesque nunc, id tempus mi facilisis sed. Curabitur molestie eu odio vitae condimentum. Donec placerat tristique neque a blandit. Nullam commodo massa ut eros elementum, in suscipit libero aliquam </p>
                    <b> fames ac ante ipsum primis in faucibus</b>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                    <h4> Mauris Faucibus</h4>
                    <ul class="uk-list uk-list-bullet">
                        <li>Bibendum diam velit in libero  </li>
                        <li>Maecenas vel dolor sit amet ligula </li>
                        <li> Donec in risus eu lorem</li>
                        <li>  Suspendisse pharetra risus ut metus elementum</li>
                    </ul>
                    <h4>  Pellentesque Elementum Tellus Id Mauris Faucibus</h4>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        Nulla facilisi. Duis auctor fringilla sagittis. Fusce ornare, dui id consequat volutpat, nibh metus viverra nibh, vitae bibendum diam velit in libero. Sed dignissim</p>
                </div>
                <!-- Course-Videos tab  -->
                <div id="Course-Videos" class="tabcontent  animation: uk-animation-slide-right-medium">
                    <ul uk-accordion="" class="uk-accordion">
                        <li class="uk-open tm-course-lesson-section uk-background-default">
                            <a class="uk-accordion-title uk-padding-small" href="#"><h6> section  one</h6> <h4 class="uk-margin-remove"> Introduction to basic HTML</h4> </a>
                            <div class="uk-accordion-content uk-margin-remove-top">
                                <div class="tm-course-section-list">
                                    <ul>
                                        <li>
                                            <a href="Course-lesson.html" class="uk-link-reset">
                                                <!-- Play icon  -->
                                                <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                <!-- Course title  -->
                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Consectetur ipsum dolor sit  </div>
                                                <!-- preview link -->
                                            </a>
                                            <a class="uk-link-reset uk-margin-large-right uk-position-center-right uk-padding-small uk-text-small uk-visible@s" href="#preview-video-1" uk-toggle> <i class="fas fa-play icon-small uk-text-grey"></i> Preveiw  </a>
                                            <!-- time -->
                                            <span class="uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i>  2 min</span>
                                        </li>
                                        <li>
                                            <a href="Course-lesson.html" class="uk-link-reset">
                                                <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Dolor sit amet  consectetur  </div>
                                                <span class="uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i>  6 min</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="Course-lesson.html" class="uk-link-reset">
                                                <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right"> sed do eiusmod tempor incididunt</div>
                                                <span class="uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i> 8 min</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="Course-lesson.html" class="uk-link-reset">
                                                <!-- Play icon  -->
                                                <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                <!-- Course title  -->
                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Consectetur ipsum dolor sit  </div>
                                                <!-- preview link -->
                                            </a>
                                            <a class="uk-link-reset uk-margin-large-right uk-position-center-right uk-padding-small uk-text-small uk-visible@s" href="#preview-video-2" uk-toggle> <i class="fas fa-play icon-small uk-text-grey"></i> Preveiw  </a>
                                            <!-- time -->
                                            <span class="uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i>  2 min</span>
                                        </li>
                                        <li>
                                            <a href="Course-lesson.html" class="uk-link-reset">
                                                <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right"> Eiusmod tempor incididunt</div>
                                                <span class="uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i>  12 min</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="tm-course-lesson-section uk-background-default">
                            <a class="uk-accordion-title uk-padding-small" href="#"><h6> section  Two </h6> <h4 class="uk-margin-remove"> HTML5  features</h4> </a>
                            <div class="uk-accordion-content uk-margin-remove-top" hidden>
                                <div class="tm-course-section-list">
                                    <ul>
                                        <li>
                                            <a href="Course-lesson.html" class="uk-link-reset">
                                                <!-- Play icon  -->
                                                <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                <!-- Course title  -->
                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Consectetur ipsum dolor sit  </div>
                                                <!-- preview link -->
                                            </a>
                                            <a class="uk-link-reset uk-margin-large-right uk-position-center-right uk-padding-small uk-text-small uk-visible@s" href="#preview-video-1" uk-toggle> <i class="fas fa-play icon-small uk-text-grey"></i> Preveiw  </a>
                                            <!-- time -->
                                            <span class="uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i>  2 min</span>
                                        </li>
                                        <li>
                                            <a href="Course-lesson.html" class="uk-link-reset">
                                                <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Dolor sit amet  consectetur  </div>
                                                <span class="uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i>  6 min</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="Course-lesson.html" class="uk-link-reset">
                                                <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right"> sed do eiusmod tempor incididunt</div>
                                                <span class="uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i> 8 min</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="Course-lesson.html" class="uk-link-reset">
                                                <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right"> Eiusmod tempor incididunt</div>
                                                <span class="uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i>  12 min</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="tm-course-lesson-section uk-background-default">
                            <a class="uk-accordion-title uk-padding-small" href="#"><h6> section  Three</h6> <h4 class="uk-margin-remove"> HTML5 Advance features</h4> </a>
                            <div class="uk-accordion-content uk-margin-remove-top">
                                <div class="tm-course-section-list">
                                    <ul>
                                        <li>
                                            <a href="Course-lesson.html" class="uk-link-reset">
                                                <!-- Play icon  -->
                                                <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                <!-- Course title  -->
                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Consectetur ipsum dolor sit  </div>
                                                <!-- preview link -->
                                            </a>
                                            <a class="uk-link-reset uk-margin-large-right uk-position-center-right uk-padding-small uk-text-small uk-visible@s" href="#preview-video-1" uk-toggle> <i class="fas fa-play icon-small uk-text-grey"></i> Preveiw  </a>
                                            <!-- time -->
                                            <span class="uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i>  2 min</span>
                                        </li>
                                        <li>
                                            <a href="Course-lesson.html" class="uk-link-reset">
                                                <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Dolor sit amet  consectetur  </div>
                                                <span class="uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i>  6 min</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="Course-lesson.html" class="uk-link-reset">
                                                <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right"> sed do eiusmod tempor incididunt</div>
                                                <span class="uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i> 8 min</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="Course-lesson.html" class="uk-link-reset">
                                                <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right"> Eiusmod tempor incididunt</div>
                                                <span class="uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i>  12 min</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="tm-course-lesson-section uk-background-default">
                            <a class="uk-accordion-title uk-padding-small" href="#"><h6> section  Four </h6> <h4 class="uk-margin-remove"> Build a Project in HTML 5</h4> </a>
                            <div class="uk-accordion-content uk-margin-remove-top" hidden>
                                <div class="tm-course-section-list">
                                    <ul>
                                        <li>
                                            <a href="Course-lesson.html" class="uk-link-reset">
                                                <!-- Play icon  -->
                                                <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                <!-- Course title  -->
                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Consectetur ipsum dolor sit  </div>
                                                <!-- preview link -->
                                            </a>
                                            <a class="uk-link-reset uk-margin-large-right uk-position-center-right uk-padding-small uk-text-small uk-visible@s" href="#preview-video-1" uk-toggle> <i class="fas fa-play icon-small uk-text-grey"></i> Preveiw  </a>
                                            <!-- time -->
                                            <span class="uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i>  2 min</span>
                                        </li>
                                        <li>
                                            <a href="Course-lesson.html" class="uk-link-reset">
                                                <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right">Dolor sit amet  consectetur  </div>
                                                <span class="uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i>  6 min</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="Course-lesson.html" class="uk-link-reset">
                                                <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right"> sed do eiusmod tempor incididunt</div>
                                                <span class="uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i> 8 min</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="Course-lesson.html" class="uk-link-reset">
                                                <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-medium-right"> Eiusmod tempor incididunt</div>
                                                <span class="uk-position-center-right time uk-margin-right"> <i class="fas fa-clock icon-small"></i>  12 min</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <!-- Model  Preview videos-->
                    <div id="preview-video-1" uk-modal>
                        <div class="uk-modal-dialog uk-margin-auto-vertical">
                            <button class="uk-modal-close-outside" type="button" uk-close></button>
                            <div class="video-responsive">
                                <iframe src="https://www.youtube.com/embed/nOCXXHGMezU" class="uk-padding-remove" uk-video="automute: true" frameborder="0" allowfullscreen uk-responsive></iframe>
                            </div>
                        </div>
                    </div>
                    <!-- Model  Preview videos-->
                    <div id="preview-video-2" uk-modal>
                        <div class="uk-modal-dialog uk-margin-auto-vertical">
                            <button class="uk-modal-close-outside" type="button" uk-close></button>
                            <div class="video-responsive">
                                <iframe src="https://www.youtube.com/embed/nOCXXHGMezU" class="uk-padding-remove" uk-video="automute: true" frameborder="0" allowfullscreen uk-responsive></iframe>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Discussions tab  -->
                <div id="Reviews" class="tabcontent animation: uk-animation-slide-right-medium">
                    <h3>Reviews</h3>
                    <div class="uk-padding-small uk-background-light uk-position-relative">
                        <div class="uk-flex-middle uk-grid-small uk-grid-stack" uk-grid>
                            <div class="uk-width-1-6 uk-flex-first uk-first-column">
                                <img src="../assets/images/avatures/avature-3.png" alt="Image" class="uk-width-1-2 uk-border-circle">
                            </div>
                            <div class="uk-width-5-6">
                                <p class="uk-margin-remove-bottom uk-text-bold uk-text-small">John keniss  </p>
                                <p class="uk-margin-remove">Etiam sit amet augue non velit aliquet consectetur. Proin gravida, odio in facilisis pharetra, neque enim aliquam eros,.</p>
                            </div>
                        </div>
                    </div>
                    <div class="uk-padding-small uk-background-light uk-position-relative">
                        <div class="uk-flex-middle uk-grid-small uk-grid-stack" uk-grid>
                            <div class="uk-width-1-6 uk-flex-first uk-first-column">
                                <img src="../assets/images/avatures/avature-5.png" alt="Image" class="uk-width-1-2 uk-border-circle">
                            </div>
                            <div class="uk-width-5-6">
                                <p class="uk-margin-remove-bottom uk-text-bold uk-text-small">John keniss  </p>
                                <p class="uk-margin-remove">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                    </div>
                    <div class="uk-padding-small uk-background-light uk-position-relative">
                        <div class="uk-flex-middle uk-grid-small uk-grid-stack" uk-grid>
                            <div class="uk-width-1-6 uk-flex-first uk-first-column">
                                <img alt="Image" src="../assets/images/avatures/avature.jpg" class="uk-width-1-2 uk-border-circle">
                            </div>
                            <div class="uk-width-5-6">
                                <p class="uk-margin-remove-bottom uk-text-bold uk-text-small">John keniss  </p>
                                <p class="uk-margin-remove">Maecenas vel dolor sit amet ligula interdum tempor id eu ipsum. Suspendisse pharetra risus ut metus elementum pulvinar. Mauris eget varius tellus. Cras et lorem vel nunc gravida porttitor.</p>
                            </div>
                        </div>
                    </div>
                    <div class="uk-padding-small uk-background-light uk-position-relative">
                        <div class="uk-flex-middle uk-grid-small uk-grid-stack" uk-grid>
                            <div class="uk-width-1-6 uk-flex-first uk-first-column">
                                <img src="../assets/images/avatures/avature-1.png" alt="Image" class="uk-width-1-2 uk-border-circle">
                            </div>
                            <div class="uk-width-5-6">
                                <p class="uk-margin-remove-bottom uk-text-bold uk-text-small">John keniss  </p>
                                <p class="uk-margin-remove">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                    </div>
                    <div class="uk-padding-small uk-background-light uk-position-relative">
                        <div class="uk-flex-middle uk-grid-small uk-grid-stack" uk-grid>
                            <div class="uk-width-1-6 uk-flex-first uk-first-column">
                                <img src="../assets/images/avatures/avature-2.png" alt="Image" class="uk-width-1-2 uk-border-circle">
                            </div>
                            <div class="uk-width-5-6">
                                <p class="uk-margin-remove-bottom uk-text-bold uk-text-small">John keniss  </p>
                                <p class="uk-margin-remove">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                    </div>
                    <div class="uk-padding-small uk-background-light uk-position-relative">
                        <div class="uk-flex-middle uk-grid-small uk-grid-stack" uk-grid>
                            <div class="uk-width-1-6 uk-flex-first uk-first-column">
                                <img src="../assets/images/avatures/avature-4.png" alt="Image" class="uk-width-1-2 uk-border-circle">
                            </div>
                            <div class="uk-width-5-6">
                                <p class="uk-margin-remove-bottom uk-text-bold uk-text-small">John keniss  </p>
                                <p class="uk-margin-remove">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                    </div>
                    <div class="uk-padding-small uk-background-light uk-position-relative">
                        <div class="uk-flex-middle uk-grid-small uk-grid-stack" uk-grid>
                            <div class="uk-width-1-6 uk-flex-first uk-first-column">
                                <img src="../assets/images/avatures/avature-3.png" alt="Image" class="uk-width-1-2 uk-border-circle">
                            </div>
                            <div class="uk-width-5-6">
                                <p class="uk-margin-remove-bottom uk-text-bold uk-text-small">John keniss  </p>
                                <p class="uk-margin-remove">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                    </div>
                    <div class="uk-padding-small uk-background-light uk-position-relative">
                        <div class="uk-flex-middle uk-grid-small uk-grid-stack" uk-grid>
                            <div class="uk-width-1-6 uk-flex-first uk-first-column">
                                <img src="../assets/images/avatures/avature-4.png" alt="Image" class="uk-width-1-2 uk-border-circle">
                            </div>
                            <div class="uk-width-5-6">
                                <p class="uk-margin-remove-bottom uk-text-bold uk-text-small">John keniss  </p>
                                <p class="uk-margin-remove">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Exercise-Files  -->
                <div id="Instructor" class="tabcontent animation: uk-animation-slide-right-medium">
                    <h2 class="uk-heading-line uk-text-center"><span> Meet the instructor  </span></h2>
                    <div class="uk-grid-small  uk-margin-medium-top uk-padding-small" uk-grid>
                        <div class="uk-width-1-4@m uk-first-column">
                            <img alt="Image" class="uk-width-2-3 uk-margin-small-top uk-margin-small-bottom uk-border-circle uk-box-shadow-large  uk-animation-scale-up" src="../assets/images/avatures/instructor.jpg">
                            <div class="uk-text-small uk-margin-small-top">
                                <p> <i class="fas fa-star"></i> 4.6 Instructor Rating </p>
                                <p> <i class="fas fa-comment-dots"></i>  89,072Reviews </p>
                                <p> <i class="fas fa-user"></i> 485,420Students </p>
                                <p> <i class="fas fa-play"></i> 4Courses </p>
                            </div>
                        </div>
                        <div class="uk-width-3-4@m uk-padding-remove-left">
                            <h4 class="uk-margin-remove"> Masriam keny </h4>
                            <span class="uk-text-small">  Web Developer, Designer, and Teacher </span>
                            <hr class="uk-margin-small">
                            <p class="uk-margin-remove-top uk-margin-small-bottom">Hi, I'm Jonas! I have Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim   laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat .</p>
                            <b> Magna consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud  suscipit lobortis nisl ut aliquip ex ea commodo consequat</b>
                            <p> Laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat </p>
                            <p>   aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat . </p>
                            <p>    Lobortis nisl ut aliquip ex ea commodo consequat . </p>
                        </div>
                    </div>
                    <h3 class="uk-heading-line uk-text-center uk-margin-medium-top"><span> Other Courses of This Instructure </span></h3>
                    <div class="uk-position-relative uk-visible-toggle" uk-slider>
                        <ul class="uk-slider-items ebook uk-child-width-1-3@m uk-child-width-1-3@s uk-grid">
                            <li class="uk-active">
                                <a href="Course-intro-one.html">
                                    <div class="uk-card-default uk-card-hover  uk-card-small Course-card uk-inline-clip">
                                        <img src="../assets/images/Courses/course-1.jpg" class="course-img">
                                        <div class="uk-card-body">
                                            <h4>Beginning JavaScript </h4>
                                            <p> Lorem ipsum dolor sit amet tempor  consectetur adipiscing  </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="uk-active">
                                <a href="Course-intro-one.html">
                                    <div class="uk-card-default uk-card-hover  uk-card-small Course-card uk-inline-clip">
                                        <img src="../assets/images/Courses/course-3.jpg" class="course-img">
                                        <div class="uk-card-body">
                                            <h4>Beginning JavaScript </h4>
                                            <p> Lorem ipsum dolor sit amet tempor  consectetur adipiscing  </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="uk-active">
                                <a href="Course-intro-one.html">
                                    <div class="uk-card-default uk-card-hover  uk-card-small Course-card uk-inline-clip">
                                        <img src="../assets/images/Courses/course-4.jpg" class="course-img">
                                        <div class="uk-card-body">
                                            <h4>Beginning JavaScript </h4>
                                            <p> Lorem ipsum dolor sit amet tempor  consectetur adipiscing  </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="Course-intro-one.html">
                                    <div class="uk-card-default uk-card-hover  uk-card-small Course-card uk-inline-clip">
                                        <img src="../assets/images/Courses/course-5.jpg" class="course-img">
                                        <div class="uk-card-body">
                                            <h4>Beginning JavaScript </h4>
                                            <p> Lorem ipsum dolor sit amet tempor  consectetur adipiscing  </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="Course-intro-one.html">
                                    <div class="uk-card-default uk-card-hover  uk-card-small Course-card uk-inline-clip">
                                        <img src="../assets/images/Courses/course-6.jpg" class="course-img">
                                        <div class="uk-card-body">
                                            <h4>Beginning JavaScript </h4>
                                            <p> Lorem ipsum dolor sit amet tempor  consectetur adipiscing  </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin">
                            <li uk-slider-item="0" class="">
                                <a href="#"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- side contant -->
            <div class="uk-width-1-3@m uk-visible@m">
                <h3 class="uk-text-bold"> Related Courses </h3>
                <div class="uk-card-default uk-card-hover uk-card-small Course-card uk-inline-clip uk-margin-medium-bottom">
                    <a href="Course-intro-one.html" class="uk-link-reset">
                        <img src="../assets/images/courses/course-1.jpg" class="course-img">
                        <div class="uk-card-body">
                            <h4>Build from Scratch</h4>
                            <p> Lorem ipsum dolor sit amet tempor consectetur adipiscing elit, sed do eiusmod tempor ... </p>
                            <hr class="uk-margin-remove-top">
                            <a class="Course-tags uk-margin-small-right tags-active" href="Course-all-tags.html"> JavaScript </a>
                            <a class="Course-tags" href="Course-all-tags.html"> Beginner </a>
                        </div>
                    </a>
                </div>
                <div class="uk-card-default uk-card-hover uk-card-small Course-card uk-inline-clip uk-margin-medium-bottom">
                    <a href="Course-intro-one.html" class="uk-link-reset">
                        <img src="../assets/images/courses/course-2.jpg" class="course-img">
                        <div class="uk-card-body">
                            <h4> How to Create A Website</h4>
                            <p> Lorem ipsum dolor sit amet tempor consectetur adipiscing elit, sed do eiusmod tempor ...</p>
                            <hr class="uk-margin-remove-top">
                            <a class="Course-tags uk-margin-small-right tags-active" href="Course-all-tags.html"> JavaScript </a>
                            <a class="Course-tags" href="Course-all-tags.html"> Beginner </a>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
