@extends('layouts.admin')
@section('content')
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
                    <h2>Kurs</h2>
                </div>
                <div id="achievements" class="tabcontent  animation: uk-animation-slide-right-medium">
                    <h2>Başarımlar</h2>
                </div>
                <div id="lessons" class="tabcontent  animation: uk-animation-slide-right-medium">
                    <h2>Dersler</h2>
                </div>
                <div id="instructors" class="tabcontent  animation: uk-animation-slide-right-medium">
                    <h2>Eğitmenler</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
