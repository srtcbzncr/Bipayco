@extends('layouts.app')
@section('content')
    <div class="uk-container uk-margin-medium-top">
        <div class="uk-card uk-card-default uk-align-center uk-margin-medium-bottom" style="max-width: 90%">
            <div class="uk-card-body">
                <div class="uk-flex-center uk-margin-remove">
                    <div uk-filter="target: .js-filter " class="uk-margin-large-top uk-margin-medium-right">
                        <ul class="uk-subnav uk-subnav-pill uk-child-width-1-3@m uk-width uk-grid-match" style=" border-bottom: 1px solid #e5e5e5">
                            <li class="{{session('personal_data')}}" uk-filter-control=".tag-personal"><a href="#"><span class="fas fa-user uk-margin-small-right"></span><b>@lang('front/auth.personal_info')</b></a></li>
                            <li class="{{session('photo')}}" uk-filter-control=".tag-photo"><a href="#"><span class="fas fa-camera uk-margin-small-right "></span><b>@lang('front/auth.profile_photo')</b></a></li>
                            <li class="{{session('security')}}" uk-filter-control=".tag-security"><a href="#"><span class="fas fa-lock uk-margin-small-right"></span><b>@lang('front/auth.password_change')</b></a></li>
                        </ul>
                        <div class="uk-width">
                            <ul class="js-filter" style="list-style-type:none">
                                <li class="tag-personal">
                                    <form method="POST" action="{{ route('updatePersonalData') }}">
                                        @csrf
                                        <div class="uk-grid-stack">
                                            <div class="uk-child-width-1-2@l uk-grid">
                                                <div>
                                                    <div class="uk-form-label"> @lang('front/auth.first_name') </div>
                                                    <input class="uk-input form-control @error('first_name') is-invalid @enderror" name="first_name" type="text" placeholder="@lang('front/auth.first_name')" value="{{$user->first_name}}" required>
                                                    @error('first_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <div class="uk-form-label"> @lang('front/auth.last_name')  </div>
                                                    <input class="uk-input form-control @error('last_name') is-invalid @enderror" name="last_name" type="text" placeholder="@lang('front/auth.last_name')" value="{{$user->last_name}}" required>
                                                    @error('last_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="uk-child-width-1-2@l uk-grid uk-margin-remove-top">
                                                <div>
                                                    <div class="uk-form-label"> @lang('front/auth.email')  </div>
                                                    <input class="uk-input form-control @error('email') is-invalid @enderror" name="email" type="text" placeholder="@lang('front/auth.email')" value="{{$user->email}}" required>
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <div class="uk-form-label"> @lang('front/auth.phone_number')  </div>
                                                    <input class="uk-input form-control @error('phone_number') is-invalid @enderror" name="phone_number" type="text" placeholder="@lang('front/auth.phone_number')" value="{{$user->phone_number}}" required>
                                                    @error('phone_number')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div>
                                                <div class="uk-form-label">@lang('front/auth.city') </div>
                                                <provinces city-default="@lang('front/auth.province')" district-default="@lang('front/auth.district')"
                                                           has-selected-option
                                                           selected-district-id="{{$user->district->id}}"
                                                           selected-district="{{$user->district->name}}"
                                                           selected-city-id="{{$user->district->city_id}}"
                                                           selected-city="{{$user->district->city->name}}"
                                                ></provinces>
                                            </div>
                                        </div>
                                        <input class="uk-button uk-button-grey button uk-margin" type="submit" value="@lang('front/auth.save')">
                                    </form>
                                </li>
                                <li class="tag-photo uk-flex align-items-center justify-content-center uk-flex-column">
                                       <!-- style=" border-bottom: 1px solid #e5e5e5"-->
                                    <form method="POST" action="{{ route('updateAvatar') }}"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="uk-flex align-items-center justify-content-center uk-flex-column">
                                            <img src="{{asset(Auth::user()->avatar)}}" class="uk-margin uk-height-medium uk-width-medium uk-border-circle uk-flex-center">
                                            <div uk-form-custom="target: true">
                                                <input name="avatar" type="file" accept="image/*"  required>
                                                <input class="uk-input uk-form-width-medium form-control @error('avatar') is-invalid @enderror" type="text" tabindex="-1" disabled placeholder="@lang('front/auth.select_file')">
                                                @error('avatar')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <input class="uk-button uk-button-grey button uk-margin" type="submit" value="@lang('front/auth.save')">
                                        </div>
                                    </form>
                                </li>
                                <li class="tag-security" >
                                    <form class="uk-form" method="POST" action="{{ route('updatePassword') }}">
                                        @csrf
                                        <div class="uk-grid-stack">
                                            <div class="uk-child-width-1-2@l uk-grid">
                                                <div>
                                                    <div class="uk-form-label"> @lang('front/auth.password_old') </div>
                                                    <div class="uk-inline uk-flex align-items-center" >
                                                        <input class="uk-input form-control @error('old_password') is-invalid @enderror" id="old_password" name="old_password" type="password" placeholder="@lang('front/auth.password_old')" required>
                                                        <a class="fas fa-eye" onclick="togglePassword('old_password')" style="margin-left: -30px"></a>
                                                        @error('old_password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="uk-form-label"> @lang('front/auth.password_new')</div>
                                                    <div class="uk-inline uk-flex align-items-center">
                                                        <input class="uk-input form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" type="password" placeholder="@lang('front/auth.password_new')" required>
                                                        <a class="fas fa-eye" onclick="togglePassword('new_password')" style="margin-left: -30px"></a>
                                                        @error('new_password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="uk-button uk-button-grey button uk-margin" type="submit" value="@lang('front/auth.save')">
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--@if($has_student_profile)
            <div class="uk-card uk-card-default uk-align-center uk-margin-medium-bottom" style="max-width: 90%">
                <div class="uk-card-header uk-text-bold">
                    <span class="fas icon-medium uk-margin-small-right fa-graduation-cap"></span>
                    @lang('front/auth.student_infos')
                </div>
                <div class="uk-card-body">
                    <div uk-grid class="uk-flex-center">
                        <div class="uk-width-large@m uk-padding-remove-top">
                            <fieldset class="uk-fieldset uk-margin-small-bottom">
                                <div class="uk-form-label"> @lang('front/auth.reference_code')  </div>
                                <div class="uk-flex uk-flex-wrap">
                                    <input class="uk-input uk-width-3-4@m" type="text" readonly name="reference_code" id="studentRefCode" value="{{$student_profile->reference_code}}" >
                                    <button class="uk-button uk-button-default uk-width-1-4@m" onclick="copyToClipboard('studentRefCode')"><i class="fas fa-copy icon-medium"></i> <span class="uk-hidden@m">@lang('front/auth.copy')</span></button>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        @endif-->
        @if($has_instructor_profile)
            <div class="uk-card uk-card-default uk-align-center uk-margin-medium-bottom" style="max-width: 90%">
                <div class="uk-card-header uk-text-bold">
                    <span class="fas icon-medium uk-margin-small-right fa-chalkboard-teacher"></span>
                    @lang('front/auth.instructor_infos')
                </div>
                <div class="uk-card-body">
                    <div uk-grid class="uk-flex-center">
                        <div class="uk-width-large@m uk-padding-remove-top">
                            <div class="uk-fieldset uk-margin-small-bottom">
                                <div>
                                    <div class="uk-form-label">@lang('front/auth.reference_code') </div>
                                    <div class="uk-flex uk-flex-wrap">
                                        <input class="uk-input uk-width-3-4@m" type="text" readonly id="instructorRefCode" name="reference_code" value="{{$instructor_profile->reference_code}}">
                                        <button class="uk-button uk-button-default uk-width-1-4@m" onclick="copyToClipboard('instructorRefCode')"><i class="fas fa-copy icon-medium"></i> <span class="uk-hidden@m">@lang('front/auth.copy')</span></button>
                                    </div>
                                </div>
                                <hr>
                                <form method="POST" action="{{route('updateInstructorData')}}">
                                    @csrf
                                    <div>
                                        <div>
                                            <div class="uk-form-label">@lang('front/auth.id_num') </div>
                                            <input class="uk-input form-control @error('identification_number') is-invalid @enderror" type="text"  name="identification_number" value="{{$instructor_profile->identification_number}}" required>
                                            @error('identification_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div>
                                            <div class="uk-form-label"> @lang('front/auth.title')  </div>
                                            <input class="uk-input form-control @error('title') is-invalid @enderror" type="text" name="title" value="{{$instructor_profile->title}}" required>
                                            @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div>
                                            <div class="uk-form-label"> @lang('front/auth.iban')  </div>
                                            <input class="uk-input form-control @error('iban') is-invalid @enderror" type="text" name="iban" value="{{$instructor_profile->iban}}" required>
                                            @error('iban')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div>
                                            <div class="uk-form-label"> @lang('front/auth.bio')</div>
                                            <textarea class="uk-textarea form-control @error('bio') is-invalid @enderror" type="text" rows="5" name="bio" style=" resize: none" required> {{$instructor_profile->bio}} </textarea>
                                            @error('bio')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <input class="uk-button uk-button-grey button uk-margin" type="submit" value="@lang('front/auth.save')">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="uk-card uk-card-default uk-align-center uk-margin-medium-bottom" style="max-width: 90%">
            <div class="uk-card-header uk-text-bold">
                <span class="fas icon-medium uk-margin-small-right fa-user-friends"></span>
                @lang('front/auth.guardian_infos')
            </div>
            <div class="uk-card-body">
                <div uk-grid class="uk-flex-center">
                    <div class="uk-width-large@m uk-padding-remove-top">
                        <div class="uk-fieldset uk-margin-small-bottom">
                            @if($has_guardian_profile)
                                <div class="uk-form-label"> @lang('front/auth.reference_code')  </div>
                                <div class="uk-flex uk-flex-wrap">
                                    <input class="uk-input uk-width-3-4@m" type="text" readonly name="reference_code" id="guardianRefCode" value="{{$guardian_profile->reference_code}}">
                                    <button class="uk-button uk-button-default uk-width-1-4@m" onclick="copyToClipboard('guardianRefCode')"><i class="fas fa-copy icon-medium"></i> <span class="uk-hidden@m">@lang('front/auth.copy')</span></button>
                                </div>
                            @else
                                <button class="uk-button uk-button-success uk-width" onclick="beGuardian({{Auth::user()->id}})">@lang('front/auth.be_guardian')</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-card uk-card-default uk-align-center uk-margin-medium-bottom" style="max-width: 90%">
            <a class="card-link" href="{{route('get_purchases')}}">
                <div class="uk-card-header uk-text-primary">
                    <span class="fas icon-medium uk-margin-small-right fa-money-bill"></span>
                    @lang('front/auth.purchase_history')
                </div>
            </a>
        </div>
    </div>
@endsection
