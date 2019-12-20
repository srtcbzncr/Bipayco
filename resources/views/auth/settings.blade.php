@extends('layouts.app')
@section('content')
    <div class="uk-container">
        <div class="admin-content uk-margin-large-top">
            <div class="admin-content-inner">
                <div class="uk-card uk-card-default uk-align-center" style="max-width: 75%">
                    <div class="uk-card-body">
                        <div uk-grid class="uk-flex-center uk-width">
                            <div uk-filter="target: .js-filter" class="uk-margin-large-top">
                                <ul class="uk-subnav uk-subnav-pill uk-width-1-3@l" style=" border-bottom: 1px solid #e5e5e5">
                                    <li class="uk-active " uk-filter-control=".tag-personal"  ><a href="#"><i class="fas fa-user uk-margin-small-right"></i>@lang('front/auth.personal_info')</a></li>
                                    <li uk-filter-control=".tag-photo"><a href="#" ><i class="fas fa-camera uk-margin-small-right "></i>@lang('front/auth.profile_photo')</a></li>
                                    <li uk-filter-control=".tag-security"><a href="#"><i class="fas fa-lock uk-margin-small-right"></i> @lang('front/auth.security')</a></li>
                                </ul>
                                <div class="uk-width uk-flex">
                                    <ul class="js-filter" style="list-style-type:none">
                                        <li class="tag-personal">
                                            <form method="POST" action="{{ route('updatePersonalData') }}" class="uk-flex-center">
                                                @csrf
                                                <div class="uk-width uk-child-width uk-grid-stack">
                                                    <div class="">
                                                        <div>
                                                            <div class="uk-form-label"> @lang('front/auth.first_name') </div>
                                                            <input class="uk-input" name="first_name" type="text" placeholder="@lang('front/auth.first_name')" value="{{$user->first_name}}" required>
                                                        </div>
                                                        <div>
                                                            <div class="uk-form-label"> @lang('front/auth.last_name')  </div>
                                                            <input class="uk-input" name="last_name" type="text" placeholder="@lang('front/auth.last_name')" value="{{$user->last_name}}" required>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <div>
                                                            <div class="uk-form-label"> @lang('front/auth.email')  </div>
                                                            <input class="uk-input" name="email" type="text" placeholder="@lang('front/auth.email')" value="{{$user->email}}" required>
                                                        </div>
                                                        <div>
                                                            <div class="uk-form-label"> @lang('front/auth.phone_number')  </div>
                                                            <input class="uk-input" name="phone_number" type="text" placeholder="@lang('front/auth.phone_number')" value="{{$user->phone_number}}" required>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <div class="uk-form-label">@lang('front/auth.city') </div>
                                                        <provinces city-default="@lang('front/auth.province')" district-default="@lang('front/auth.district')"></provinces>
                                                    </div>
                                                </div>
                                                <input class="uk-button uk-button-grey button uk-margin" type="submit" value="@lang('front/auth.save')">
                                            </form>
                                        </li>
                                        <li class="tag-photo uk-flex-center">
                                            <p>@lang('front/auth.profile_photo')</p>
                                            <form method="POST" action="{{ route('updateAvatar') }}" enctype="multipart/form-data">
                                                @csrf
                                               <!-- style=" border-bottom: 1px solid #e5e5e5"-->
                                                    <div class="uk-grid-stack">
                                                        <img src="{{asset(Auth::user()->avatar)}}" class="uk-margin uk-height-medium uk-width-medium"><br>
                                                        <input name="avatar" type="file" accept="image/*" class="uk-width-small"  required/><br>
                                                        <input class="uk-button uk-button-grey button uk-margin" type="submit" value="@lang('front/auth.save')">
                                                    </div>
                                            </form>
                                        </li>
                                        <li class="tag-security uk-flex-center" >
                                            <form class="uk-grid-small" uk-grid method="POST" action="{{ route('updatePassword') }}">
                                                @csrf
                                                <div class="uk-width uk-grid-stack">
                                                    <div class="uk-width uk-child-width-1-2@l uk-grid">
                                                        <div>
                                                            <div class="uk-form-label"> @lang('front/auth.password_old') </div>
                                                            <input class="uk-input" name="old_password" type="password" placeholder="@lang('front/auth.password_old')" required>
                                                        </div>
                                                        <div>
                                                            <div class="uk-form-label"> @lang('front/auth.password_new')  </div>
                                                            <input class="uk-input" name="new_password" type="password" placeholder="@lang('front/auth.password_new')" required>
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
                </div>
                <statu
                    statu-name="@lang('front/auth.instructor')"
                    title="@lang('front/auth.title')"
                    id-num="@lang('front/auth.id_num')"
                    bio="@lang('front/auth.bio')"
                    iban="@lang('front/auth.iban')"
                    ref-code="@lang('front/auth.referance_code')"
                    sign-in="@lang('front/auth.save')"
                    action-address="#"

                ></statu>
            </div>
        </div>
    </div>
@endsection
