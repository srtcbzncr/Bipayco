@extends('layouts.admin')
@section('content')
    <div class="uk-card uk-card-default uk-align-center uk-margin-xlarge-bottom" style="max-width: 80%">
        <div class="uk-card-body uk-margin-xlarge-top">
            <div id="createPage" class="uk-grid">
                <div class="uk-width-1-4@m">
                    <ul class="uk-tab-left" uk-tab>
                        <li class="uk-active"><a href="#" class="tablinks" onclick="openTabs(event, 'courseContent')">@lang('front/auth.course')</a></li>
                        <li><a href="#" class="tablinks"  @if(!isset($course)) disabled @else onclick="openTabs(event, 'achievements')" @endif>@lang('front/auth.achievements')</a></li>
                        <li><a href="#" class="tablinks"  @if(!isset($course)) disabled @else onclick="openTabs(event, 'instructors')" @endif>@lang('front/auth.instructors')</a></li>
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
                            <div class="uk-margin-remove-bottom uk-margin-remove-top">
                                <input type="text" value="{{Auth::user()->id}}" id="userId" hidden disabled>
                                <div>
                                    <div class="uk-form-label"> @lang('front/auth.course_img')  </div>
                                    @if(isset($course))
                                        <input type="text" value="{{$course->id}}" id="courseCreateId" hidden disabled>
                                        <div id="imagePreview" class="uk-background-center-center uk-background-cover uk-height" style="background-image: url({{$course->image}})"></div>
                                    @else
                                        <div id="imagePreview" class="uk-background-center-center uk-background-cover uk-height-small" style="background-image: url({{asset('images/courses/course-1.jpg')}});"></div>
                                    @endif
                                </div>
                                <div uk-form-custom="target: true" class="uk-flex uk-flex-center uk-margin">
                                    <input name="image" type="file" accept="image/*" id="newCourseImage" onchange="previewImage(this)" required>
                                    <input class="uk-input form-control @error('image') is-invalid @enderror" type="text" tabindex="-1" disabled placeholder="@lang('front/auth.select_file')">
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div>
                                    <div class="uk-form-label"> @lang('front/auth.course_name')</div>
                                    <input class="uk-input form-control @error('name') is-invalid @enderror" type="text" id="name"  @if(isset($course)) value="{{$course->name}}" @endif required>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div>
                                    <div class="uk-form-label"> @lang('front/auth.course_desc')</div>
                                    <textarea class="uk-textarea form-control @error('description') is-invalid @enderror" type="text" rows="8" id="description" style="resize: none" required>@if(isset($course)){{$course->description}}@endif</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <div>
                                    <div class="uk-form-label"> @lang('front/auth.price')  </div>
{{--                                    <input class="uk-input form-control @error('price') is-invalid @enderror" type="text" id="price"  @if(isset($course)) value="{{$course->price}}" @endif required>--}}
                                    <select class="uk-select form-control @error('price') is-invalid @enderror" type="text" id="price" required>
                                        @if(isset($course))
                                            <option value="{{$course->price}}" selected hidden disabled>{{$course->price}}0</option>
                                        @else
                                            <option value="" selected hidden disabled>@lang('front/auth.price')</option>
                                        @endif
                                        <option value="9.90">9.90</option>
                                        <option value="19.90">19.90</option>
                                        <option value="29.90">29.90</option>
                                        <option value="39.90">39.90</option>
                                        <option value="49.90">49.90</option>
                                        <option value="59.90">59.90</option>
                                        <option value="69.90">69.90</option>
                                        <option value="79.90">79.90</option>
                                        <option value="89.90">89.90</option>
                                        <option value="99.90">99.90</option>
                                        <option value="149.90">149.90</option>
                                        <option value="199.90">199.90</option>
                                        <option value="249.90">249.90</option>
                                        <option value="299.90">299.90</option>
                                        <option value="399.90">399.90</option>
                                        <option value="499.90">499.90</option>
                                        <option value="599.90">599.90</option>
                                        <option value="699.90">699.90</option>
                                        <option value="799.90">799.90</option>
                                        <option value="899.90">899.90</option>
                                        <option value="999.90">999.90</option>
                                    </select>
                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="uk-grid uk-margin-remove-top uk-child-width-1-2@m">
                                <div>
                                    <div class="uk-form-label"> @lang('front/auth.start_date') (@lang('front/auth.month'))  </div>
                                    <input class="uk-input form-control @error('accessTime') is-invalid @enderror" type="date" min="1" id="liveDate"  @if(isset($course)) value="{{$course->datetime}}" @endif required>
                                    @error('accessTime')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div>
                                    <div class="uk-form-label"> @lang('front/auth.start_time')</div>
                                    <input class="uk-input form-control @error('liveTime') is-invalid @enderror" type="time" min="1" id="liveTime"  @if(isset($course)) value="{{$course->datetime}}" @endif required>
                                    @error('liveTime')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                                <div class="uk-grid uk-margin-remove-top uk-child-width-1-2@m">
                                    <div>
                                        <div class="uk-form-label"> @lang('front/auth.max_participant_count')</div>
                                        <input class="uk-input form-control @error('max_participant') is-invalid @enderror" type="number" min="1" id="maxParticipant"  @if(isset($course)) value="{{$course->max_participant}}" @endif required>
                                        @error('max_participant')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <div class="uk-form-label"> @lang('front/auth.live_duration')</div>
                                        <input class="uk-input form-control @error('duration') is-invalid @enderror" type="number" id="duration" min="1" @if(isset($course)) value="{{$course->duration}}" @endif required>
                                        @error('duration')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                {{--                            <div class="uk-margin uk-flex justify-content-start align-items-center">--}}
{{--                                <label>--}}
{{--                                    <input class="uk-checkbox" type="checkbox"  @if(isset($course) && $course->certificate) checked @endif id="certificate">--}}
{{--                                    <span class="checkmark uk-text-small">@lang('front/auth.has_certificate')</span>--}}
{{--                                </label>--}}
{{--                            </div>--}}
                            <div class="uk-margin">
                                <input class="uk-button uk-button-grey button uk-margin uk-width-small@m" type="button" @if(isset($course)) onclick="livePost(false)" @else onclick="livePost(true)" @endif  value="@lang('front/auth.save')">
                            </div>
                            </form>
                        </div>
                        @if(isset($course))
                            <div id="achievements" class="tabcontent  animation: uk-animation-slide-right-medium">
                                <div class="uk-margin-top">
                                    <h4>@lang('front/auth.achievements')</h4>
                                </div>
                                <hr>
                                <add-list
                                    id="achievement-list"
                                    add-text="@lang('front/auth.add')"
                                    add-default-text="@lang('front/auth.add_achievement')"
                                    field="achievements"
                                    course-id="{{$course->id}}"
                                    module-name="prepareExams"
                                > </add-list>
                                <div class="uk-margin-top">
                                    <h4>@lang('front/auth.requirements')</h4>
                                </div>
                                <hr>
                                <add-list
                                    id="requirement-list"
                                    add-text="@lang('front/auth.add')"
                                    add-default-text="@lang('front/auth.add_requirement')"
                                    field="requirements"
                                    course-id="{{$course->id}}"
                                    module-name="prepareExams"
                                > </add-list>
                                <div class="uk-margin-top">
                                    <h4>@lang('front/auth.tags')</h4>
                                </div>
                                <hr>
                                <add-list
                                    id="tag-list"
                                    add-text="@lang('front/auth.add')"
                                    add-default-text="@lang('front/auth.add_tag')"
                                    field="tags"
                                    course-id="{{$course->id}}"
                                    module-name="prepareExams"
                                > </add-list>
                                <div class=uk-margin">
                                    <input class="uk-button uk-button-grey uk-margin uk-width-small@m" type="button" onclick="achievementsPost('prepareExams',{{$course->id}})"  value="@lang('front/auth.save')">
                                </div>
                            </div>
                            <div id="lessons" class="tabcontent  animation: uk-animation-slide-right-medium">
                                <div class='lessonSettings addLesson sectionSettings'>
                                    <div class="uk-margin-top">
                                        <h4>@lang('front/auth.lessons')</h4>
                                    </div>
                                    <hr>
                                    <add-section
                                        preview-text="@lang('front/auth.preview')"
                                        section-text="@lang('front/auth.section')"
                                        add-default-section-text="@lang('front/auth.add_section')"
                                        add-default-lesson-text="@lang('front/auth.add_lessons')"
                                        add-text="@lang('front/auth.add')"
                                        save-text="@lang('front/auth.save')"
                                        select-file-text="@lang('front/auth.select_file')"
                                        saved-success-text="@lang('front/auth.saved_successful')"
                                        course-id="{{$course->id}}"
                                        instructor-id="{{Auth::user()->instructor->id}}"
                                        module-name="prepareExams"
                                    > </add-section>
                                </div>
                                <add-lesson
                                    course-id="{{$course->id}}"
                                    not-added-lesson-text="@lang('front/auth.not_uploaded_lesson')"
                                    file-type-text="@lang('front/auth.file_type')"
                                    pdf-text="@lang('front/auth.pdf')"
                                    video-text="@lang('front/auth.video')"
                                    save-text="@lang('front/auth.save')"
                                    cancel-text="@lang('front/auth.cancel')"
                                    uploading-text="@lang('front/auth.uploading')"
                                    continue-text="@lang('front/auth.continue')"
                                    preview-text="@lang('front/auth.preview')"
                                    add-source-text="@lang('front/auth.add_source')"
                                    add-lesson-text="@lang('front/auth.add_lesson')"
                                    upload-document-text="@lang('front/auth.upload_document')"
                                    upload-video-text="@lang('front/auth.upload_video')"
                                    lesson-name-text="@lang('front/auth.lesson_name')"
                                    module-name="prepareExams"
                                > </add-lesson>
                                <lesson-settings
                                    course-id="{{$course->id}}"
                                    edit-lesson-text="@lang('front/auth.edit_lesson')"
                                    lesson-name-text="@lang('front/auth.lesson_name')"
                                    sources-text="@lang('front/auth.sources')"
                                    is-preview-text="@lang('front/auth.preview')"
                                    save-text="@lang('front/auth.save')"
                                    cancel-text="@lang('front/auth.cancel')"
                                    add-source-text="@lang('front/auth.add_source')"
                                    module-name="prepareExams"
                                > </lesson-settings>
                                <section-settings
                                    preview-text="@lang('front/auth.preview')"
                                    section-text="@lang('front/auth.section')"
                                    add-default-section-text="@lang('front/auth.add_section')"
                                    add-default-lesson-text="@lang('front/auth.add_lessons')"
                                    add-text="@lang('front/auth.add')"
                                    save-text="@lang('front/auth.save')"
                                    select-file-text="@lang('front/auth.select_file')"
                                    saved-success-text="@lang('front/auth.saved_successful')"
                                    course-id="{{$course->id}}"
                                    instructor-id="{{Auth::user()->instructor->id}}"
                                    module-name="prepareExams"
                                > </section-settings>
                            </div>
                            <div id="instructors" class="tabcontent  animation: uk-animation-slide-right-medium">
                                <div class="uk-margin-top">
                                    <h4>@lang('front/auth.instructors')</h4>
                                </div>
                                <hr>
                                <instructor-area
                                    user-img="{{Auth::user()->avatar}}"
                                    user-name="{{Auth::user()-> first_name}} {{Auth::user()->last_name}}"
                                    user-id="{{Auth::user()->instructor->id}}"
                                    addtinstructor-text="@lang('front/auth.add_instructor')"
                                    instructor-text="@lang('front/auth.instructor')"
                                    percent-text="@lang('front/auth.percent')"
                                    manager-text="@lang('front/auth.manager')"
                                    add-text="@lang('front/auth.add')"
                                    course-id="{{$course->id}}"
                                    save-text="@lang('front/auth.save')"
                                    module-name="prepareExams"
                                > </instructor-area>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
