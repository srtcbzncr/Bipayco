<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{asset('/images/Bipayco.ico')}}">
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
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/uikit.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin.css')}}" rel="stylesheet">
    <link href="{{asset('css/dropzone.css')}}" rel="stylesheet">
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
    <link href="{{asset('css/fontawesome.css')}}" rel="stylesheet">
    <style>
        /*color1: #80f5d2; color2: #86e6ef;*/
        .stats-card{
            border-radius: 20px;
            background: rgb(128,245,210);
            background: linear-gradient(145deg, rgba(128,245,210,1) 0%, rgba(134,230,239,1) 100%);
            color: #156d7a;
        }
        .stats-card-title{
            color: #156d7a !important;
        }
    </style>
</head>
<body>
    <!-- sidebar -->
    <div class="admin-side overflow-auto" id="admin-side">
        <div class="uk-flex uk-flex-center uk-margin-medium-top uk-margin-medium-bottom">
            <a class="uk-flex align-items-center justify-content-center" href="{{route('home')}}">
                <img class="uk-logo uk-width-5-6" src="{{asset('images/logo1.png')}}"/>
            </a>
        </div>
        <ul>
            <li>
                <a href="{{route('instructor_courses')}}"> <i class="fas fa-chalkboard"></i>  @lang('front/auth.my_courses') </a>
            </li>
{{--            <li>--}}
{{--                <a href="{{route('instructor_books')}}"> <i class="fas fa-book-open"></i>@lang('front/auth.my_books')</a>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a href="{{route('instructor_exams')}}"> <i class="fas fa-pencil-alt"></i>@lang('front/auth.my_exams')</a>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a href="{{route('instructor_homeworks')}}"> <i class="fas fa-book"></i>@lang('front/auth.my_homework_packages')</a>--}}
{{--            </li>--}}
            <li>
                <a href="{{route('instructor_performance')}}"> <i class="fas fa-chart-line"></i>@lang('front/auth.performance')</a>
            </li>
            <li>
                <a href="{{route('instructor_questions')}}"> <i class="fas fa-question"></i>@lang('front/auth.questions')</a>
            </li>
            <li>
                <a href="{{route('questionSource_show')}}"> <i class="fas fa-bookmark"></i>@lang('front/auth.question_source')</a>
            </li>
            <li>
                <a href="{{route('student_profile', Auth::user()->id)}}"> <i class="fas fa-graduation-cap"></i>@lang('front/auth.student_mode')</a>
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
        <a class="" href="{{route('home')}}"> <img class="uk-width-small" src="{{asset('images/logo1.png')}}"/> </a>
    </div>
    <div class="admin-content uk-height-viewport">
        <div id="app1" class="admin-content-inner">
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
            formData.append('score',document.querySelector('#score').value);
            formData.append('grade_id',document.querySelector('#gradeType').value);
            formData.append('lesson_id',document.querySelector('#lessonType').value);
            url="pl";
        }else if(moduleName=="prepareExams"){
            formData.append('score',document.querySelector('#score').value);
            formData.append('exam_id',document.querySelector('#courseExam').value);
            url="pe";
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
                }).catch((error)=>{
                if(error.response) {
                    if(error.response.errorMessage){
                        UIkit.notification({message: error.response.data.errorMessage, status: 'danger'});
                    }else{
                        UIkit.notification({message: error.response.data.message, status: 'danger'});
                    }
                }});
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
                .catch((error)=>{
                    if(error.response) {
                        if(error.response.errorMessage){
                            UIkit.notification({message: error.response.data.errorMessage, status: 'danger'});
                        }else{
                            UIkit.notification({message: error.response.data.message, status: 'danger'});
                        }
                    }});
        }
    }
    function livePost(bool){
        var formData =new FormData();
        var image=document.querySelector('#newCourseImage');
        formData.append('name', document.querySelector('#name').value);
        formData.append('description', document.querySelector('#description').value);
        formData.append('price', document.querySelector('#price').value);
        formData.append('duration', document.querySelector('#duration').value);
        formData.append('price_with_discount', document.querySelector('#price').value);
        formData.append('max_participant', document.querySelector('#maxParticipant').value);
        formData.append('datetime', document.querySelector('#liveDate').value+" "+document.querySelector('#liveTime').value);
        formData.append('user_id', document.querySelector('#userId').value);
        formData.append('instructor_id',document.querySelector('#instructorId').value);

        if(image.files[0]!=undefined){
            formData.append('image', image.files[0]);
        }
        if(bool){
            axios.post('/api/instructor/live/course/create',
                formData, {
                    headers: {'Content-Type': 'multipart/form-data'}
                }).then(result=>result.data)
                .then(result=>{
                    UIkit.notification({message:result.message, status: 'success'});
                    setTimeout(()=>{window.location.replace('/instructor/live/course/create/'+result.data.id)},1000);
                })
                .catch((error)=>{
                    if(error.response) {
                        if(error.response.errorMessage){
                            UIkit.notification({message: error.response.data.errorMessage, status: 'danger'});
                        }else{
                            UIkit.notification({message: error.response.data.message, status: 'danger'});
                        }
                    }});
        }else{
            var courseId=document.querySelector('#courseCreateId').value;
            axios.post('/api/instructor/live/course/'+courseId+'/update',
                formData, {
                    headers: {'Content-Type': 'multipart/form-data'}
                })
                .then(result=>{
                    UIkit.notification({message:result.message, status: 'success'});
                    setTimeout(()=>{window.location.replace('/instructor/live/course/create/'+courseId)},1000);
                }).catch((error)=>{
                if(error.response) {
                    if(error.response.errorMessage){
                        UIkit.notification({message: error.response.data.errorMessage, status: 'danger'});
                    }else{
                        UIkit.notification({message: error.response.data.message, status: 'danger'});
                    }
                }});
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
            .then(response=>{
                if(response.data.result!=null){
                    UIkit.notification({message:response.data.result, status: 'success'});
                }else{
                    UIkit.notification({message:response.data.message, status: 'success'});
                }
            }).catch((error)=>{
            if(error.response) {
                if(error.response.errorMessage){
                    UIkit.notification({message: error.response.data.errorMessage, status: 'danger'});
                }else{
                    UIkit.notification({message: error.response.data.message, status: 'danger'});
                }
            }});
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
