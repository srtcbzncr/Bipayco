@extends('layouts.app')
@section('content')
    <div class="admin-content">
        <div class="admin-content-inner">
            <div class="uk-card-small uk-card-default">
                <div class="uk-card-header uk-text-bold">
                    <i class="fas fa-user uk-margin-small-right"></i> Profile details
                </div>
                <div class="uk-card-body ">
                    <div uk-grid>
                        <div uk-filter="target: .js-filter">
                            <ul class="uk-subnav uk-subnav-pill">
                                <li uk-filter-control=".tag-personal"><a href="#">@lang('front/auth.')</a></li>
                                <li uk-filter-control=".tag-security"><a href="#">@lang('front/auth.')</a></li>
                                <li uk-filter-control=".tag-photo"><a href="#">@lang('front/auth.')</a></li>
                            </ul>
                            <ul class="js-filter">
                                <li class="tag-personal">
                                    <div class="uk-width-2-3@m">
                                        <form class="uk-grid-small" uk-grid method="POST" action="{{ route('updatePersonalData') }}">
                                            @csrf
                                            <div class="uk-width-1-2">
                                                <div class="uk-form-label"> First Name  </div>
                                                <input class="uk-input" name="first_name" type="text" placeholder="Your Name">
                                            </div>
                                            <div class="uk-width-1-2">
                                                <div class="uk-form-label"> Last name   </div>
                                                <input class="uk-input" name="last_name" type="text" placeholder="Your Last name">
                                            </div>
                                            <div class="uk-width-1-2">
                                                <div class="uk-form-label"> Email  </div>
                                                <input class="uk-input" name="email" type="text" placeholder="Your Email">
                                            </div>
                                            <div class="uk-width-1-2">
                                                <div class="uk-form-label"> Telephone  </div>
                                                <input class="uk-input" name="phone_number" type="text" placeholder="Your Telephone">
                                            </div>
                                            <provinces></provinces>
                                            <input class="uk-button uk-button-grey button uk-margin" type="submit" value="Sign in">
                                        </form>
                                    </div>
                                </li>
                                <li class="tag-photo">
                                    <div class="uk-width-2-3@m">
                                        <div class="uk-width-1-3@m">
                                            <p>Your profile photo</p>
                                            <form method="POST" action="{{ route('updateAvatar') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="fallback">
                                                    <input name="avatar" type="file"/>
                                                </div>-->
                                                <input class="uk-button uk-button-grey button uk-margin" type="submit" value="Sign in">
                                            </form>
                                            <p>Recomend size 50 x 50</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="tag-security">
                                    <div class="uk-width-2-3@m">
                                        <form class="uk-grid-small" uk-grid method="POST" action="{{ route('updatePassword') }}">
                                            @csrf
                                            <div class="uk-width-1-2">
                                                <div class="uk-form-label"> Old Password </div>
                                                <input class="uk-input" name="old_password" type="password" placeholder="Password">
                                            </div>
                                            <div class="uk-width-1-2">
                                                <div class="uk-form-label"> New Password </div>
                                                <input class="uk-input" name="new_password" type="password" placeholder="Password">
                                            </div>
                                            <input class="uk-button uk-button-grey button uk-margin" type="submit" value="Sign in">
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <user-status></user-status>
        </div>
    </div>
@endsection
