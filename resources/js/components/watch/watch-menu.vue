<template>
    <div class="tm-filters uk-background-default" id="filters">
        <div class="uk-padding-remove uk-preserve-color">
            <!-- Sidebar menu-->
            <ul class="uk-child-width-expand uk-tab tm-side-course-nav uk-margin-remove uk-position-z-index" uk-switcher="animation: uk-animation-slide-right-medium, uk-animation-slide-left-small" style="    box-shadow: 3px 0px 7px 1px gainsboro;" uk-switcher>
                <li class="uk-active">
                    <a href="#" uk-tooltip="title: Course Videos ; delay: 200 ; pos: bottom-left ;animation:uk-animation-scale-up"> <i class="fas fa-video icon-medium"></i>  Videos </a>
                </li>
                <li>
                    <a href="#" uk-tooltip="title: Course Files ; delay: 200 ; pos: bottom-center ;animation:uk-animation-scale-up"> <i class="fas fa-folder icon-medium"></i>  Files </a>
                </li>
                <li>
                    <a href="#" uk-tooltip="title: Course Exercise ; delay: 200 ; pos: bottom-right ;animation:uk-animation-scale-up"> <i class="fas fa-file-archive icon-medium"></i> Exercise</a>
                </li>
            </ul>
            <!-- Sidebar contents -->
            <ul class="uk-switcher uk-height-max-large uk-overflow-auto">
                <!-- Course Video tab  -->
                <li>
                    <div class="demo1 tab-video" data-simplebar>
                        <ul uk-accordion>
                            <!-- section one -->
                            <li class="uk-open tm-course-lesson-section uk-background-default">
                                <a class="uk-accordion-title  uk-padding-small" href="#"><h6> section  one</h6> <h4 class="uk-margin-remove"> Introduction to basic HTML</h4> </a>
                                <div class="uk-accordion-content uk-margin-remove-top">
                                    <div class="tm-course-section-list">
                                        <ul>
                                            <a href="#" class="uk-link-reset tablinks" onclick="openTabs(event,'one')" id="defaultOpen" uk-toggle="target: #course-1-1; cls: watched">
                                                <li id="course-1-1" class="watched">
                                                    <span class="uk-icon-button icon-play"> <i class="fas fa-play icon-small"></i> </span>
                                                    <div class="uk-panel uk-panel-box uk-text-truncate uk-margin-large-right">Lesson 1 Introduction to html ...</div>
                                                    <a class="uk-icon-button uk-link-reset uk-margin-small-right uk-icon uk-button-success uk-position-center-right uk-animation-scale-up" href="#" style="display:none"> <i class="fas fa-check-circle icon-small  uk-text-white"></i> </a>
                                                    <span class="uk-position-center-right time uk-margin-medium-right">  2 min</span>
                                                </li>
                                            </a>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--  Course resource  tab  -->
                <li>
                    <div class="demo1 uk-background-default" data-simplebar>
                        <img src="#" width="200" class="uk-margin-remove-bottom uk-align-center uk-width-2-3" alt="">
                        <p class="uk-padding-small uk-margin-remove uk-text-center uk-padding-remove-top">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod dolore .</p>
                        <h4 class="uk-heading-line uk-text-center uk-margin-top"><span>Requirements </span></h4>
                        <p class="uk-padding-small uk-margin-remove  uk-padding-remove-top uk-text-center">Etiam sit amet augue non velit aliquet consectetur molestie eros mauris  .</p>
                        <h5 class="uk-padding-small uk-margin-remove uk-background-muted uk-text-black">  Web browser</h5>
                        <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-4  uk-margin-small-top">
                                <img src="#" alt="Image" class="uk-align-center img-small">
                            </div>
                            <div class="uk-width-3-4 uk-padding-remove-left">
                                <p class="uk-margin-remove-bottom uk-text-bold  uk-text-small uk-margin-small-top">Firefox  </p>
                                <p class="uk-margin-remove-top uk-margin-small-bottom">Lorem ipsum dolor adipiscing elit, sed do eiusmod tempor ...</p>
                                <a class="Course-tags uk-margin-small-right border-radius-6" href="#"> Official site </a>
                                <a class="Course-tags uk-margin-small-right  border-radius-6 tags-active" href="#"> Download </a>
                            </div>
                        </div>
                        <hr class="uk-margin-remove-bottom">
                        <div class="uk-grid-small uk-margin-small-top" uk-grid>
                            <div class="uk-width-1-4  uk-margin-small-top">
                                <img src="#" alt="Image" class="uk-align-center img-small">
                            </div>
                            <div class="uk-width-3-4 uk-padding-remove-left">
                                <p class="uk-margin-remove-bottom uk-text-bold  uk-text-small uk-margin-small-top">Google Chrome  </p>
                                <p class="uk-margin-remove-top uk-margin-small-bottom">Lorem ipsum dolor adipiscing elit, sed do eiusmod tempor ...</p>
                                <a class="Course-tags uk-margin-small-right border-radius-6" href="#"> Official site </a>
                                <a class="Course-tags uk-margin-small-right  border-radius-6 tags-active" href="#"> Download </a>
                            </div>
                        </div>
                        <hr class="uk-margin-remove-bottom">
                        <div class="uk-grid-small uk-margin-small-top" uk-grid>
                            <div class="uk-width-1-4  uk-margin-small-top">
                                <img src="#" alt="Image" class="uk-align-center img-small">
                            </div>
                            <div class="uk-width-3-4 uk-padding-remove-left">
                                <p class="uk-margin-remove-bottom uk-text-bold  uk-text-small uk-margin-small-top">UCBrwoser    </p>
                                <p class="uk-margin-remove-top uk-margin-small-bottom">Lorem ipsum dolor adipiscing elit, sed do eiusmod tempor ...</p>
                                <a class="Course-tags uk-margin-small-right border-radius-6" href="#"> Official site </a>
                                <a class="Course-tags uk-margin-small-right  border-radius-6 tags-active" href="#"> Download </a>
                            </div>
                        </div>
                        <h5 class="uk-padding-small uk-margin-remove-bottom uk-background-muted uk-text-black"> Text Editor </h5>
                        <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-4  uk-margin-small-top">
                                <img src="#" alt="Image" class="uk-align-center img-small">
                            </div>
                            <div class="uk-width-3-4 uk-padding-remove-left">
                                <p class="uk-margin-remove-bottom uk-text-bold  uk-text-small uk-margin-small-top">Atom  </p>
                                <p class="uk-margin-remove-top uk-margin-small-bottom">Lorem ipsum dolor adipiscing elit, sed do eiusmod tempor ...</p>
                                <a class="Course-tags uk-margin-small-right border-radius-6" href="#"> Official site </a>
                                <a class="Course-tags uk-margin-small-right  border-radius-6 tags-active" href="#"> Download </a>
                            </div>
                        </div>
                        <hr class="uk-margin-remove-bottom">
                        <div class="uk-grid-small uk-margin-small-top" uk-grid>
                            <div class="uk-width-1-4  uk-margin-small-top">
                                <img src="#" alt="Image" class="uk-align-center img-small">
                            </div>
                            <div class="uk-width-3-4 uk-padding-remove-left">
                                <p class="uk-margin-remove-bottom uk-text-bold  uk-text-small uk-margin-small-top">Dreamweaver </p>
                                <p class="uk-margin-remove-top uk-margin-small-bottom">Lorem ipsum dolor adipiscing elit, sed do eiusmod tempor ...</p>
                                <a class="Course-tags uk-margin-small-right border-radius-6" href="#"> Official site </a>
                                <a class="Course-tags uk-margin-small-right  border-radius-6 tags-active" href="#"> Download </a>
                            </div>
                        </div>
                        <hr class="uk-margin-remove-bottom">
                        <div class="uk-grid-small uk-margin-small-top" uk-grid>
                            <div class="uk-width-1-4  uk-margin-small-top">
                                <img src="#" alt="Image" class="uk-align-center img-small">
                            </div>
                            <div class="uk-width-3-4 uk-padding-remove-left">
                                <p class="uk-margin-remove-bottom uk-text-bold  uk-text-small uk-margin-small-top">Sublime   </p>
                                <p class="uk-margin-remove-top uk-margin-small-bottom">Lorem ipsum dolor adipiscing elit, sed do eiusmod tempor ...</p>
                                <a class="Course-tags uk-margin-small-right border-radius-6" href="#"> Official site </a>
                                <a class="Course-tags uk-margin-small-right  border-radius-6 tags-active" href="#"> Download </a>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Exicse  tab  -->
                <li>
                    <div class="demo1 uk-background-muted" data-simplebar>
                        <ul class="uk-padding-small" uk-accordion>
                            <li class="tm-course-lesson-section  uk-background-default uk-open">
                                <a class="uk-accordion-title   uk-padding-small" href="#"> <h6> section  one </h6> <h4 class="uk-margin-remove"> Introduction Course</h4></a>
                                <div class="uk-accordion-content uk-margin-remove-top">
                                    <!-- Exerice files-->
                                    <ul class="uk-active uk-background-default" uk-accordion>
                                        <li class="uk-open tm-course-lesson-section">
                                            <a class="uk-accordion-title  uk-padding-small uk-background-muted uk-padding-remove-bottom" href="#"> <h6> <i class="fas fa-folder"></i>   Lesson  one</h6> </a>
                                            <div class="uk-accordion-content uk-margin-remove-top">
                                                <div class="tm-course-section-list">
                                                    <ul>
                                                        <li>
                                                            <i class="fas fa-file-alt   uk-margin-small-right icon-medium"></i>
                                                            File one
                                                            <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 500 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                        </li>
                                                        <li>
                                                            <i class="fas fa-file-alt   uk-margin-small-right icon-medium"></i>
                                                            File two
                                                            <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 500 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                        </li>
                                                        <li>
                                                            <i class="fas fa-file-alt   uk-margin-small-right icon-medium"></i>
                                                            File three
                                                            <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 500 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="tm-course-lesson-section uk-margin-remove-top">
                                            <a class="uk-accordion-title  uk-padding-small uk-background-muted uk-padding-remove-bottom" href="#"> <h6> <i class="fas fa-folder"></i>  lesson  one</h6> </a>
                                            <div class="uk-accordion-content uk-margin-remove-top">
                                                <div class="tm-course-section-list">
                                                    <ul>
                                                        <li>
                                                            <i class="fas fa-file-alt   uk-margin-small-right icon-medium"></i>
                                                            File one
                                                            <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 500 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                        </li>
                                                        <li>
                                                            <i class="fas fa-file-alt   uk-margin-small-right icon-medium"></i>
                                                            File two
                                                            <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 500 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="tm-course-lesson-section  uk-background-default">
                                <a class="uk-accordion-title   uk-padding-small" href="#"> <h6> section  Two </h6> <h4 class="uk-margin-remove"> Introduction Course</h4></a>
                                <div class="uk-accordion-content uk-margin-remove-top">
                                    <!-- Exerice files-->
                                    <ul class="uk-active uk-background-default" uk-accordion>
                                        <li class="uk-open tm-course-lesson-section">
                                            <a class="uk-accordion-title  uk-padding-small uk-background-muted uk-padding-remove-bottom" href="#"> <h6> <i class="fas fa-folder"></i>   Lesspm  one</h6> </a>
                                            <div class="uk-accordion-content uk-margin-remove-top">
                                                <div class="tm-course-section-list">
                                                    <ul>
                                                        <li>
                                                            <i class="fas fa-file-alt   uk-margin-small-right icon-medium"></i>
                                                            File one
                                                            <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 500 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                        </li>
                                                        <li>
                                                            <i class="fas fa-file-alt   uk-margin-small-right icon-medium"></i>
                                                            File two
                                                            <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 500 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                        </li>
                                                        <li>
                                                            <i class="fas fa-file-alt   uk-margin-small-right icon-medium"></i>
                                                            File three
                                                            <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 500 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="tm-course-lesson-section uk-margin-remove-top">
                                            <a class="uk-accordion-title  uk-padding-small uk-background-muted uk-padding-remove-bottom" href="#"> <h6> <i class="fas fa-folder"></i>  Lesson  two</h6> </a>
                                            <div class="uk-accordion-content uk-margin-remove-top">
                                                <div class="tm-course-section-list">
                                                    <ul>
                                                        <li>
                                                            <i class="fas fa-file-alt   uk-margin-small-right icon-medium"></i>
                                                            File one
                                                            <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 200 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                        </li>
                                                        <li>
                                                            <i class="fas fa-file-alt   uk-margin-small-right icon-medium"></i>
                                                            File two
                                                            <a class="uk-icon-button uk-margin-small-right  uk-button-success uk-position-center-right" href="#" uk-tooltip="title: Download this file ; delay: 200 ; pos: left ; animation:uk-animation-scale-up"> <i class="fas fa-download icon-small"></i> </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "watch-menu"

    }
</script>

<style scoped>

</style>
