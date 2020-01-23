@extends('layouts.watch')
@section('content')
    <ul class="uk-switcher">
        <!-- Course Videos tab-->
        <li>
            <!--   Videos tab 1 -->
            <div class="tabcontent tab-default-open uk-padding  animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium" id="one">
                <div class="video-responsive">
                    <iframe src="https://www.youtube.com/embed/9gTw2EDkaDQ" frameborder="0" uk-video="automute: true" allowfullscreen uk-responsive></iframe>
                </div>
            </div>
            <!--   Videos tab 2  to make outplay add ( uk-video="automute: true" ) -->
            <div class="tabcontent uk-padding animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium" id="two">
                <div class="video-responsive">
                    <iframe src="https://www.youtube.com/embed/YcApt9RgiT0" frameborder="0" allowfullscreen uk-responsive></iframe>
                </div>
            </div>
            <!--   Videos tab 3  -->
            <div class="tabcontent uk-padding animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium" id="three">
                <div class="video-responsive">
                    <iframe src="https://www.youtube.com/embed/CGSdK7FI9MY" frameborder="0" allowfullscreen uk-responsive></iframe>
                </div>
            </div>
            <!--   Videos tab 4 -->
            <div class="tabcontent uk-padding animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium" id="Four">
                <div class="video-responsive">
                    <iframe src="https://www.youtube.com/embed/4I1WgJz_lmA" frameborder="0" allowfullscreen uk-responsive></iframe>
                </div>
            </div>
            <!--   Videos tab 5  -->
            <div class="tabcontent uk-padding animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium" id="Five">
                <div class="video-responsive">
                    <iframe src="https://www.youtube.com/embed/dDn9uw7N9Xg" frameborder="0" allowfullscreen uk-responsive></iframe>
                </div>
            </div>
            <!--   Videos tab 6  -->
            <div class="tabcontent uk-padding animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium" id="Six">
                <div class="video-responsive">
                    <iframe src="https://www.youtube.com/embed/CPcS4HtrUEU" frameborder="0" allowfullscreen uk-responsive></iframe>
                </div>
            </div>
            <!--   you can add another tab by giving  the tab new (id) also you can chenge the animation of the tab ..   -->
        </li>
        <!--   Discussions tab -->
        <li>
            <div class="demo1 scrollbar-light" style="margin-top:-2px" data-simplebar>
                <div class="uk-section uk-background-grey tm-discussions-header uk-section-small">
                    <div class="uk-container-small uk-margin-auto uk-light uk-text-center">
                        <h1> Discussions </h1>
                        <p>Share what you was Learn with other Students .</p>
                        <div class="uk-inline  uk-width-1-1">
                            <span class="uk-form-icon"><i class="fas fa-search  uk-margin-small-left"></i></span>
                            <input class="uk-input  uk-form-large" type="text" placeholder="Search Something ... ">
                        </div>
                    </div>
                </div>
                <div class="uk-container-small uk-margin-auto uk-light uk-margin-medium-top">
                    <!-- post one -->
                    <div class="uk-card uk-card-default uk-card-small">
                        <div class="uk-card-header">
                            <img src="#" alt="" class="uk-border-circle uk-align-left uk-margin-remove-bottom uk-margin-small-right img-small">
                            <h5 class="uk-text-black uk-margin-small-top"> Hastie fley</h5>
                        </div>
                        <div class="uk-card-body">
                            <p class="uk-margin-small-top">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                        </div>
                    </div>
                    <!-- post two -->
                    <div class="uk-card uk-card-default uk-card-small  uk-margin-medium-top">
                        <div class="uk-card-header">
                            <img src="#" alt="" class="uk-border-circle uk-align-left uk-margin-remove-bottom uk-margin-small-right img-small">
                            <h5 class="uk-text-black uk-margin-small-top"> Hastie fley</h5>
                        </div>
                        <div class="uk-card-body">
                            <p class="uk-margin-small-top">Eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                            <pre><code id="code-jnpr9ply" class="lang-html hljs xml"><span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">uk-margin</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">a</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"uk-button uk-button-default"</span> <span class="hljs-attr">href</span>=<span class="hljs-string">"#"</span>&gt;</span>Link<span class="hljs-tag">&lt;/<span class="hljs-name">a</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">button</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"uk-button uk-button-default"</span>&gt;</span>Button<span class="hljs-tag">&lt;/<span class="hljs-name">button</span>&gt;</span><span class="hljs-tag">&lt;<span class="hljs-name">button</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"uk-button uk-button-default"</span> <span class="hljs-attr">disabled</span>&gt;</span>Disabled<span class="hljs-tag">&lt;/<span class="hljs-name">button</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span></code></pre>
                        </div>
                        <div class="uk-card-footer">
                            <a href="#" class="uk-button uk-button-text">Read more</a>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
@endsection
