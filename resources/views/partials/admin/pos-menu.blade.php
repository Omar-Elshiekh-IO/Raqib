@if (!empty($userPlan) && $userPlan->pos == 1)
    @if (Gate::check('manage warehouse') ||
            Gate::check('manage purchase') ||
            Gate::check('manage quotation') ||
            Gate::check('create barcode') ||
            Gate::check('manage pos') ||
            Gate::check('manage print settings'))
        <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'warehouse' || Request::segment(1) == 'purchase' || Request::segment(1) == 'quotation' || Request::route()->getName() == 'pos.barcode' || Request::route()->getName() == 'pos.print' || Request::route()->getName() == 'pos.show' ? ' active dash-trigger' : '' }}">
            <a href="#!" class="dash-link"><span class="dash-micon"><i class="ti ti-layers-difference"></i></span><span class="dash-mtext">{{ __('POS System') }}</span><span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
            <ul class="dash-submenu {{ Request::segment(1) == 'warehouse' ||
                Request::segment(1) == 'purchase' ||
                Request::route()->getName() == 'pos.barcode' ||
                Request::route()->getName() == 'pos.print' ||
                Request::route()->getName() == 'pos.show'
                    ? 'show'
                    : '' }}">
                @can('manage warehouse')
                    <li class="dash-item {{ Request::route()->getName() == 'warehouse.index' || Request::route()->getName() == 'warehouse.show' ? ' active' : '' }}">
                        <a class="dash-link" href="{{ route('warehouse.index') }}">{{ __('Warehouse') }}</a>
                    </li>
                @endcan
                @can('manage purchase')
                    <li class="dash-item {{ Request::route()->getName() == 'purchase.index' || Request::route()->getName() == 'purchase.create' || Request::route()->getName() == 'purchase.edit' || Request::route()->getName() == 'purchase.show' ? ' active' : '' }}">
                        <a class="dash-link" href="{{ route('purchase.index') }}">{{ __('Purchase') }}</a>
                    </li>
                @endcan
                @can('manage quotation')
                    <li class="dash-item {{ Request::route()->getName() == 'quotation.index' || Request::route()->getName() == 'quotations.create' || Request::route()->getName() == 'quotation.edit' || Request::route()->getName() == 'quotation.show' ? ' active' : '' }}">
                        <a class="dash-link" href="{{ route('quotation.index') }}">{{ __('Quotation') }}</a>
                    </li>
                @endcan
                @can('manage pos')
                    <li class="dash-item {{ Request::route()->getName() == 'pos.index' ? ' active' : '' }}">
                        <a class="dash-link" href="{{ route('pos.index') }}">{{ __(' Add POS') }}</a>
                    </li>
                    <li class="dash-item {{ Request::route()->getName() == 'pos.report' || Request::route()->getName() == 'pos.show' ? ' active' : '' }}">
                        <a class="dash-link" href="{{ route('pos.report') }}">{{ __('POS') }}</a>
                    </li>
                @endcan
                @can('manage warehouse')
                    <li class="dash-item {{ Request::route()->getName() == 'warehouse-transfer.index' || Request::route()->getName() == 'warehouse-transfer.show' ? ' active' : '' }}">
                        <a class="dash-link" href="{{ route('warehouse-transfer.index') }}">{{ __('Transfer') }}</a>
                    </li>
                @endcan
                @can('create barcode')
                    <li class="dash-item {{ Request::route()->getName() == 'pos.barcode' || Request::route()->getName() == 'pos.print' ? ' active' : '' }}">
                        <a class="dash-link" href="{{ route('pos.barcode') }}">{{ __('Print Barcode') }}</a>
                    </li>
                @endcan
                @can('manage pos')
                    <li class="dash-item {{ Request::route()->getName() == 'pos-print-setting' ? ' active' : '' }}">
                        <a class="dash-link" href="{{ route('pos.print.setting') }}">{{ __('Print Settings') }}</a>
                    </li>
                @endcan
            </ul>
        </li>
    @endif
@endif
