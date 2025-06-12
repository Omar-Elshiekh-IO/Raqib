@php
    use App\Models\Utility;
    $setting = \App\Models\Utility::settings();

    $logo = \App\Models\Utility::get_file('uploads/logo');

    $company_favicon = $setting['company_favicon'] ?? '';

    $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';

    if(isset($setting['color_flag']) && $setting['color_flag'] == 'true')
    {
        $themeColor = 'custom-color';
    }
    else {
        $themeColor = $color;
    }

    $SITE_RTL = $setting['SITE_RTL'] ?? '';

    $lang = \App::getLocale('lang');
    if ($lang == 'ar' || $lang == 'he') {
        $SITE_RTL = 'on';
    }

    $metatitle = isset($setting['meta_title']) ? $setting['meta_title'] : '';
    $metsdesc = isset($setting['meta_desc']) ? $setting['meta_desc'] : '';
    $meta_image = \App\Models\Utility::get_file('uploads/meta/');
    $meta_logo = isset($setting['meta_image']) ? $setting['meta_image'] : '';

@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $SITE_RTL == 'on' ? 'rtl' : '' }}">

<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

<head>
    <title>{{ $setting['title_text'] ? $setting['title_text'] : config('app.name', 'ERPGO') }} - @yield('page-title')
    </title>

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


    <script src="{{ asset('js/html5shiv.js') }}"></script>


    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="url" content="{{ url('') . '/' . config('chatify.path') }}" data-user="{{ Auth::user()->id }}">
    <link rel="icon"
        href="{{ $logo . '/' . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png')  . '?' . time() }}"
        type="image" sizes="16x16">

    <!-- Favicon icon -->
    <!-- Calendar-->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/main.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/flatpickr.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.min.css') }}">

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!--bootstrap switch-->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">

    <!-- vendor css -->

    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif

    @if ($setting['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}" id="main-style-link">
    @endif

    @if ($SITE_RTL != 'on' && $setting['cust_darklayout'] != 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @endif

    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    @if ($setting['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('css/custom-dark.css') }}">
    @endif

    <style>
        :root {
            --color-customColor: <?= $color ?>;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/custom-color.css') }}">
    @stack('css-page')


</head>



<body class="{{ $themeColor }}">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <div class="dash-layout">
        @include('partials.admin.menu')
        <div class="dash-main">
            @include('partials.admin.header')
            <!-- Modal -->
            <div class="modal notification-modal fade" id="notification-modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            <h6 class="mt-2">
                                <i data-feather="monitor" class="me-2"></i>Desktop settings
                            </h6>
                            <hr />
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="pcsetting1" checked />
                                <label class="form-check-label f-w-600 pl-1" for="pcsetting1">Allow desktop notification</label>
                            </div>
                            <p class="text-muted ms-5">
                                you get lettest content at a time when data will updated
                            </p>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="pcsetting2" />
                                <label class="form-check-label f-w-600 pl-1" for="pcsetting2">Store Cookie</label>
                            </div>
                            <h6 class="mb-0 mt-5">
                                <i data-feather="save" class="me-2"></i>Application settings
                            </h6>
                            <hr />
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="pcsetting3" />
                                <label class="form-check-label f-w-600 pl-1" for="pcsetting3">Backup Storage</label>
                            </div>
                            <p class="text-muted mb-4 ms-5">
                                Automaticaly take backup as par schedule
                            </p>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="pcsetting4" />
                                <label class="form-check-label f-w-600 pl-1" for="pcsetting4">Allow guest to print
                                    file</label>
                            </div>
                            <h6 class="mb-0 mt-5">
                                <i data-feather="cpu" class="me-2"></i>System settings
                            </h6>
                            <hr />
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="pcsetting5" checked />
                                <label class="form-check-label f-w-600 pl-1" for="pcsetting5">View other user chat</label>
                            </div>
                            <p class="text-muted ms-5">Allow to show public user message</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-danger btn-sm" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="button" class="btn btn-light-primary btn-sm">
                                Save changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Header ] end -->

            <!-- [ Main Content ] start -->
            <div class="dash-container">
                <div class="dash-content">
                    <div class="page-header">
                        <div class="page-block">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                <div>
                                    <div class="page-header-title">
                                        <h4 class="mb-2">@yield('page-title')</h4>
                                    </div>
                                    <ul class="breadcrumb">
                                        @yield('breadcrumb')
                                    </ul>
                                </div>
                                <div class="action-btn-col">
                                    @yield('action-btn')
                                </div>
                            </div>
                        </div>
                    </div>
                    @yield('content')
                    <!-- [ Main Content ] end -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="body">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="commonModalOver" tabindex="-1" role="dialog" aria-labelledby="commonModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commonModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    <div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
        <div id="liveToast" class="toast text-white fade" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
    @include('partials.admin.footer')
    @include('Chatify::layouts.footerLinks')

    <style>
        .dash-layout {
            display: flex;
            /* Remove width: 100vw to prevent horizontal overflow */
            height: 100vh;
        }
        .dash-main {
            flex: 1 1 0%;
            min-width: 0;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-left: 220px; /* default expanded sidebar */
        }
        .dash-sidebar.sidebar-hoverable:not(:hover) ~ .dash-main {
            margin-left: 60px !important;
        }
        .dash-container {
            flex: 1 1 0%;
            min-width: 0;
            width: 100%;
            height: 100%;
            padding: 0;
            overflow: visible;
        }
        .dash-content {
            flex: 1 1 0%;
            min-width: 0;
            width: 100%;
            max-width: 100%;
            height: 100%;
            padding: 16px 8px 8px 8px; /* reduce padding for more space */
            box-sizing: border-box;
            overflow-x: auto;
        }
        @media (max-width: 991.98px) {
            .dash-main {
                margin-left: 0 !important;
            }
        }
    </style>
    <script>
        // Add/remove a class on body to reflect sidebar hover state for margin control
        document.addEventListener('DOMContentLoaded', function() {
            var sidebar = document.querySelector('.dash-sidebar.sidebar-hoverable');
            var main = document.querySelector('.dash-main');
            if(sidebar && main) {
                sidebar.addEventListener('mouseenter', function() {
                    main.style.marginLeft = '220px';
                });
                sidebar.addEventListener('mouseleave', function() {
                    main.style.marginLeft = '60px';
                });
                // Set initial state
                if(!sidebar.matches(':hover')) {
                    main.style.marginLeft = '60px';
                }
            }
        });
    </script>

</body>

</html>
