<!DOCTYPE html>
@php
    use App\Models\Utility;

    $setting = Utility::settings();
    $company_logo = $setting['company_logo_dark'] ?? '';
    $company_logos = $setting['company_logo_light'] ?? '';
    $company_favicon = $setting['company_favicon'] ?? '';

    $logo = \App\Models\Utility::get_file('uploads/logo/');

    $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';

    if(isset($setting['color_flag']) && $setting['color_flag'] == 'true')
    {
        $themeColor = 'custom-color';
    }
    else {
        $themeColor = $color;
    }

    $company_logo = \App\Models\Utility::GetLogo();
    $SITE_RTL = isset($setting['SITE_RTL']) ? $setting['SITE_RTL'] : 'off';

    $lang = \App::getLocale('lang');
    if ($lang == 'ar' || $lang == 'he') {
        $SITE_RTL = 'on';
    }
    elseif($SITE_RTL == 'on')
    {
        $SITE_RTL = 'on';
    }
    else {
        $SITE_RTL = 'off';
    }

    $metatitle = isset($setting['meta_title']) ? $setting['meta_title'] : '';
    $metsdesc = isset($setting['meta_desc']) ? $setting['meta_desc'] : '';
    $meta_image = \App\Models\Utility::get_file('uploads/meta/');
    $meta_logo = isset($setting['meta_image']) ? $setting['meta_image'] : '';
    $get_cookie = isset($setting['enable_cookie']) ? $setting['enable_cookie'] : '';

@endphp

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ $SITE_RTL == 'on' ? 'rtl' : '' }}">

