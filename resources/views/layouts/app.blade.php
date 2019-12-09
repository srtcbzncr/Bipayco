<div id="app1">
    <div class="side-nav uk-animation-slide-left-medium" id="side-nav">
        <!--Mobile icon wiill close nav-side   -->
        <span class="uk-animation-fade tm-mobile-close-icon" uk-toggle="target: #side-nav; cls: side-nav-active"> <i class="fas fa-times icon-large"></i></span>
        <side-bar></side-bar>
    </div>
    <div id="app">
        <main class="py-4">
            <top-bar></top-bar>
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
