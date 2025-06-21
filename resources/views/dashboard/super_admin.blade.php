@extends('layouts.admin')
@section('page-title')
    {{ __('Dashboard') }}
@endsection

@push('css-page')
<style>
    :root {
        --primary-color: #6fd944; /* fallback, will be set dynamically */
    }
    body[class*="theme-"] .dashboard-3d-card h2.fw-bold,
    body[class*="theme-"] .dashboard-3d-card h6.text-muted,
    body[class*="theme-"] .dashboard-3d-card .small.text-muted,
    body[class*="theme-"] .dashboard-3d-card .dashboard-3d-icon svg {
        color: var(--theme-color) !important;
        transition: color 0.4s;
    }
    body.custom-color .dashboard-3d-card h2.fw-bold,
    body.custom-color .dashboard-3d-card h6.text-muted,
    body.custom-color .dashboard-3d-card .small.text-muted,
    body.custom-color .dashboard-3d-card .dashboard-3d-icon svg {
        color: var(--color-customColor) !important;
        transition: color 0.4s;
    }
    .dashboard-3d-card {
        background: var(--bs-card-bg, #fff);
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
    .dashboard-3d-card:before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 1.25rem;
        pointer-events: none;
        box-shadow:
            0 1.5px 8px 0 rgba(0,0,0,0.10),
            0 8px 32px 0 rgba(31, 38, 135, 0.10),
            0 24px 64px 0 rgba(31, 38, 135, 0.08);
        opacity: 0.7;
        z-index: 0;
        transition: opacity 0.4s;
    }
    .dashboard-3d-card:hover {
        box-shadow:
            0 8px 32px 0 rgba(31, 38, 135, 0.18),
            0 24px 64px 0 rgba(31, 38, 135, 0.16),
            0 2px 16px 0 rgba(0,0,0,0.12);
        transform: translateY(-8px) scale(1.07) rotateX(2deg);
        background: #111 !important;
        transition: box-shadow 0.4s cubic-bezier(.4,2,.6,1), transform 0.4s cubic-bezier(.4,2,.6,1), background 0.4s, color 0.4s;
    }
    .dashboard-3d-card:hover:before {
        opacity: 0.9;
        transition: opacity 0.4s;
    }
    .dashboard-3d-card h2.fw-bold,
    .dashboard-3d-card h6.text-muted,
    .dashboard-3d-card .small.text-muted,
    .dashboard-3d-card .dashboard-3d-icon svg {
        color: var(--primary-color);
        transition: color 0.4s;
    }
    .dashboard-3d-card:hover .dashboard-3d-icon svg,
    .dashboard-3d-card:hover h2.fw-bold,
    .dashboard-3d-card:hover h6.text-muted,
    .dashboard-3d-card:hover .small.text-muted {
        color: #fff !important;
        transition: color 0.4s;
    }
    body.dark-mode .dashboard-3d-card {
        background: #23243a;
        border-color: rgba(255,255,255,0.08);
        transition: background 0.4s, color 0.4s, box-shadow 0.4s, transform 0.4s;
    }
    body.dark-mode .dashboard-3d-card:hover {
        background: #fff !important;
        transition: background 0.4s, color 0.4s, box-shadow 0.4s, transform 0.4s;
    }
    body.dark-mode .dashboard-3d-card:hover .dashboard-3d-icon svg,
    body.dark-mode .dashboard-3d-card:hover h2.fw-bold,
    body.dark-mode .dashboard-3d-card:hover h6.text-muted,
    body.dark-mode .dashboard-3d-card:hover .small.text-muted {
        color: #111 !important;
        transition: color 0.4s;
    }
    .dashboard-3d-icon svg {
        color: var(--primary-color);
        filter: drop-shadow(0 2px 8px rgba(111,217,68,0.15));
        transition: color 0.4s;
        z-index: 1;
        position: relative;
    }
    .dashboard-3d-card h2.fw-bold {
        color: var(--primary-color);
        transition: color 0.4s;
        z-index: 1;
        position: relative;
    }
    .dashboard-3d-card h6.text-muted,
    .dashboard-3d-card .small.text-muted {
        color: var(--primary-color);
        opacity: 0.85;
        transition: color 0.4s;
        z-index: 1;
        position: relative;
    }
    .dashboard-3d-card .card-body {
        z-index: 1;
        position: relative;
    }
    .dashboard-3d-card:hover .fw-semibold.text-dark {
        color: #fff !important;
        transition: color 0.4s;
    }
    body.dark-mode .dashboard-3d-card:hover .fw-semibold.text-dark {
        color: #111 !important;
        transition: color 0.4s;
    }
</style>
<script>
    // Dynamically set --primary-color from theme or custom color
    document.addEventListener('DOMContentLoaded', function() {
        var style = getComputedStyle(document.body);
        var themeColor = style.getPropertyValue('--theme-color');
        var customColor = style.getPropertyValue('--color-customColor');
        if(document.body.classList.contains('custom-color') && customColor) {
            document.documentElement.style.setProperty('--primary-color', customColor.trim());
        } else if(themeColor) {
            document.documentElement.style.setProperty('--primary-color', themeColor.trim());
        }
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
                    {{-- Total Plans Icon --}}
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M8 17l4 4 4-4"></path>
                        <path d="M12 12v9"></path>
                        <path d="M20.39 18.39A9 9 0 1 0 5.61 3.61 9 9 0 0 0 20.39 18.39z"></path>
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
                    {{-- Total Orders Icon --}}
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
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
                    {{-- Companies Icon --}}
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 21V5a2 2 0 0 1 2-2h3v18"></path>
                        <path d="M9 21h6"></path>
                        <path d="M14 21V3h3a2 2 0 0 1 2 2v16"></path>
                        <path d="M9 8h6"></path>
                    </svg>
                </div>
                <div class="dropdown position-absolute end-0 top-0 m-3">
                    <button class="btn btn-sm btn-light border dropdown-toggle" type="button" id="companyFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ ucfirst($user['current_filter'] ?? request('company_filter', 'all')) }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="companyFilterDropdown">
                        <li><a class="dropdown-item" href="?company_filter=day">{{ __('Day') }}</a></li>
                        <li><a class="dropdown-item" href="?company_filter=week">{{ __('Week') }}</a></li>
                        <li><a class="dropdown-item" href="?company_filter=month">{{ __('Month') }}</a></li>
                        <li><a class="dropdown-item" href="?company_filter=all">{{ __('All') }}</a></li>
                    </ul>
                </div>
                <h6 class="text-muted mb-1 mt-2">{{ __('Total Companies') }}</h6>
                <h2 class="fw-bold mb-0">{{ $user['filtered_companies'] ?? $user->total_user }}</h2>
                <div class="small text-muted mt-2">
                    {{ __('Paid Companies:') }} <span class="fw-semibold text-dark">{{ $user['filtered_paid_companies'] ?? ($user->total_paid_companies ?? 0) }}</span>
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
