@extends('layouts.app')

@section('content')
    <div class="admin-content">
        <nav class="uk-navbar">
            <!-- navbar -->
            <div class="uk-navbar-left">
                <ul class="uk-navbar-nav">
                    <li class="uk-active">
                        <a href="index.html">Dashboard</a>
                    </li>
                </ul>
            </div>
            <!-- right navbar  -->
            <div class="uk-navbar-right">
                <!-- User profile -->
                <a href="#">
                    <img src="../assets/images/avatures/avature-2.png" alt="" class="uk-border-circle user-profile-tiny">
                </a>
                <div uk-dropdown="pos: top-right ;mode : click ;animation: uk-animation-slide-bottom-small" class="uk-dropdown uk-padding-small angle-top-right uk-dropdown-bottom-right" >
                    <p class="uk-margin-remove-bottom uk-margin-small-top uk-text-bold"> Hamse Mohamoud  </p>
                    <ul class="uk-nav uk-dropdown-nav">
                        <li>
                            <a href="Profile.html"> <i class="fas fa-user uk-margin-small-right"></i> Profile</a>
                        </li>
                        <li>
                            <a href="admin-edite-profile.html"> <i class="fas fa-cog uk-margin-small-right"></i> Setting</a>                                 </li>
                        <li class="uk-nav-divider"></li>
                        <li>
                            <a href="admin-login.html"> <i class="fas fa-sign-out-alt uk-margin-small-right"></i> Log out</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="admin-content-inner">
            <div class="uk-child-width-1-3@m uk-child-width-1-2 uk-grid-match " uk-grid>
                <div>
                    <div class="uk-background-cover uk-light dashboard-card" data-src="../assets/images/admin/cards-bg.jpg" uk-img>
                        <i class="fas fa-play icon-xxlarge uk-visible@m"></i>
                        <h3> 32 Course </h3>
                        <p> pro detracto disputando reformidans at</p>
                        <a href="#"> View All </a>
                    </div>
                </div>
                <div>
                    <div class="uk-background-cover uk-light dashboard-card" data-src="../assets/images/admin/cards-bg.jpg" uk-img>
                        <i class="far fa-user icon-xxlarge uk-visible@m"></i>
                        <h3> 120 User </h3>
                        <p>  pro detracto disputando reformidans at </p>
                        <a href="#"> View All </a>
                    </div>
                </div>
                <div>
                    <div class="uk-background-cover uk-light dashboard-card" data-src="../assets/images/admin/cards-bg.jpg" uk-img>
                        <i class="fas fa-code icon-xxlarge uk-visible@m"></i>
                        <h3> 10 Script </h3>
                        <p>  pro detracto disputando reformidans at </p>
                        <a href="#"> View All </a>
                    </div>
                </div>
            </div>

            <div uk-grid>
                <div class="uk-width-1-2@m">
                    <div class="uk-card-small uk-card-default">
                        <div class="uk-card-header uk-text-bold">
                            <i class="fas fa-users uk-margin-small-right"></i> Latest  Regsiter users
                        </div>
                        <div class="uk-card-body uk-padding-remove-top">
                            <div class="uk-child-width-1-4@m uk-child-width-1-2 uk-grid-collapse uk-flex-center"  uk-scrollspy="target: > div; cls:uk-animation-scale-up; delay: 100" uk-grid>
                                <div>
                                    <a href="Profile.html" class="uk-link-reset">
                                        <div class="uk-padding-remove   uk-text-center">
                                            <img alt="Image" class="uk-width-2-3 uk-margin-top uk-margin-small-bottom uk-border-circle uk-align-center uk-box-shadow-large" src="../assets/images/avatures/avature-1.png">
                                            <h5 class="uk-margin-remove-bottom uk-margin-remove-top ">Quen smith</h5>
                                        </div>
                                    </a>
                                </div>
                                <div>
                                    <a href="Profile.html" class="uk-link-reset">
                                        <div class="uk-padding-remove   uk-text-center">
                                            <img alt="Image" class="uk-width-2-3 uk-margin-top uk-margin-small-bottom uk-border-circle uk-align-center uk-box-shadow-large" src="../assets/images/avatures/avature-2.png">
                                            <h5 class="uk-margin-remove-bottom uk-margin-remove-top ">John smith</h5>
                                        </div>
                                    </a>
                                </div>
                                <div>
                                    <a href="Profile.html" class="uk-link-reset">
                                        <div class="uk-padding-remove   uk-text-center">
                                            <img alt="Image" class="uk-width-2-3 uk-margin-top uk-margin-small-bottom uk-border-circle uk-align-center uk-box-shadow-large" src="../assets/images/avatures/avature-3.png">
                                            <h5 class="uk-margin-remove-bottom uk-margin-remove-top ">Sakhay smith</h5>
                                        </div>
                                    </a>
                                </div>
                                <div>
                                    <a href="Profile.html" class="uk-link-reset">
                                        <div class="uk-padding-remove   uk-text-center">
                                            <img alt="Image" class="uk-width-2-3 uk-margin-top uk-margin-small-bottom uk-border-circle uk-align-center uk-box-shadow-large" src="../assets/images/avatures/avature-4.png">
                                            <h5 class="uk-margin-remove-bottom uk-margin-remove-top ">Quen smith</h5>
                                        </div>
                                    </a>
                                </div>
                                <div>
                                    <a href="Profile.html" class="uk-link-reset">
                                        <div class="uk-padding-remove   uk-text-center">
                                            <img alt="Image" class="uk-width-2-3 uk-margin-top uk-margin-small-bottom uk-border-circle uk-align-center uk-box-shadow-large" src="../assets/images/avatures/avature-3.png">
                                            <h5 class="uk-margin-remove-bottom uk-margin-remove-top ">Moli smith</h5>
                                        </div>
                                    </a>
                                </div>
                                <div>
                                    <a href="Profile.html" class="uk-link-reset">
                                        <div class="uk-padding-remove   uk-text-center">
                                            <img alt="Image" class="uk-width-2-3 uk-margin-top uk-margin-small-bottom uk-border-circle uk-align-center uk-box-shadow-large" src="../assets/images/avatures/avature-2.png">
                                            <h5 class="uk-margin-remove-bottom uk-margin-remove-top ">Quen smith</h5>
                                        </div>
                                    </a>
                                </div>
                                <div>
                                    <a href="Profile.html" class="uk-link-reset">
                                        <div class="uk-padding-remove   uk-text-center">
                                            <img alt="Image" class="uk-width-2-3 uk-margin-top uk-margin-small-bottom uk-border-circle uk-align-center uk-box-shadow-large" src="../assets/images/avatures/avature-1.png">
                                            <h5 class="uk-margin-remove-bottom uk-margin-remove-top ">Quen smith</h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-width-1-2@m">
                    <div class="uk-card-small uk-card-default">
                        <div class="uk-card-header uk-text-bold">
                            <i class="fas fa-comment uk-margin-small-right"></i> Latest  Comments
                        </div>
                        <div class="uk-card-body">
                            <img class="user-profile-medium uk-align-left uk-margin-small-right uk-margin-small-bottom" src="../assets/images/avatures/avature-1.png" width="60"  alt="Example image">
                            <p class="uk-margin-remove-top">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>
                            <hr>
                            <img class="user-profile-medium uk-align-left uk-margin-small-right uk-margin-small-bottom" src="../assets/images/avatures/avature-1.png" width="60" alt="Example image">
                            <p class="uk-margin-remove-top">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
                            <hr>
                            <img class="user-profile-medium uk-align-left uk-margin-small-right uk-margin-small-bottom" src="../assets/images/avatures/avature-1.png" width="60"  alt="Example image">
                            <p class="uk-margin-remove-top">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
