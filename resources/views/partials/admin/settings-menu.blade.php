{{-- Settings Section --}}
@if (\Auth::user()->type != 'super admin')
    @if (Gate::check('manage company plan') || Gate::check('manage order') || Gate::check('manage company settings'))
        <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'settings' ||
            Request::segment(1) == 'plans' ||
            Request::segment(1) == 'stripe' ||
            Request::segment(1) == 'order'
                ? ' active dash-trigger'
                : '' }}">
            <a href="#!" class="dash-link">
                <span class="dash-micon"><i class="ti ti-settings"></i></span><span class="dash-mtext">{{ __('Settings') }}</span>
                <span class="dash-arrow">
                    <i data-feather="chevron-right"></i></span>
            </a>
            <ul class="dash-submenu">
                @if (Gate::check('manage company settings'))
                    <li
                        class="dash-item dash-hasmenu {{ Request::segment(1) == 'settings' ? ' active' : '' }}">
                        <a href="{{ route('settings') }}"
                            class="dash-link">{{ __('System Settings') }}</a>
                    </li>
                @endif
                @if (Gate::check('manage company plan'))
                    <li
                        class="dash-item{{ Request::route()->getName() == 'plans.index' || Request::route()->getName() == 'stripe' ? ' active' : '' }}">
                        <a href="{{ route('plans.index') }}"
                            class="dash-link">{{ __('Setup Subscription Plan') }}</a>
                    </li>
                @endif
                <li
                    class="dash-item{{ Request::route()->getName() == 'referral-program.company' ? ' active' : '' }}">
                    <a href="{{ route('referral-program.company') }}"
                        class="dash-link">{{ __('Referral Program') }}</a>
                </li>

                @if (Gate::check('manage order') && Auth::user()->type == 'company')
                    <li class="dash-item {{ Request::segment(1) == 'order' ? 'active' : '' }}">
                        <a href="{{ route('order.index') }}" class="dash-link">{{ __('Order') }}</a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
@endif
{{-- End Settings Section --}}