<head>
    <title>
        {{ Utility::getValByName('title_text') ? Utility::getValByName('title_text') : config('app.name', 'ERPGO') }}
        - @yield('page-title')</title>

    <meta name="title" content="{{ $metatitle }}">
    <meta name="description" content="{{ $metsdesc }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:title" content="{{ $metatitle }}">
    <meta property="og:description" content="{{ $metsdesc }}">
    <meta property="og:image" content="{{ $meta_image . $meta_logo }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:title" content="{{ $metatitle }}">
    <meta property="twitter:description" content="{{ $metsdesc }}">
    <meta property="twitter:image" content="{{ $meta_image . $meta_logo }}">


    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Dashboard Template Description" />
    <meta name="keywords" content="Dashboard Template" />
    <meta name="author" content="WorkDo" />

    <!-- Favicon icon -->
    <link rel="icon"
        href="{{ $logo . '/' . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png')  . '?' . time() }}"
        type="image/x-icon" />

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@900&display=swap" rel="stylesheet">

    <!-- vendor css -->

    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
    @endif

    @if ($setting['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @endif

    @if ($SITE_RTL != 'on' && $setting['cust_darklayout'] != 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @endif


    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/custom-auth-rtl.css') }}" id="main-style-link">
        @else
        <link rel="stylesheet" href="{{ asset('assets/css/custom-auth.css') }}" id="main-style-link">
    @endif

    @if ($setting['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/custom-auth-dark.css') }}" id="main-style-link">
    @endif

    <style>
        :root {
            --color-customColor: <?= $color ?>;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/custom-color.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

</head>

<body class="{{ $themeColor }}">
    <!-- Parallax Scroll Effect Start -->
    <div id="parallax-effect-wrapper">
        <div class="scrollDist"></div>
        <main id="parallax-main">
          <svg viewBox="0 0 1200 800" xmlns="http://www.w3.org/2000/svg">
            <mask id="m">
              <g class="cloud1">
                <rect fill="#fff" width="100%" height="801" y="799" />
                <image xlink:href="https://assets.codepen.io/721952/cloud1Mask.jpg" width="1200" height="800"/>
              </g>
            </mask>
            <image class="sky" xlink:href="https://assets.codepen.io/721952/sky.jpg"  width="1200" height="590" />
            <image class="mountBg" xlink:href="https://assets.codepen.io/721952/mountBg.png" width="1200" height="800"/>    
            <image class="mountMg" xlink:href="https://assets.codepen.io/721952/mountMg.png" width="1200" height="800"/>    
            <image class="cloud2" xlink:href="https://assets.codepen.io/721952/cloud2.png" width="1200" height="800"/>    
            <image class="mountFg" xlink:href="https://assets.codepen.io/721952/mountFg.png" width="1200" height="800"/>
            <image class="cloud1" xlink:href="https://assets.codepen.io/721952/cloud1.png" width="1200" height="800"/>
            <image class="cloud3" xlink:href="https://assets.codepen.io/721952/cloud3.png" width="1200" height="800"/>
            <text fill="#fff" x="350" y="200">Swipe down</text>
            <polyline class="arrow" fill="#fff" points="599,250 599,289 590,279 590,282 600,292 610,282 610,279 601,289 601,250" />
            <g mask="url(#m)">
              <rect fill="#fff" width="100%" height="100%" />      
              <text x="350" y="200" fill="#162a43">FURTHER</text>
            </g>
            <rect id="arrow-btn" width="100" height="100" opacity="0" x="550" y="220" style="cursor:pointer"/>
          </svg>
        </main>
        <style>
        #parallax-effect-wrapper { width:100vw; margin:0; padding:0; }
        #parallax-main { position:relative; background:#fff; width:100vw; height:800px; overflow:hidden; border-radius:0; box-shadow:none; }
        .scrollDist { width:100vw; height:200%; position:absolute; top:0; left:0; z-index:-1; }
        @media (max-width: 1200px) { #parallax-main { width:100vw; } }
        @media (max-width: 800px) { #parallax-main { height:400px; font-size:40px; } }
        #parallax-main text {
          font-family: 'Montserrat', Arial, Helvetica, sans-serif;
          font-weight: 900;
          letter-spacing: 2px;
          font-size: 80px;
          dominant-baseline: middle;
        }
        </style>
    </div>
    <!-- Parallax Scroll Effect End -->
    <div class="custom-login">
        <div class="login-bg-img">
            <img src="{{ isset($setting['color_flag']) && $setting['color_flag'] == 'false' ? asset('assets/images/auth/'.$color.'.svg') : asset('assets/images/auth/theme-3.svg') }}" class="login-bg-1">
            <img src="{{ asset('assets/images/auth/common.svg') }}" class="login-bg-2">
        </div>
        <div class="bg-login bg-primary"></div>
        <div class="custom-login-inner">
            <header class="dash-header">
                <nav class="navbar navbar-expand-md default">
                    <div class="container">
                        <div class="navbar-brand">

                        <a class="navbar-brand" href="#">
                            @if ($setting['cust_darklayout'] == 'on')
                                <img class="logo"
                                    src="{{ $logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-light.png') . '?' . time() }}"
                                    alt="" loading="lazy"/>
                            @else
                                <img class="logo"
                                    src="{{ $logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') . '?' . time() }}"
                                    alt="" loading="lazy"/>
                            @endif
                        </a>


                        </div>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarlogin">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarlogin">
                            <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                                @include('landingpage::layouts.buttons')
                                @yield('language-bar')
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <main class="custom-wrapper">
                <div class="custom-row">
                    <div class="card">
                        @yield('content')
                    </div>
                </div>
            </main>
            <footer>
                <div class="auth-footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <span>&copy; {{ date('Y') }}
                                    {{ App\Models\Utility::getValByName('footer_text') ? App\Models\Utility::getValByName('footer_text') : config('app.name', 'Storego Saas') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    @if ($get_cookie == 'on')
        @include('layouts.cookie_consent')
    @endif

    <!-- [ auth-signup ] end -->

    <!-- Required Js -->
    <script src="{{ asset('assets/js/vendor-all.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>


    <script>
        feather.replace();
    </script>

    @if (\App\Models\Utility::getValByName('cust_darklayout') == 'on')
        <style>
            .g-recaptcha {
                filter: invert(1) hue-rotate(180deg) !important;
            }
        </style>
    @endif


    <script>
        feather.replace();
        var pctoggle = document.querySelector("#pct-toggler");
        if (pctoggle) {
            pctoggle.addEventListener("click", function() {
                if (
                    !document.querySelector(".pct-customizer").classList.contains("active")
                ) {
                    document.querySelector(".pct-customizer").classList.add("active");
                } else {
                    document.querySelector(".pct-customizer").classList.remove("active");
                }
            });
        }

        var themescolors = document.querySelectorAll(".themes-color > a");
        for (var h = 0; h < themescolors.length; h++) {
            var c = themescolors[h];

            c.addEventListener("click", function(event) {
                var targetElement = event.target;
                if (targetElement.tagName == "SPAN") {
                    targetElement = targetElement.parentNode;
                }
                var temp = targetElement.getAttribute("data-value");
                removeClassByPrefix(document.querySelector("body"), "theme-");
                document.querySelector("body").classList.add(temp);
            });
        }
        function removeClassByPrefix(node, prefix) {
            for (let i = 0; i < node.classList.length; i++) {
                let value = node.classList[i];
                if (value.startsWith(prefix)) {
                    node.classList.remove(value);
                }
            }
        }
    </script>
    @push('custom-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollToPlugin.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
      if (window.gsap && window.ScrollTrigger) {
        gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);
        gsap.timeline({
          scrollTrigger:{
            trigger:'.scrollDist',
            start:'0 0',
            end:'100% 100%',
            scrub:1
          }
        })
        .fromTo('.sky', {y:0},{y:-200}, 0)
        .fromTo('.cloud1', {y:100},{y:-800}, 0)
        .fromTo('.cloud2', {y:-150},{y:-500}, 0)
        .fromTo('.cloud3', {y:-50},{y:-650}, 0)
        .fromTo('.mountBg', {y:-10},{y:-100}, 0)
        .fromTo('.mountMg', {y:-30},{y:-250}, 0)
        .fromTo('.mountFg', {y:-50},{y:-600}, 0);

        const arrowBtn = document.querySelector('#arrow-btn');
        if(arrowBtn) {
          arrowBtn.addEventListener('mouseenter', ()=>{
            gsap.to('.arrow', {y:10, duration:0.8, ease:'back.inOut(3)', overwrite:'auto'}) 
          });
          arrowBtn.addEventListener('mouseleave', ()=> {
            gsap.to('.arrow', {y:0, duration:0.5, ease:'power3.out', overwrite:'auto'}) 
          });
          arrowBtn.addEventListener('click', ()=> {
            gsap.to(window, {scrollTo:innerHeight, duration:1.5, ease:'power1.inOut'});
          });
        }
      }
    });
    </script>
    @endpush
    @stack('custom-scripts')

</body>

</html>
