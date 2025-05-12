<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>@yield('title', 'Store')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content=""/>
    <meta name="keywords" content="Saas, Software, multi-uses, HTML, Clean, Modern"/>

    <!-- favicon -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <!-- Slider -->
    <link rel="stylesheet" href="css/tiny-slider.css"/>
    <!-- Icons -->
    <link href="css/materialdesignicons.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="unicons.iconscout.com/release/v3.0.6/css/line.css">
    <!-- Main Css -->
    <link href="css/style.min.css" rel="stylesheet" type="text/css" id="theme-opt"/>
    <link href="css/colors/default.css" rel="stylesheet" id="color-opt">
</head>

<body>
<!-- Loader -->
<div id="preloader" class="d-none">
    <div id="status">
        <div class="spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>
</div>
<!-- Loader -->

<!-- Navbar STart -->
@include('website.layouts.navbar')
<!-- Navbar End -->

@yield('carousel')

<section class="section">
    <div class="container mt-100 mt-60">
        @yield('content')
    </div>
</section>

<!-- Footer Start -->
@include('website.layouts.footer')
<!-- Footer End -->

<!-- Back to top -->
@include('website.partials.top-btn')
<!-- Back to top -->

<!-- Style switcher -->
<div id="style-switcher" class="bg-light border p-3 pt-2 pb-2" onclick="toggleSwitcher()">
    <div>
        <h6 class="title text-center">pick a color</h6>
        <ul class="pattern">
            <li class="list-inline-item">
                <a class="color1" href="javascript: void(0);" onclick="setColor('default')"></a>
            </li>
            <li class="list-inline-item">
                <a class="color2" href="javascript: void(0);" onclick="setColor('green')"></a>
            </li>
            <li class="list-inline-item">
                <a class="color3" href="javascript: void(0);" onclick="setColor('purple')"></a>
            </li>
            <li class="list-inline-item">
                <a class="color4" href="javascript: void(0);" onclick="setColor('red')"></a>
            </li>
            <li class="list-inline-item">
                <a class="color5" href="javascript: void(0);" onclick="setColor('skyblue')"></a>
            </li>
            <li class="list-inline-item">
                <a class="color6" href="javascript: void(0);" onclick="setColor('skobleoff')"></a>
            </li>
            <li class="list-inline-item">
                <a class="color7" href="javascript: void(0);" onclick="setColor('cyan')"></a>
            </li>
            <li class="list-inline-item">
                <a class="color8" href="javascript: void(0);" onclick="setColor('slateblue')"></a>
            </li>
            <li class="list-inline-item">
                <a class="color9" href="javascript: void(0);" onclick="setColor('yellow')"></a>
            </li>
        </ul>
    </div>
    <div class="bottom">
        <a href="javascript: void(0);" class="settings bg-white shadow d-block"><i
                class="mdi mdi-cog ms-1 mdi-24px position-absolute position-absolute mdi-spin text-primary"></i></a>
    </div>
</div>
<!-- end Style switcher -->

<!-- javascript -->
<script src="js/bootstrap.bundle.min.js"></script>
<!-- SLIDER -->
<script src="js/tiny-slider.js"></script>
<!-- Icons -->
<script src="js/feather.min.js"></script>
<!-- Switcher -->
<script src="js/switcher.js"></script>
<!-- Main Js -->
<script src="js/plugins.init.js"></script>
<script src="js/app.js"></script>
</body>

</html>
