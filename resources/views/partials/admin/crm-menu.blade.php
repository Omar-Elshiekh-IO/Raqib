@if (!empty($userPlan) && $userPlan->crm == 1)
    @if (Gate::check('manage lead') ||
            Gate::check('manage deal') ||
            Gate::check('manage form builder') ||
            Gate::check('manage contract'))
        <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'stages' || Request::segment(1) == 'labels' || Request::segment(1) == 'sources' || Request::segment(1) == 'lead_stages' || Request::segment(1) == 'pipelines' || Request::segment(1) == 'deals' || Request::segment(1) == 'leads' || Request::segment(1) == 'form_builder' || Request::segment(1) == 'contractType' || Request::segment(1) == 'form_response' || Request::segment(1) == 'contract' ? ' active dash-trigger' : '' }}">
            <a href="#!" class="dash-link"><span class="dash-micon"><i class="ti ti-layers-difference"></i></span><span class="dash-mtext">{{ __('CRM System') }}</span><span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
            <ul class="dash-submenu {{ Request::segment(1) == 'stages' || Request::segment(1) == 'labels' || Request::segment(1) == 'sources' || Request::segment(1) == 'lead_stages' || Request::segment(1) == 'leads' || Request::segment(1) == 'form_builder' || Request::segment(1) == 'form_response' || Request::segment(1) == 'deals' || Request::segment(1) == 'pipelines' ? 'show' : '' }}">
                @can('manage lead')
                    <li class="dash-item {{ Request::route()->getName() == 'leads.list' || Request::route()->getName() == 'leads.index' || Request::route()->getName() == 'leads.show' ? ' active' : '' }}">
                        <a class="dash-link" href="{{ route('leads.index') }}">{{ __('Leads') }}</a>
                    </li>
                @endcan
                @can('manage deal')
                    <li class="dash-item {{ Request::route()->getName() == 'deals.list' || Request::route()->getName() == 'deals.index' || Request::route()->getName() == 'deals.show' ? ' active' : '' }}">
                        <a class="dash-link" href="{{ route('deals.index') }}">{{ __('Deals') }}</a>
                    </li>
                @endcan
                @can('manage form builder')
                    <li class="dash-item {{ Request::segment(1) == 'form_builder' || Request::segment(1) == 'form_response' ? 'active open' : '' }}">
                        <a class="dash-link"></a>
                    </li>
                @endcan
                @can('manage contract')
                    <li class="dash-item  {{ Request::route()->getName() == 'contract.index' || Request::route()->getName() == 'contract.show' ? 'active' : '' }}">
                        <a class="dash-link"></a>
                    </li>
                @endcan
                @if (Gate::check('manage lead stage') ||
                        Gate::check('manage pipeline') ||
                        Gate::check('manage source') ||
                        Gate::check('manage label') ||
                        Gate::check('manage contract type') ||
                        Gate::check('manage stage'))
                    <li class="dash-item  {{ Request::segment(1) == 'stages' || Request::segment(1) == 'labels' || Request::segment(1) == 'sources' || Request::segment(1) == 'lead_stages' || Request::segment(1) == 'pipelines' || Request::segment(1) == 'product-category' || Request::segment(1) == 'product-unit' || Request::segment(1) == 'contractType' || Request::segment(1) == 'payment-method' || Request::segment(1) == 'custom-field' || Request::segment(1) == 'chart-of-account-type' ? 'active dash-trigger' : '' }}">
                        <a class="dash-link" href="{{ route('pipelines.index') }}">{{ __('CRM System Setup') }}</a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
@endif
