<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.2.6/dist/js/uikit.min.js"></script>
    <script src="{{asset('js/simplebar.js')}}"></script>
    <script src="{{asset('js/dropzone.min.js')}}"></script>
    <script src="{{asset('js/uikit.js')}}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/uikit.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin.css')}}" rel="stylesheet">
    <link href="{{asset('css/dropzone.css')}}" rel="stylesheet">
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
    <link href="{{asset('css/fontawesome.css')}}" rel="stylesheet">
</head>
<body>
    <!-- sidebar -->
    <div class="admin-side overflow-auto" id="admin-side">
        <div class="uk-flex uk-flex-center uk-margin-small-top">
            <a class="" href="{{route('home')}}">
                <img class="uk-logo uk-width-small" src="{{asset('images/logo1.png')}}"/>
            </a>
        </div>
        <ul>
            <li>
                <a href="{{route('instructor_courses')}}"> <i class="fas fa-chalkboard"></i>  @lang('front/auth.my_courses') </a>
            </li>
            <li>
                <a href="{{route('instructor_books')}}"> <i class="fas fa-book-open"></i>@lang('front/auth.my_books')</a>
            </li>
            <li>
                <a href="{{route('instructor_exams')}}"> <i class="fas fa-pencil-alt"></i>@lang('front/auth.my_exams')</a>
            </li>
            <li>
                <a href="{{route('instructor_homeworks')}}"> <i class="fas fa-book"></i>@lang('front/auth.my_homework_packages')</a>
            </li>
            <li>
                <a href="{{route('instructor_performance')}}"> <i class="fas fa-chart-line"></i>@lang('front/auth.performance')</a>
            </li>
            <li>
                <a href="{{route('instructor_questions')}}"> <i class="fas fa-question"></i>@lang('front/auth.questions')</a>
            </li>
            <li>
                <a href="{{route('student_profile', Auth::user()->id)}}"> <i class="fas fa-user"></i>@lang('front/auth.student_mode')</a>
            </li>
            <li>
                <a href="{{route('settings')}}"> <i class="fas fa-cog"></i>@lang('front/auth.settings')</a>
            </li>
            <li>
                <a href="{{route('logout')}}"> <i class="fas fa-sign-out-alt"></i>@lang('front/auth.log_out')</a>
            </li>
        </ul>
    </div>
    <!-- mobile  header -->
    <div class="admin-mobile-headder uk-hidden@m">
        <span uk-toggle="target: #admin-side; cls: admin-side-active" class="uk-padding-small uk-text-white uk-float-right"><i class="fas fa-bars"></i></span>
        <a class="" href="{{route('home')}}"> <img class="uk-width-small" src="{{asset('images/logo2.png')}}"/> </a>
    </div>
    <div class="admin-content">
        <div id="app1" class="admin-content-inner">
            @yield('content')
        </div>
        <div class="uk-section-small uk-margin-medium-top">
            <hr class="uk-margin-remove">
            <div class="uk-container uk-align-center uk-margin-remove-bottom uk-position-relative">
                <div uk-grid>
                    <div class="uk-width-1-3@m uk-width-1-2@s uk-first-column">
                        <a class="" href="{{route('home')}}"> <img class="uk-logo uk-width-small@s uk-width-medium@m" src="{{asset('images/logo2.png')}}"/> </a>
                        <div class="uk-width-xlarge tm-footer-description">Bilgi paylaştıkça çoğalır.</div>
                    </div>
                    <div class="uk-width-expand@m uk-width-1-2@s">
                        <ul class="uk-list  tm-footer-list">

                        </ul>
                    </div>
                    <div class="uk-width-expand@m uk-width-1-2@s">
                        <ul class="uk-list tm-footer-list">
                            <li>
                                <a href="{{route('ge_index')}}">Genel Eğitim Modülü </a>
                            </li>
                            <li>
                                <a href="#">Sınavlara Hazırlık Modülü  </a>
                            </li>
                            <li>
                                <a href="#"> Derslere Hazırlık Modülü </a>
                            </li>
                        </ul>
                    </div>
                    <div class="uk-width-expand@m uk-width-1-2@s">
                        <ul class="uk-list  tm-footer-list">
                            <li>
                                <a href="#"> Denemeler </a>
                            </li>
                            <li>
                                <a href="#"> Ödemeler </a>
                            </li>
                            <li>
                                <a href="#"> İletişim </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="uk-margin-medium uk-margin-remove-right" uk-grid>
                    <div class="uk-width-1-3@m uk-width-1-1@s uk-first-column">
                        <p class="uk-text-small"><i class="fas fa-copyright"></i> 2020 <span class="uk-text-bold">Bipayco</span>  Bütün hakları saklıdır.</p>
                    </div>
                    <div class="uk-width-1-3@m uk-width-1-1@s">
                        <a href="#" class="uk-icon-button uk-link-reset"><i class="fab fa-youtube" style=" color: #fb7575  !important;"></i></a>
                        <a href="#" class="uk-icon-button uk-link-reset"><i class="fab fa-facebook" style=" color: #9160ec  !important;"></i></a>
                        <a href="#" class="uk-icon-button uk-link-reset"><i class="fab fa-instagram" style=" color: #dc2d2d  !important;"></i></a>
                        <a href="#" class="uk-icon-button uk-link-reset"><i class="fab fa-linkedin " style=" color: #6949a5  !important;"></i></a>
                        <a href="#" class="uk-icon-button uk-link-reset"><i class="fab fa-twitter" style=" color: #6f23ff !important;"></i></a>
                    </div>
                    <div class="uk-width-1-3@m uk-width-1-1@s">
                        <p><a href="#"  class="uk-text-bold uk-link-reset"> Sanalist </a> tarafından geliştirildi. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    function coursePost(bool){
        var formData =new FormData();
        var image=document.querySelector('#newCourseImage');
        formData.append('name',document.querySelector('#name').value);
        formData.append('description',document.querySelector('#description').value);
        formData.append('price',document.querySelector('#price').value);
        formData.append('access_time',document.querySelector('#accessTime').value);
        formData.append('instructor_id',document.querySelector('#instructorId').value);
        formData.append('category_id',document.querySelector('#category').value);
        formData.append('sub_category_id',document.querySelector('#subCategory').value);
        if(document.querySelector('#certificate').checked){
            formData.append('certificate',1);
        }else{
            formData.append('certificate',0);
        }
        if(image.files[0]!=undefined){
            formData.append('image', image.files[0]);
        }
        if(bool){
            axios.post('/api/instructor/course/create',
                formData, {
                    headers: {'Content-Type': 'multipart/form-data'}
                }).then(result=>result.data)
                .then(result=>window.location.replace('/instructor/ge/course/create/'+result.result.id))
                .catch((error) => {
                    UIkit.notification({message:error.message, status: 'danger'});
                });
        }else{
            var courseId=document.querySelector('#courseCreateId').value;
            axios.post('/api/instructor/course/create/'+courseId,
                formData, {
                    headers: {'Content-Type': 'multipart/form-data'}
                })
                .then(result=>window.location.replace('/instructor/ge/course/create/'+result.data.result.id))
                .catch((error) => {
                    UIkit.notification({message:error.message, status: 'danger'});
                });
        }
    }

    function previewImage(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                document.querySelector('#imagePreview').setAttribute('style', 'background-image:url('+e.target.result+')');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function instructorPost(courseId) {
        var instructors=[];
        var instructorIds=document.getElementsByName('instructorsId[]');
        var percents=document.getElementsByName('percent[]');
        for(var i=0;i<instructorIds.length; i++) {
            var id=instructorIds[i].value;
            var percent=percents[i].value;
            instructors.push({'instructor_id':id,'percent': percent});
        }
        axios.post('/api/instructor/course/'+courseId+'/instructors',instructors)
            .catch((error) => {
                UIkit.notification({message:error.message, status: 'danger'});
            });
    }

    function achievementsPost(courseId) {
        var formData =new FormData();
        var achievementList=[],requirementList=[], tagList=[];
        var achievements= document.getElementsByName('achievement-list[]');
        for(var i=0;i<achievements.length;i++){
            achievementList.push(achievements[i].value);
        }
        var requirements= document.getElementsByName('requirement-list[]');
        for(var i=0;i<requirements.length;i++){
            requirementList.push(requirements[i].value);
        }
        var tags= document.getElementsByName('tag-list[]');
        for(var i=0;i<tags.length;i++){
            tagList.push(tags[i].value);
        }
        formData.append('achievements', achievementList);
        formData.append('requirements', requirementList);
        formData.append('tags', tagList);
        formData.append('instructor_id', document.getElementById('instructorId').value);
        axios.post('/api/instructor/course/'+courseId+'/goals', formData)
            .catch((error) => {
                UIkit.notification({message:error.message, status: 'danger'});
            });
    }

</script>
<script>

    var bar = document.getElementById('js-progressbar');

    UIkit.upload('.js-upload', {

        url: '',
        multiple: true,

        beforeSend: function () {
            console.log('beforeSend', arguments);
        },
        beforeAll: function () {
            console.log('beforeAll', arguments);
        },
        load: function () {
            console.log('load', arguments);
        },
        error: function () {
            console.log('error', arguments);
        },
        complete: function () {
            console.log('complete', arguments);
        },

        loadStart: function (e) {
            console.log('loadStart', arguments);

            bar.removeAttribute('hidden');
            bar.max = e.total;
            bar.value = e.loaded;
        },

        progress: function (e) {
            console.log('progress', arguments);

            bar.max = e.total;
            bar.value = e.loaded;
        },

        loadEnd: function (e) {
            console.log('loadEnd', arguments);

            bar.max = e.total;
            bar.value = e.loaded;
        },

        completeAll: function () {
            console.log('completeAll', arguments);

            setTimeout(function () {
                bar.setAttribute('hidden', 'hidden');
            }, 1000);

            alert('Upload Completed');
        }

    });

</script>
<style>
    #imagePreview{
        padding-top:calc( 190 / 367 * 90%);
    }
</style>
</html>
