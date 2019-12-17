@extends('layouts.app')
@section('content')
    <div class="uk-container">
        <div class="admin-content uk-margin-large-top">
            <div class="admin-content-inner">
                <div class="uk-card-small ">
                    <div class="uk-card-body">
                        <div uk-grid>
                            <div uk-filter="target: .js-filter" class="uk-margin-medium-top">
                                <ul class="uk-subnav uk-subnav-pill" style=" border-bottom: 1px solid #e5e5e5" >
                                    <li class="uk-active" uk-filter-control=".tag-personal"  style="border-right: 1px solid #e5e5e5"><a href="#">@lang('front/auth.personal_info')</a></li>
                                    <li uk-filter-control=".tag-photo" style="border-right: 1px solid #e5e5e5"><a href="#">@lang('front/auth.profile_photo')</a></li>
                                    <li uk-filter-control=".tag-security" ><a href="#"> @lang('front/auth.security')</a></li>
                                </ul>
                                <ul class="js-filter" style="list-style-type:none">
                                    <li class="tag-personal">
                                        <form method="POST" action="{{ route('updatePersonalData') }}">
                                            @csrf
                                            <div class="uk-width-4-1@xl">
                                                <div class="uk-child-width-1-2 uk-grid">
                                                    <div>
                                                        <div class="uk-form-label"> @lang('front/auth.first_name') </div>
                                                        <input class="uk-input" name="first_name" type="text" placeholder="@lang('front/auth.first_name')">
                                                    </div>
                                                    <div>
                                                        <div class="uk-form-label"> @lang('front/auth.last_name')  </div>
                                                        <input class="uk-input" name="last_name" type="text" placeholder="@lang('front/auth.last_name')">
                                                    </div>
                                                </div>
                                                <div class="uk-child-width-2-1">
                                                    <div>
                                                        <div class="uk-form-label"> @lang('front/auth.email')  </div>
                                                        <input class="uk-input" name="email" type="text" placeholder="@lang('front/auth.email')">
                                                    </div>
                                                    <div>
                                                        <div class="uk-form-label"> @lang('front/auth.phone_number')  </div>
                                                        <input class="uk-input" name="phone_number" type="text" placeholder="@lang('front/auth.phone_number')">
                                                    </div>
                                                </div>
                                                <div class="uk-width-2-1@xl">
                                                    <div class="uk-form-label">@lang('front/auth.city') </div>
                                                    <provinces city-default="@lang('front/auth.province')" district-default="@lang('front/auth.district')"></provinces>
                                                </div>
                                                <input class="uk-button uk-button-grey button uk-margin" type="submit" value="@lang('front/auth.save')">
                                            </div>
                                        </form>
                                    </li>
                                    <li class="tag-photo">
                                        <div class="uk-width-1-2@xl">
                                            <p>@lang('front/auth.profile_photo')</p>
                                            <form method="POST" action="{{ route('updateAvatar') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="fallback">
                                                    <input name="avatar" type="file" accept="image/*"/>
                                                    <p>Recomend size 50 x 50</p>
                                                </div>
                                                <input class="uk-button uk-button-grey button uk-margin" type="submit" value="@lang('front/auth.save')">
                                            </form>
                                        </div>
                                    </li>
                                    <li class="tag-security">
                                        <form class="uk-grid-small" uk-grid method="POST" action="{{ route('updatePassword') }}">
                                            @csrf
                                            <div class="uk-width-2-1@s">
                                                <div class="uk-child-width-1-2@xl uk-grid">
                                                    <div class="">
                                                        <div class="uk-form-label"> @lang('front/auth.password_old') </div>
                                                        <input class="uk-input" name="old_password" type="password" placeholder="@lang('front/auth.password_old')">
                                                    </div>
                                                    <div class="">
                                                        <div class="uk-form-label"> @lang('front/auth.password_new')  </div>
                                                        <input class="uk-input" name="new_password" type="password" placeholder="@lang('front/auth.password_new')">
                                                    </div>
                                                </div>
                                                <div class="uk-width-expand uk-margin-top">
                                                    <input class="uk-button uk-button-grey button uk-margin" type="submit" value="@lang('front/auth.save')">
                                                </div>
                                            </div>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <user-status Instructor="true"></user-status>
            </div>
        </div>
    </div>
@endsection
