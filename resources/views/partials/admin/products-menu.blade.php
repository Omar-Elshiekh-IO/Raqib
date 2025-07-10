@if (Gate::check('manage product & service'))
    <li class="dash-item dash-hasmenu">
        <a href="#!" class="dash-link ">
            <span class="dash-micon"><i class="ti ti-shopping-cart"></i></span><span class="dash-mtext">{{ __('Products System') }}</span><span class="dash-arrow">
                <i data-feather="chevron-right"></i></span>
        </a>
        <ul class="dash-submenu">
            @if (Gate::check('manage product & service'))
                <li class="dash-item {{ Request::segment(1) == 'productservice' ? 'active' : '' }}">
                    <a href="{{ route('productservice.index') }}"
                        class="dash-link">{{ __('Product & Services') }}
                    </a>
                </li>
                <li class="dash-item {{ Request::segment(1) == 'productstock' ? 'active' : '' }}">
                    <a href="{{ route('productstock.index') }}"
                        class="dash-link">{{ __('Product Stock') }}
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif
