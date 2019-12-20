@extends('layouts.app')
@section('content')
    @if(session('result_message'))
        @if(session('error'))
            <script>UIkit.notification({message: '{{session('message')}}', status: 'danger'});</script>
        @else
            <script>UIkit.notification({message: '{{session('message')}}', status: 'success'});</script>
        @endif
    @endif

    <div class="uk-container uk-margin-large-top">
        <div class="uk-card uk-card-default uk-align-center" style="max-width: 75%">
            <div class="uk-card-body">
                <div class="uk-flex-center">
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
                                        <div class="uk-width uk-grid-stack">
                                            <div class="uk-width uk-child-width-1-2@l uk-grid">
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
                                            <div class="uk-width uk-child-width-1-2@l uk-grid uk-margin-remove-top">
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
                                            <div class="uk-width uk-child-width">
                                                <div class="uk-form-label">@lang('front/auth.city') </div>
                                                <provinces city-default="@lang('front/auth.province')" district-default="@lang('front/auth.district')"></provinces>
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
                                    <form class="uk-grid-small uk-form" uk-grid method="POST" action="{{ route('updatePassword') }}">
                                        @csrf
                                        <div class="uk-width uk-grid-stack">
                                            <div class="uk-width uk-child-width-1-2@l uk-grid">
                                                <div>
                                                    <div class="uk-form-label"> @lang('front/auth.password_old') </div>
                                                    <div class="uk-inline uk-flex justify-content-center align-items-center" >
                                                        <input class="uk-input form-control @error('old_password') is-invalid @enderror" id="old_password" name="old_password" type="password" placeholder="@lang('front/auth.password_old')" required>
                                                        <a class="fas fa-eye" onclick="togglePassword('old_password')" style="margin-left: -25px"></a>
                                                        @error('old_password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="uk-form-label"> @lang('front/auth.password_new')</div>
                                                    <div class="uk-inline uk-flex justify-content-center align-items-center">
                                                        <input class="uk-input form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" type="password" placeholder="@lang('front/auth.password_new')" required>
                                                        <a class="fas fa-eye" onclick="togglePassword('new_password')" style="margin-left: -25px"></a>
                                                        @error('new_password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
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
            statu-name="@lang('front/auth.instructor_infos')"
            title="@lang('front/auth.title')"
            id-num="@lang('front/auth.id_num')"
            bio="@lang('front/auth.bio')"
            iban="@lang('front/auth.iban')"
            ref-code="@lang('front/auth.referance_code')"
            sign-in="@lang('front/auth.save')"
            action-address="#"
            instructor
        ></statu>
    </div>
@endsection
