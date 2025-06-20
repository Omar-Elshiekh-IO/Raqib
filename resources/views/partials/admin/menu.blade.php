@php
    use App\Models\Utility;
    $setting = \App\Models\Utility::settings();
    $logo = \App\Models\Utility::get_file('uploads/logo');

    $company_logo = $setting['company_logo_dark'] ?? '';
    $company_logos = $setting['company_logo_light'] ?? '';
    $company_small_logo = $setting['company_small_logo'] ?? '';

    $emailTemplate = \App\Models\EmailTemplate::emailTemplateData();
    $lang = Auth::user()->lang;

    $userPlan = \App\Models\Plan::getPlan(\Auth::user()->show_dashboard());
@endphp

@if (isset($setting['cust_theme_bg']) && $setting['cust_theme_bg'] == 'on')
    <nav class="dash-sidebar light-sidebar transprent-bg sidebar-hoverable">
    @else
        <nav class="dash-sidebar light-sidebar sidebar-hoverable">
@endif
<div class="navbar-wrapper">
    <div class="m-header main-logo">
        <a href="#" class="b-brand">

            @if ($setting['cust_darklayout'] && $setting['cust_darklayout'] == 'on')
                <img src="{{ $logo . '/' . (isset($company_logos) && !empty($company_logos) ? $company_logos : 'logo-dark.png') . '?' . time() }}"
                    alt="{{ config('app.name', 'ERPGo-SaaS') }}" class="logo logo-lg">
            @else
                <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-light.png') . '?' . time() }}"
                    alt="{{ config('app.name', 'ERPGo-SaaS') }}" class="logo logo-lg">
            @endif

        </a>
    </div>
    <div class="navbar-content">
        @if (\Auth::user()->type != 'client')
            <ul class="dash-navbar">
                @include('partials.admin.dashboard-menu')
                @include('partials.admin.hrm-menu')
                @include('partials.admin.accounting-menu')
                @include('partials.admin.crm-menu')
                @include('partials.admin.project-menu')
                @include('partials.admin.user-management-menu')
                @include('partials.admin.products-menu')
                @include('partials.admin.pos-menu')
                @include('partials.admin.settings-menu')
            </ul>
        @endif
        @if (\Auth::user()->type == 'client')
            <ul class="dash-navbar">
                @if (Gate::check('manage client dashboard'))
                    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'dashboard' ? ' active' : '' }}">
                        <a href="{{ route('client.dashboard.view') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-home"></i></span><span
                                class="dash-mtext">{{ __('Dashboard') }}</span>
                        </a>
                    </li>
                @endif
                @if (Gate::check('manage deal'))
                    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'deals' ? ' active' : '' }}">
                        <a href="{{ route('deals.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-rocket"></i></span><span
                                class="dash-mtext">{{ __('Deals') }}</span>
                        </a>
                    </li>
                @endif
                @if (Gate::check('manage contract'))
                    <li
                        class="dash-item dash-hasmenu {{ Request::route()->getName() == 'contract.index' || Request::route()->getName() == 'contract.show' ? 'active' : '' }}">
                        <a href="{{ route('contract.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-rocket"></i></span><span
                                class="dash-mtext">{{ __('Contract') }}</span>
                        </a>
                    </li>
                @endif
                @if (Gate::check('manage project'))
                    <li class="dash-item dash-hasmenu  {{ Request::segment(1) == 'projects' ? ' active' : '' }}">
                        <a href="{{ route('projects.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-share"></i></span><span
                                class="dash-mtext">{{ __('Project') }}</span>
                        </a>
                    </li>
                @endif
                @if (Gate::check('manage project'))
                    <li
                        class="dash-item  {{ Request::route()->getName() == 'project_report.index' || Request::route()->getName() == 'project_report.show' ? 'active' : '' }}">
                        <a class="dash-link" href="{{ route('project_report.index') }}">
                            <span class="dash-micon"><i class="ti ti-chart-line"></i></span><span
                                class="dash-mtext">{{ __('Project Report') }}</span>
                        </a>
                    </li>
                @endif

                @if (Gate::check('manage project task'))
                    <li class="dash-item dash-hasmenu  {{ Request::segment(1) == 'taskboard' ? ' active' : '' }}">
                        <a href="{{ route('taskBoard.view', 'list') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-list-check"></i></span><span
                                class="dash-mtext">{{ __('Tasks') }}</span>
                        </a>
                    </li>
                @endif

                @if (Gate::check('manage bug report'))
                    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'bugs-report' ? ' active' : '' }}">
                        <a href="{{ route('bugs.view', 'list') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-bug"></i></span><span
                                class="dash-mtext">{{ __('Bugs') }}</span>
                        </a>
                    </li>
                @endif

                @if (Gate::check('manage timesheet'))
                    <li
                        class="dash-item dash-hasmenu {{ Request::segment(1) == 'timesheet-list' ? ' active' : '' }}">
                        <a href="{{ route('timesheet.list') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-clock"></i></span><span
                                class="dash-mtext">{{ __('Timesheet') }}</span>
                        </a>
                    </li>
                @endif

                @if (Gate::check('manage project task'))
                    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'calendar' ? ' active' : '' }}">
                        <a href="{{ route('task.calendar', ['all']) }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-calendar"></i></span><span
                                class="dash-mtext">{{ __('Task Calender') }}</span>
                        </a>
                    </li>
                @endif

                <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'support' ? 'active' : '' }}">
                    <a href="{{ route('support.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-headphones"></i></span><span
                            class="dash-mtext">{{ __('Support System') }}</span>
                    </a>
                </li>
            </ul>
        @endif
        @if (\Auth::user()->type == 'super admin')
            <ul class="dash-navbar">
                @if (Gate::check('manage super admin dashboard'))
                    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'dashboard' ? ' active' : '' }}">
                        <a href="{{ route('client.dashboard.view') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-home"></i></span><span
                                class="dash-mtext">{{ __('Dashboard') }}</span>
                        </a>
                    </li>
                @endif


                @can('manage user')
                    <li
                        class="dash-item dash-hasmenu {{ Request::route()->getName() == 'users.index' || Request::route()->getName() == 'users.create' || Request::route()->getName() == 'users.edit' ? ' active' : '' }}">
                        <a href="{{ route('users.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-users"></i></span><span
                                class="dash-mtext">{{ __('Companies') }}</span>
                        </a>
                    </li>
                @endcan

                @if (Gate::check('manage plan'))
                    <li class="dash-item dash-hasmenu  {{ Request::segment(1) == 'plans' ? 'active' : '' }}">
                        <a href="{{ route('plans.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-trophy"></i></span><span
                                class="dash-mtext">{{ __('Plan') }}</span>
                        </a>
                    </li>
                @endif
                @if (\Auth::user()->type == 'super admin')
                    <li class="dash-item dash-hasmenu {{ request()->is('plan_request*') ? 'active' : '' }}">
                        <a href="{{ route('plan_request.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-arrow-up-right-circle"></i></span><span
                                class="dash-mtext">{{ __('Plan Request') }}</span>
                        </a>
                    </li>
                @endif

                <li class="dash-item dash-hasmenu  {{ Request::segment(1) == '' ? 'active' : '' }}">
                    <a href="{{ route('referral-program.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-discount-2"></i></span><span
                            class="dash-mtext">{{ __('Referral Program') }}</span>
                    </a>
                </li>


                @if (Gate::check('manage coupon'))
                    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'coupons' ? 'active' : '' }}">
                        <a href="{{ route('coupons.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-gift"></i></span><span
                                class="dash-mtext">{{ __('Coupon') }}</span>
                        </a>
                    </li>
                @endif
                @if (Gate::check('manage order'))
                    <li class="dash-item dash-hasmenu  {{ Request::segment(1) == 'orders' ? 'active' : '' }}">
                        <a href="{{ route('order.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-shopping-cart-plus"></i></span><span
                                class="dash-mtext">{{ __('Order') }}</span>
                        </a>
                    </li>
                @endif
                <li
                    class="dash-item dash-hasmenu {{ Request::segment(1) == 'email_template' || Request::route()->getName() == 'manage.email.language' ? ' active dash-trigger' : 'collapsed' }}">
                    <a href="{{ route('email_template.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-template"></i></span>
                        <span class="dash-mtext">{{ __('Email Template') }}</span>
                    </a>
                </li>

                @if (\Auth::user()->type == 'super admin')
                    @include('landingpage::menu.landingpage')
                @endif

                @if (Gate::check('manage system settings'))
                    <li
                        class="dash-item dash-hasmenu {{ Request::route()->getName() == 'systems.index' ? ' active' : '' }}">
                        <a href="{{ route('systems.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-settings"></i></span><span
                                class="dash-mtext">{{ __('Settings') }}</span>
                        </a>
                    </li>
                @endif

            </ul>
        @endif


    </div>
