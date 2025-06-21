@extends('layouts.admin')
@section('page-title')
    {{ __('Dashboard') }}
@endsection

@push('css-page')
<style>
    :root {
        --primary-color: #6fd944; /* fallback, will be set dynamically */
    }
    .dashboard-3d-card {
        background: #fff !important;
        border-radius: 1.25rem;
        box-shadow:
            0 2px 8px 0 rgba(31, 38, 135, 0.10),
            0 8px 32px 0 rgba(31, 38, 135, 0.12),
            0 16px 48px 0 rgba(31, 38, 135, 0.10),
            0 1.5px 8px 0 rgba(0,0,0,0.08);
        border: 1px solid rgba(0,0,0,0.05);
        transition: box-shadow 0.4s cubic-bezier(.4,2,.6,1), transform 0.4s cubic-bezier(.4,2,.6,1), background 0.4s, color 0.4s;
        position: relative;
        overflow: hidden;
    }
    /* Text/icons use primary color by default on white */
    .dashboard-3d-card h2.fw-bold,
    .dashboard-3d-card h6.text-muted,
    .dashboard-3d-card .small.text-muted,
    .dashboard-3d-card .dashboard-3d-icon svg {
        color: var(--primary-color) !important;
        transition: color 0.4s;
    }
    .dashboard-3d-card .fw-semibold.text-dark {
        color: #111 !important;
        transition: color 0.4s;
    }
    /* On hover, card becomes black, text/icons become white for contrast */
    .dashboard-3d-card:hover {
        background: #111 !important;
        box-shadow:
            0 8px 32px 0 rgba(31, 38, 135, 0.18),
            0 24px 64px 0 rgba(31, 38, 135, 0.16),
            0 2px 16px 0 rgba(0,0,0,0.12);
        transform: translateY(-8px) scale(1.07) rotateX(2deg);
        transition: box-shadow 0.4s cubic-bezier(.4,2,.6,1), transform 0.4s cubic-bezier(.4,2,.6,1), background 0.4s, color 0.4s;
    }
    .dashboard-3d-card:hover .dashboard-3d-icon svg,
    .dashboard-3d-card:hover h2.fw-bold,
    .dashboard-3d-card:hover h6.text-muted,
    .dashboard-3d-card:hover .small.text-muted,
    .dashboard-3d-card:hover .fw-semibold.text-dark {
        color: #fff !important;
        transition: color 0.4s;
    }
    body.dark-mode .dashboard-3d-card {
        background: #111 !important;
        border-color: rgba(255,255,255,0.08);
        color: #fff;
        transition: background 0.4s, color 0.4s, box-shadow 0.4s, transform 0.4s;
    }
    body.dark-mode .dashboard-3d-card:hover {
        background: #fff !important;
        color: #111;
        transition: background 0.4s, color 0.4s, box-shadow 0.4s, transform 0.4s;
    }
    body.dark-mode .dashboard-3d-card:hover .dashboard-3d-icon svg,
    body.dark-mode .dashboard-3d-card:hover h2.fw-bold,
    body.dark-mode .dashboard-3d-card:hover h6.text-muted,
    body-dark-mode .dashboard-3d-card:hover .small.text-muted,
    body.dark-mode .dashboard-3d-card:hover .fw-semibold.text-dark {
        color: #111 !important;
        transition: color 0.4s;
    }

    @media (max-width: 576px) {
        .dashboard-3d-card .dropdown-menu {
            min-width: 100vw !important;
            left: 0 !important;
            right: 0 !important;
            transform: none !important;
            position: fixed !important;
            bottom: 0;
            top: auto !important;
            border-radius: 1.25rem 1.25rem 0 0;
            box-shadow: 0 -2px 16px rgba(0,0,0,0.12);
            z-index: 1055;
            max-height: 50vh;
            overflow-y: auto;
            padding-bottom: env(safe-area-inset-bottom, 16px);
        }
        .dashboard-3d-card .dropdown-menu .dropdown-item {
            font-size: 1.1rem;
            padding: 1rem 1.5rem;
        }
    }
</style>
<script>
    // Dynamically set --primary-color from theme or custom color
    document.addEventListener('DOMContentLoaded', function() {
        var style = getComputedStyle(document.body);
        var themeColor = style.getPropertyValue('--theme-color');
        var customColor = style.getPropertyValue('--color-customColor');
        var primary = '#6fd944';
        if(document.body.classList.contains('custom-color') && customColor) {
            primary = customColor.trim();
        } else if(themeColor) {
            primary = themeColor.trim();
        }
        document.documentElement.style.setProperty('--primary-color', primary);
        // Check if primary color is dark, add data-primary-dark to cards
        function isDark(hex) {
            hex = hex.replace('#','');
            if(hex.length === 3) hex = hex.split('').map(x=>x+x).join('');
            var r = parseInt(hex.substr(0,2),16), g = parseInt(hex.substr(2,2),16), b = parseInt(hex.substr(4,2),16);
            // Perceived brightness
            return (r*0.299 + g*0.587 + b*0.114) < 128;
        }
        var dark = isDark(primary);
        document.querySelectorAll('.dashboard-3d-card').forEach(function(card){
            if(dark) card.setAttribute('data-primary-dark','true');
            else card.removeAttribute('data-primary-dark');
        });
    });
