@extends('layouts.admin_panel')

@section('content')
    <div class="uk-child-width-1-3@m uk-child-width-1-2 uk-grid-match " uk-grid>
        <div>
            <div class="uk-background-cover uk-light dashboard-card" data-src="#" uk-img>
                <i class="fas fa-play icon-xxlarge uk-visible@m"></i>
                <h3> 32 Course </h3>
                <p> pro detracto disputando reformidans at</p>
                <a href="#"> View All </a>
            </div>
        </div>
        <div>
            <div class="uk-background-cover uk-light dashboard-card" data-src="#" uk-img>
                <i class="far fa-user icon-xxlarge uk-visible@m"></i>
                <h3> 120 User </h3>
                <p>  pro detracto disputando reformidans at </p>
                <a href="#"> View All </a>
            </div>
        </div>
        <div>
            <div class="uk-background-cover uk-light dashboard-card" data-src="#" uk-img>
                <i class="fas fa-code icon-xxlarge uk-visible@m"></i>
                <h3> 10 Script </h3>
                <p>  pro detracto disputando reformidans at </p>
                <a href="#"> View All </a>
            </div>
        </div>
    </div>

    <div uk-grid class="uk-margin-xlarge-top uk-margin-xlarge-bottom">
        <div class="uk-width-1-2@m">
            <div class="uk-card-small uk-card-default">
                <div class="uk-card-header uk-text-bold">
                    <i class="fas fa-users uk-margin-small-right"></i> Latest  Regsiter users
                </div>
                <div class="uk-card-body uk-padding-remove-top">
                    <div class="uk-child-width-1-4@m uk-child-width-1-2 uk-grid-collapse uk-flex-center"  uk-scrollspy="target: > div; cls:uk-animation-scale-up; delay: 100" uk-grid>
                        <registered-profile username="Ben Addams" profile-path="#" img-path="#"></registered-profile>
                        <registered-profile username="Ben Addams" profile-path="#" img-path="#"></registered-profile>
                        <registered-profile username="Ben Addams" profile-path="#" img-path="#"></registered-profile>
                        <registered-profile username="Ben Addams" profile-path="#" img-path="#"></registered-profile>
                        <registered-profile username="Ben Addams" profile-path="#" img-path="#"></registered-profile>
                        <registered-profile username="Ben Addams" profile-path="#" img-path="#"></registered-profile>
                        <registered-profile username="Ben Addams" profile-path="#" img-path="#"></registered-profile>
                        <registered-profile username="Ben Addams" profile-path="#" img-path="#"></registered-profile>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-width-1-2@m">
            <div class="uk-card-small uk-card-default">
                <div class="uk-card-header uk-text-bold">
                    <i class="fas fa-comment uk-margin-small-right"></i> Latest  Comments
                </div>
                <div class="uk-card-body uk-overflow-auto" style="max-height: 300px;">
                    <comment comment="aşlksdhdjfşlaksjdflşkas asdasdasdfsdfasdfasdfasdfasd fasdfasdfsadfjdfşlkjasdşlfkjasdşf sdasdasdasdasdasdlkjasdfşlkjasdfşlksjadfşlkjasd" profile-photo="#"></comment>
                    <comment comment="aşlksdhdjfşlaksjdflşkas asdasdasdfsdfasdfasdfasdfasd fasdfasdfsadfjdfşlkjasdşlfkjasdşf sdasdasdasdasdasdlkjasdfşlkjasdfşlksjadfşlkjasd" profile-photo="#"></comment>
                    <comment comment="aşlksdhdjfşlaksjdflşkas asdasdasdfsdfasdfasdfasdfasd fasdfasdfsadfjdfşlkjasdşlfkjasdşf sdasdasdasdasdasdlkjasdfşlkjasdfşlksjadfşlkjasd" profile-photo="#"></comment>
                    <comment comment="aşlksdhdjfşlaksjdflşkas asdasdasdfsdfasdfasdfasdfasd fasdfasdfsadfjdfşlkjasdşlfkjasdşf sdasdasdasdasdasdlkjasdfşlkjasdfşlksjadfşlkjasd" profile-photo="#"></comment>
                    <comment comment="aşlksdhdjfşlaksjdflşkas asdasdasdfsdfasdfasdfasdfasd fasdfasdfsadfjdfşlkjasdşlfkjasdşf sdasdasdasdasdasdlkjasdfşlkjasdfşlksjadfşlkjasd" profile-photo="#"></comment>
                </div>
            </div>
        </div>
    </div>
@endsection