</div>
</nav>
<style>
    .dash-sidebar.sidebar-hoverable {
        width: 220px;
        min-width: 220px;
        max-width: 220px;
        transition: width 0.45s cubic-bezier(0.22, 1, 0.36, 1), min-width 0.45s cubic-bezier(0.22, 1, 0.36, 1), max-width 0.45s cubic-bezier(0.22, 1, 0.36, 1), background 0.45s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.45s cubic-bezier(0.22, 1, 0.36, 1);
        /* Smooth transition for child elements */
    }
    .dash-sidebar.sidebar-hoverable .navbar-wrapper,
    .dash-sidebar.sidebar-hoverable .navbar-content,
    .dash-sidebar.sidebar-hoverable .main-logo,
    .dash-sidebar.sidebar-hoverable .dash-navbar .dash-item .dash-link,
    .dash-sidebar.sidebar-hoverable .dash-navbar .dash-item .dash-mtext {
        transition: all 0.45s cubic-bezier(0.22, 1, 0.36, 1), background 0.45s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.45s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .dash-sidebar.sidebar-hoverable .navbar-wrapper {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .dash-sidebar.sidebar-hoverable .navbar-content {
        flex: 1 1 auto;
        min-height: 0;
    }
    .dash-sidebar.sidebar-hoverable:hover .navbar-content {
        overflow-y: auto;
    }
    .dash-sidebar.sidebar-hoverable:not(:hover) .navbar-content {
        overflow-y: hidden !important;
    }
    .dash-sidebar.sidebar-hoverable:hover {
        width: 220px !important;
        min-width: 220px !important;
        max-width: 220px !important;
    }
    .dash-sidebar.sidebar-hoverable:not(:hover) {
        width: 60px !important;
        min-width: 60px !important;
        max-width: 60px !important;
    }
    .dash-sidebar.sidebar-hoverable:not(:hover) .dash-mtext {
        opacity: 0;
        max-width: 0;
        padding: 0;
        margin: 0;
        transition: opacity 0.3s cubic-bezier(0.22, 1, 0.36, 1), max-width 0.3s cubic-bezier(0.22, 1, 0.36, 1), padding 0.3s cubic-bezier(0.22, 1, 0.36, 1), margin 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        pointer-events: none;
    }
    .dash-sidebar.sidebar-hoverable:hover .dash-mtext {
        opacity: 1;
        max-width: 200px;
        transition: opacity 0.3s 0.1s cubic-bezier(0.22, 1, 0.36, 1), max-width 0.3s 0.1s cubic-bezier(0.22, 1, 0.36, 1), padding 0.3s 0.1s cubic-bezier(0.22, 1, 0.36, 1), margin 0.3s 0.1s cubic-bezier(0.22, 1, 0.36, 1);
        pointer-events: auto;
    }
    .dash-sidebar.sidebar-hoverable .main-logo {
        justify-content: center;
    }
    /* Fix menu item background and alignment in collapsed mode */
    .dash-sidebar.sidebar-hoverable:not(:hover) .dash-navbar .dash-item {
        text-align: center;
        padding: 0 !important;
        margin: 0 !important;
    }
    .dash-sidebar.sidebar-hoverable:not(:hover) .dash-navbar .dash-item .dash-link {
        justify-content: center;
        align-items: center;
        padding: 0 !important;
        margin: 0 !important;
        min-width: 60px;
        min-height: 48px;
        height: 48px;
        width: 100%;
        border-radius: 8px;
    }
    .dash-sidebar.sidebar-hoverable:not(:hover) .dash-navbar .dash-item.active,
    .dash-sidebar.sidebar-hoverable:not(:hover) .dash-navbar .dash-item:hover {
        background: none !important;
        box-shadow: none !important;
    }
    .dash-sidebar.sidebar-hoverable:not(:hover) .dash-navbar .dash-item .dash-link .dash-micon {
        margin: 0 !important;
        font-size: 1.5rem;
    }
    /* Optional: subtle highlight for active icon in collapsed mode */
    .dash-sidebar.sidebar-hoverable:not(:hover) .dash-navbar .dash-item.active .dash-link {
        background: linear-gradient(90deg, #e6f0ff 60%, #f8fbff 100%) !important;
        border-radius: 10px;
        box-shadow: 0 1px 4px 0 rgba(81, 69, 157, 0.06);
        border: 1px solid #d0e3ff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 4px 0;
        padding: 0 8px;
        min-block-size: 48px;
        block-size: 48px;
    }
    /* Enhanced highlight for active menu item in expanded mode */
    .dash-sidebar.sidebar-hoverable:hover .dash-navbar .dash-item.active .dash-link {
        background: linear-gradient(90deg, #e6f0ff 60%, #f8fbff 100%);
        border-radius: 10px;
        box-shadow: 0 2px 8px 0 rgba(81, 69, 157, 0.08);
        border: 1px solid #d0e3ff;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin: 4px 0;
        padding: 0 16px;
        min-block-size: 48px;
        block-size: 48px;
    }
    /* Ensure icon and text are centered in collapsed mode */
    .dash-sidebar.sidebar-hoverable:not(:hover) .dash-navbar .dash-item .dash-link {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    /* Glassmorphism sidebar background */
    .dash-sidebar.sidebar-hoverable {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(12px) saturate(1.2);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.10), 0 1.5px 0 0 rgba(111, 217, 67, 0.10);
        border-inline-end: 1.5px solid rgba(200, 220, 255, 0.25);
    }
    /* Vibrant accent bar for active menu item */
    .dash-sidebar.sidebar-hoverable .dash-navbar .dash-item.active .dash-link::before {
        content: '';
        display: block;
        position: absolute;
        inset-inline-start: 0;
        inset-block-start: 10%;
        inset-block-end: 10%;
        inline-size: 5px;
        border-radius: 6px;
        background: linear-gradient(180deg, #6fd943 0%, #3c9ee5 100%);
        box-shadow: 0 2px 8px 0 rgba(63, 201, 255, 0.15);
        transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        z-index: 2;
    }
    .dash-sidebar.sidebar-hoverable .dash-navbar .dash-item .dash-link {
        position: relative;
        overflow: hidden;
        transition: background 0.3s, color 0.3s, box-shadow 0.3s;
    }
    /* Active menu item style */
    .dash-sidebar.sidebar-hoverable .dash-navbar .dash-item.active .dash-link {
        background: rgba(111, 217, 67, 0.10);
        color: #3c9ee5;
        font-weight: 600;
        box-shadow: 0 4px 16px 0 rgba(63, 201, 255, 0.08);
        border-radius: 12px;
    }
    /* Hover effect for menu items */
    .dash-sidebar.sidebar-hoverable .dash-navbar .dash-item .dash-link:hover {
        background: rgba(60, 158, 229, 0.08);
        color: #6fd943;
        box-shadow: 0 2px 8px 0 rgba(111, 217, 67, 0.10);
        border-radius: 12px;
    }
    /* Icon pop effect on hover */
    .dash-sidebar.sidebar-hoverable .dash-navbar .dash-item .dash-link:hover .dash-micon {
        transform: scale(1.15) rotate(-8deg);
        transition: transform 0.25s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .dash-sidebar.sidebar-hoverable .dash-navbar .dash-item .dash-link .dash-micon {
        transition: transform 0.25s cubic-bezier(0.22, 1, 0.36, 1);
    }
    /* Add a subtle shadow to the sidebar */
    .dash-sidebar.sidebar-hoverable {
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.10), 0 1.5px 0 0 rgba(111, 217, 67, 0.10);
    }
    .dash-sidebar.sidebar-hoverable {
        /* Remove the old border and use a pseudo-element for the separator */
        border-inline-end: none;
        position: relative;
    }
    .dash-sidebar.sidebar-hoverable::after {
        content: '';
        position: absolute;
        inset-block-start: 0;
        inset-inline-end: -8px;
        inline-size: 2px;
        block-size: 100%;
        background: rgba(200, 220, 255, 0.25);
        z-index: 10;
        pointer-events: none;
    }
</style>
