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
                    <div>
                        <!-- page content -->
                        <div id="courseContent" class="uk-flex uk-flex-column align-items-center tabcontent tab-default-open  animation: uk-animation-slide-right-medium">
                            <form class="uk-width">
                            <div class="uk-margin-top">
                                <h4>@lang('front/auth.course_detail')</h4>
                            </div>
                            <hr>
                            @if(isset($course))
                                <category-select category-default="@lang('front/auth.category')" sub-category-default="@lang('front/auth.sub_category')" has-selected-option
                                    selected-category="{{$course->category->name}}"
                                    selected-category-id="{{$course->category->id}}"
                                    selected-sub-category="{{$course->subCategory->name}}"
                                    selected-sub-category-id="{{$course->subCategory->id}}"
                                ></category-select>
                            @else
                                    <category-select category-default="@lang('front/auth.category')" sub-category-default="@lang('front/auth.sub_category')"></category-select>
                            @endif
                            <div class="uk-margin-remove-bottom uk-margin-remove-top">
                                <input type="text" value="{{Auth::user()->instructor->id}}" id="instructorId" hidden disabled>
                                <div>
                                    <div class="uk-form-label"> @lang('front/auth.course_img')  </div>
                                    @if(isset($course))
                                        <div id="imagePreview" class="uk-background-center-center uk-background-cover uk-height" style="background-image: url({{$course->image}})"></div>
                                    @else
                                        <div id="imagePreview" class="uk-background-center-center uk-background-cover uk-height-small" style="background-image: url({{asset('images/courses/course-1.jpg')}});"></div>
                                    @endif
                                </div>
                                <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                                    <input name="image" type="file" accept="image/*" id="newCourseImage" @if(isset($course)) src="{{$course->image}}" @endif onchange="previewImage(this)" required>
                                    <input class="uk-input form-control @error('image') is-invalid @enderror" type="text" tabindex="-1" disabled placeholder="@lang('front/auth.select_file')">
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div>
                                    <div class="uk-form-label"> @lang('front/auth.course_name')  </div>
                                    <input class="uk-input form-control @error('name') is-invalid @enderror" type="text" id="name"  @if(isset($course)) value="{{$course->name}}" @endif required>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div>
                                    <div class="uk-form-label"> @lang('front/auth.course_desc')</div>
                                    <textarea class="uk-textarea form-control @error('description') is-invalid @enderror" type="text" rows="8" id="description" style="resize: none" required>@if(isset($course)){{$course->description}} @endif </textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="uk-grid uk-margin-remove-top uk-child-width-1-2@m">
                                <div>
                                    <div class="uk-form-label"> @lang('front/auth.price')  </div>
                                    <input class="uk-input form-control @error('price') is-invalid @enderror" type="text" id="price"  @if(isset($course)) value="{{$course->price}}" @endif required>
                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div>
                                    <div class="uk-form-label"> @lang('front/auth.access_time') (@lang('front/auth.month'))  </div>
                                    <input class="uk-input form-control @error('accessTime') is-invalid @enderror" type="number" min="1" id="accessTime"  @if(isset($course)) value="{{$course->access_time}}" @endif required>
                                    @error('accessTime')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="uk-margin uk-flex justify-content-start align-items-center">
                                <label>
                                    <input class="uk-checkbox" type="checkbox"  @if(isset($course) && $course->certificate) checked @endif id="certificate">
                                    <span class="checkmark uk-text-small">@lang('front/auth.has_certificate')</span>
                                </label>
                            </div>
                            <div class="uk-margin">
                                <input class="uk-button uk-button-grey button uk-margin" type="button" onclick="coursePost()" value="@lang('front/auth.save')">
                            </div>
                            </form>
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
                            <div class="uk-flex align-items-center">
                                <img class="user-profile-tiny uk-circle" src="{{asset(Auth::user()->avatar)}}">
                                <b class="uk-margin-left">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