</script>
@endpush

@push('theme-script')
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
@endpush

@push('script-page')
<script>
    (function() {
        var chartBarOptions = {
            series: [{
                name: '{{ __('Income') }}',
                data: {!! json_encode($chartData['data']) !!},
            }],
            chart: {
                height: 300,
                type: 'area',
                dropShadow: {
                    enabled: true,
                    color: '#000',
                    top: 18,
                    left: 7,
                    blur: 10,
                    opacity: 0.2
                },
                toolbar: { show: false }
            },
            dataLabels: { enabled: false },
            stroke: { width: 2, curve: 'smooth' },
            xaxis: {
                categories: {!! json_encode($chartData['label']) !!},
                title: { text: '{{ __('Months') }}' }
            },
            colors: ['#6fd944'],
            grid: { strokeDashArray: 4 },
            legend: { show: false },
            yaxis: {
                title: {
                    text: '{{ __('Income') }}',
                    offsetX: 30,
                    offsetY: -10,
                }
            }
        };
        var arChart = new ApexCharts(document.querySelector("#chart-sales"), chartBarOptions);
        arChart.render();
    })();
</script>
@endpush

@php
    $admin_payment_setting = Utility::getAdminPaymentSetting();
@endphp

@section('content')
<div class="row mb-4 gy-4">
    <div class="col-xxl-4 col-md-6 col-12">
        <div class="card dashboard-3d-card h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                <div class="dashboard-3d-icon">
                    {{-- New Total Plans Icon --}}
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="4"/>
                        <path d="M7 7h10M7 12h10M7 17h6"/>
                    </svg>
                </div>
                <h6 class="text-muted mb-1">{{ __('Total Plans') }}</h6>
                <h2 class="fw-bold mb-0">{{ $user->total_plan }}</h2>
                <div class="small text-muted mt-2">
                    {{ __('Most Purchase Plan:') }} <span class="fw-semibold text-dark">{{ $user['most_purchese_plan'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-4 col-md-6 col-12">
        <div class="card dashboard-3d-card h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                <div class="dashboard-3d-icon">
                    {{-- New Total Orders Icon --}}
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2"/>
                        <path d="M16 3v4M8 3v4M2 11h20"/>
                    </svg>
                </div>
                <h6 class="text-muted mb-1">{{ __('Total Orders') }}</h6>
                <h2 class="fw-bold mb-0">{{ $user->total_orders }}</h2>
                <div class="small text-muted mt-2">
                    {{ __('Total Order Amount:') }} <span class="fw-semibold text-dark">{{ env('CURRENCY_SYMBOL') }}{{ $user['total_orders_price'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-4 col-md-6 col-12">
        <div class="card dashboard-3d-card h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center position-relative w-100">
                <div class="dashboard-3d-icon">
                    {{-- New Companies Icon --}}
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="7" width="7" height="13" rx="2"/>
                        <rect x="14" y="3" width="7" height="17" rx="2"/>
                        <path d="M7 10v4M17 6v4"/>
                    </svg>
                </div>
                <div class="dropdown position-absolute end-0 top-0 m-3">
                    <button class="btn btn-sm btn-light border dropdown-toggle d-flex align-items-center gap-2" type="button" id="companyFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="min-width: 90px;">
                        <span class="d-none d-sm-inline">{{ ucfirst($user['current_filter'] ?? request('company_filter', 'all')) }}</span>
                        <span class="d-inline d-sm-none"><i class="fas fa-filter"></i></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm animate__animated animate__fadeIn" aria-labelledby="companyFilterDropdown" style="min-width: 120px;">
                        <li><a class="dropdown-item py-2 px-3" href="?company_filter=day">{{ __('Day') }}</a></li>
                        <li><a class="dropdown-item py-2 px-3" href="?company_filter=week">{{ __('Week') }}</a></li>
                        <li><a class="dropdown-item py-2 px-3" href="?company_filter=month">{{ __('Month') }}</a></li>
                        <li><a class="dropdown-item py-2 px-3" href="?company_filter=all">{{ __('All') }}</a></li>
                    </ul>
                </div>
                <h6 class="text-muted mb-1 mt-2">{{ __('Total Companies') }}</h6>
                <h2 class="fw-bold mb-0">{{ $user['filtered_companies'] ?? $user->total_user }}</h2>
                <div class="small text-muted mt-2">
                    {{ __('Paid Companies:') }} <span class="fw-semibold text-dark">{{ $user['filtered_paid_companies'] ?? $user->total_paid_user ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xxl-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Recent Order') }}</h5>
            </div>
            <div class="card-body">
                <div class="chart">
                    <div id="chart-sales" data-color="primary" data-height="280"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
