@extends('layouts.auth')
@section('content')
    <form method="POST" action="{{ route('registerPost') }}">
        @csrf
        <div class="uk-card-default uk-padding uk-card-small">
            <div id="register" class="tabcontent animation: uk-animation-slide-left-medium">
                <h2 class="uk-text-bold">  @lang('front/auth.register')  </h2>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <p class="uk-text-muted uk-margin-remove-top uk-margin-small-bottom">@lang('front/auth.register_description')</p>
                <div class="uk-child-width-1-2@l uk-grid">
                    <div class="uk-margin-small-bottom">
                        <input id="first_name" class="uk-input form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus placeholder=" @lang('front/auth.first_name') " type="text">
                        @error('first_name')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <input id="last_name" class="uk-input form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus placeholder=" @lang('front/auth.last_name') " type="text">
                        @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="uk-child-width-1-2@l uk-grid uk-margin-small">
                    <div class="uk-margin-small-bottom">
                        <input id="email" class="uk-input form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="@lang('front/auth.email')" type="text">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <input id="phone_number" class="uk-input form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="phone_number" autofocus placeholder="@lang('front/auth.phone_number')" type="text">
                        @error('phone_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="uk-margin-small">
                    <provinces
                        city-default="@lang('front/auth.province')"
                        district-default="@lang('front/auth.district')"
                    ></provinces>
                </div>
                <div class="uk-child-width-1-2@l uk-grid uk-margin-small">
                    <div class="uk-margin-small-bottom uk-inline uk-flex align-items-center">
                        <input id="username" class="uk-input form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="@lang('front/auth.username')" type="text">
                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <div class="uk-inline uk-flex align-items-center">
                            <input id="password" class="uk-input form-control @error('password') is-invalid @enderror" name="password" required autocomplete="password" placeholder="@lang('front/auth.password')" type="password">
                            <a class="fas fa-eye" onclick="togglePassword('password')" style="margin-left: -30px"></a>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="uk-margin">
                    <div class="uk-grid uk-child-width-1-2@m">
                        <ul class="uk-list">
                            <li>
                                <a href="{{asset('/contracts/kvkkAydinlatma.pdf')}}" target="_blank"> KVKK Aydınlatma Metni </a>
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
                        </ul>
                        <ul class="uk-list">
                            <li>
                                <a href="{{asset('/contracts/cookiesPolicy.pdf')}}" target="_blank"> Çerez Politikamız </a>
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

                            </li>
                        </ul>
                    </div>
                    <label class="uk-margin-small-top">
                        <input class="uk-checkbox" type="checkbox" required>
                        <span class="checkmark uk-text-small">Tüm sözleşmeleri okudum ve kabul ediyorum </span>
                    </label>
                </div>
                <div class=" uk-flex-middle" uk-grid>
                    <div class="uk-width-expand@m">
                        <input class="uk-button uk-button-success button" type="submit" value="@lang('front/auth.register')">
                    </div>
                    <div class="uk-width-auto@m">
                        <span class="uk-text-small"> @lang('front/auth.registered') <a href="{{ route('loginGet') }}" class="tablinks uk-text-bold" >@lang('front/auth.sign_in')</a>  </span>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
