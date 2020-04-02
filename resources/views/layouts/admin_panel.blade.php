<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Bipayco </title>

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

    <style>
        @media screen and (max-width: 435px) {
            .admin-panel-inner {
                padding: 0 !important
            }
        }
        .admin-panel-inner{
            padding: 30px ;
            max-width: 1100px;
            margin: auto;
        }
    </style>
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
            <a href="{{route('adminDashboard')}}"> <i class="fas fa-chalkboard"></i>  @lang('front/auth.dashboard') </a>
        </li>
        <li>
            <a href="{{route('adminCities')}}"> <i class="fas fa-chalkboard"></i>  @lang('front/auth.cities') </a>
        </li>
        <li>
            <a href="{{route('adminCategories')}}"> <i class="fas fa-book"></i>@lang('front/auth.categories')</a>
        </li>
        <li>
            <a href="{{route('adminLesson')}}"> <i class="fas fa-book-open"></i>@lang('front/auth.lessons')</a>
        </li>
        <li>
            <a href="{{route('adminGrade')}}"> <i class="fas fa-pencil-alt"></i>@lang('front/auth.grade')</a>
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
<div class="admin-content uk-height-viewport">
    <div id="app1" class="admin-panel-inner">
        @yield('content')
    </div>
</div>
</body>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    function coursePost(moduleName, bool){
        var url;
        var formData =new FormData();
        var image=document.querySelector('#newCourseImage');
        formData.append('name',document.querySelector('#name').value);
        formData.append('description',document.querySelector('#description').value);
        formData.append('price',document.querySelector('#price').value);
        formData.append('access_time',document.querySelector('#accessTime').value);
        formData.append('instructor_id',document.querySelector('#instructorId').value);
        if(moduleName=="generalEducation"){
            formData.append('category_id',document.querySelector('#category').value);
            formData.append('sub_category_id',document.querySelector('#subCategory').value);
            url="ge";
        }else if(moduleName=="prepareLessons"){
            formData.append('grade_id',document.querySelector('#gradeType').value);
            formData.append('lesson_id',document.querySelector('#lessonType').value);
            url="pl";
        }
        if(document.querySelector('#certificate').checked){
            formData.append('certificate',1);
        }else{
            formData.append('certificate',0);
        }
        if(image.files[0]!=undefined){
            formData.append('image', image.files[0]);
        }
        if(bool){
            axios.post('/api/instructor/'+moduleName+'/course/create',
                formData, {
                    headers: {'Content-Type': 'multipart/form-data'}
                }).then(result=>result.data)
                .then(result=>{
                    UIkit.notification({message:result.message, status: 'success'});
                    setTimeout(()=>{window.location.replace('/instructor/'+url+'/course/create/'+result.result.id)},1000);
                })
                .catch((error) => {
                    UIkit.notification({message:error.message, status: 'danger'});
                    console.log(error)
                });
        }else{
            var courseId=document.querySelector('#courseCreateId').value;
            axios.post('/api/instructor/'+moduleName+'/course/create/'+courseId,
                formData, {
                    headers: {'Content-Type': 'multipart/form-data'}
                })
                .then(result=>{
                    UIkit.notification({message:result.message, status: 'success'});
                    setTimeout(()=>{window.location.replace('/instructor/'+url+'/course/create/'+courseId)},1000);
                })
                .catch((error) => {
                    UIkit.notification({message:error.message, status: 'danger'});
                    console.log(error.message)
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

    function achievementsPost(moduleName, courseId) {
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
        axios.post('/api/instructor/'+moduleName+'/course/'+courseId+'/goals', formData)
            .then(response=>{console.log(response);
                UIkit.notification({message:response.data.result, status: 'success'});
            })
            .catch((error) => {
                UIkit.notification({message:error.message, status: 'danger'});
            });
    }
</script>
<style>
    #imagePreview{
        padding-top:calc( 190 / 367 * 90%);
    }
</style>
</html>
