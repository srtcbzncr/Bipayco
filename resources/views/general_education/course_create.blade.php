@extends('layouts.admin')
@section('content')
    <div class="uk-card uk-card-default uk-align-center uk-margin-medium-bottom" style="max-width: 80%">
        <div class="uk-card-body uk-margin-xlarge-top">
            <div class="uk-grid">
                <div class="uk-width-1-4@m">
                    <ul class="uk-tab-left" uk-tab>
                        <li class="uk-active"><a href="#" class="tablinks" onclick="openTabs(event, 'courseContent')">Kurs</a></li>
                        <li><a href="#" class="tablinks" onclick="openTabs(event, 'achievements')">Hedefler</a></li>
                        <li><a href="#" class="tablinks" onclick="openTabs(event, 'lessons')">Müfredat</a></li>
                        <li><a href="#" class="tablinks" onclick="openTabs(event, 'instructors')">Eğitmenler</a></li>
                    </ul>
                </div>
                <div class="uk-width-3-4@m">
                    <div uk-grid>
                        <!-- page content -->
                        <div id="courseContent" class="tabcontent tab-default-open  animation: uk-animation-slide-right-medium">
                            <div class="uk-margin-top">
                                <h4>@lang('front/auth.course_detail')</h4>
                            </div>
                            <hr>
                            <category-select category-default="@lang('front/auth.category')" sub-category-default="@lang('front/auth.sub_category')"></category-select>
                            <div class="uk-grid uk-margin-remove-bottom uk-margin-remove-top">
                                <input type="text" value="{{Auth::user()->instructor->id}}" name="instructorId" hidden disabled>
                                <div class="uk-width-1-2@m">
                                    <div >
                                        <div class="uk-form-label"> @lang('front/auth.course_img')  </div>
                                        <img src="{{Auth::user()->avatar}}">
                                    </div>
                                    <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                                        <input name="image" type="file" accept="image/*"  required>
                                        <input class="uk-input form-control @error('image') is-invalid @enderror" type="text" tabindex="-1" disabled placeholder="@lang('front/auth.select_file')">
                                        @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="uk-width-1-2@m">
                                    <div>
                                        <div class="uk-form-label"> @lang('front/auth.course_name')  </div>
                                        <input class="uk-input form-control @error('name') is-invalid @enderror" type="text" name="name" required>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <div class="uk-form-label"> @lang('front/auth.course_desc')</div>
                                        <textarea class="uk-textarea form-control @error('description') is-invalid @enderror" type="text" rows="8" name="description" style=" resize: none" required> </textarea>
                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="uk-grid uk-margin-remove-top uk-child-width-1-2@m">
                                <div>
                                    <div class="uk-form-label"> @lang('front/auth.price')  </div>
                                    <input class="uk-input form-control @error('price') is-invalid @enderror" type="text" name="price" required>
                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div>
                                    <div class="uk-form-label"> @lang('front/auth.access_time') (@lang('front/auth.month'))  </div>
                                    <input class="uk-input form-control @error('accessTime') is-invalid @enderror" type="number" min="1" name="accessTime" required>
                                    @error('accessTime')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="uk-margin uk-flex justify-content-start align-items-center">
                                <label>
                                    <input class="uk-checkbox" type="checkbox" value="false" name="certificate">
                                    <span class="checkmark uk-text-small">@lang('front/auth.has_certificate')</span>
                                </label>
                            </div>
                            <div class="uk-margin">
                                <input class="uk-button uk-button-grey button uk-margin" type="button" onclick="coursePost()" value="@lang('front/auth.save')">
                            </div>
                        </div>
                        <div id="achievements" class="tabcontent  animation: uk-animation-slide-right-medium">
                            <h2>Başarımlar</h2>
                        </div>
                        <div id="lessons" class="tabcontent  animation: uk-animation-slide-right-medium">
                            <h2>Dersler</h2>
                        </div>
                        <div id="instructors" class="tabcontent  animation: uk-animation-slide-right-medium">
                            <div class="uk-margin-top">
                                <h4>@lang('front/auth.instructors')</h4>
                            </div>
                            <hr>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
