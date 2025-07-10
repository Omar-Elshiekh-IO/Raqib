@if (Gate::check('show hrm dashboard'))
    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'account-dashboard' || Request::is('account-dashboard') ? ' active' : '' }}">
        <a href="{{ route('dashboard') }}" class="dash-link">
            <span class="dash-micon"><i class="ti ti-home"></i></span><span class="dash-mtext">{{ __('Dashboard') }}</span>
        </a>
    </li>
@endif
