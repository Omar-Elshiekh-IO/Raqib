{{-- Accounting System Section --}}
@if (!empty($userPlan) && $userPlan->account == 1)
    @if (Gate::check('manage budget plan') || Gate::check('income vs expense report') ||
            Gate::check('manage goal') || Gate::check('manage constant tax') ||
            Gate::check('manage constant category') || Gate::check('manage constant unit') ||
            Gate::check('manage constant custom field') || Gate::check('manage print settings') ||
            Gate::check('manage customer') || Gate::check('manage vender') ||
            Gate::check('manage proposal') || Gate::check('manage bank account') ||
            Gate::check('manage bank transfer') || Gate::check('manage invoice') ||
            Gate::check('manage revenue') || Gate::check('manage credit note') ||
            Gate::check('manage bill') || Gate::check('manage payment') ||
            Gate::check('manage debit note') || Gate::check('manage chart of account') ||
            Gate::check('manage journal entry') || Gate::check('balance sheet report') ||
            Gate::check('ledger report') || Gate::check('trial balance report') )
        <li class="dash-item dash-hasmenu {{ Request::route()->getName() == 'print-setting' ||
            Request::segment(1) == 'customer' || Request::segment(1) == 'vender' ||
            Request::segment(1) == 'proposal' || Request::segment(1) == 'bank-account' ||
            Request::segment(1) == 'bank-transfer' || Request::segment(1) == 'invoice' ||
            Request::segment(1) == 'revenue' || Request::segment(1) == 'credit-note' ||
            Request::segment(1) == 'taxes' || Request::segment(1) == 'product-category' ||
            Request::segment(1) == 'product-unit' || Request::segment(1) == 'payment-method' ||
            Request::segment(1) == 'custom-field' || Request::segment(1) == 'chart-of-account-type' ||
            (Request::segment(1) == 'transaction' && Request::segment(2) != 'ledger' &&
                Request::segment(2) != 'balance-sheet-report' && Request::segment(2) != 'trial-balance') ||
            Request::segment(1) == 'goal' || Request::segment(1) == 'budget' ||
            Request::segment(1) == 'chart-of-account' || Request::segment(1) == 'journal-entry' ||
            Request::segment(2) == 'ledger' || Request::segment(2) == 'balance-sheet' ||
            Request::segment(2) == 'trial-balance' || Request::segment(2) == 'profit-loss' ||
            Request::segment(1) == 'bill' || Request::segment(1) == 'expense' ||
            Request::segment(1) == 'payment' || Request::segment(1) == 'debit-note' || (Request::route()->getName() == 'report.balance.sheet') || (Request::route()->getName() == 'trial-balance-report') ? ' active dash-trigger'
                : '' }}">
            <a href="#!" class="dash-link"><span class="dash-micon"><i class="ti ti-box"></i></span><span class="dash-mtext">{{ __('Accounting System ') }}
                </span><span class="dash-arrow"><i data-feather="chevron-right"></i></span>
            </a>
            <ul class="dash-submenu">
                @if (Gate::check('manage bank account') || Gate::check('manage bank transfer'))
                    <li></li>
                @endif
                @if (Gate::check('manage customer') ||
                        Gate::check('manage proposal') ||
                        Gate::check('manage invoice') ||
                        Gate::check('manage revenue') ||
                        Gate::check('manage credit note'))
                    <li></li>
                @endif
                @if (Gate::check('manage vender') ||
                        Gate::check('manage bill') ||
                        Gate::check('manage payment') ||
                        Gate::check('manage debit note'))
                    <li></li>
                @endif
                @if (Gate::check('manage chart of account') ||
                        Gate::check('manage journal entry') ||
                        Gate::check('ledger report') ||
                        Gate::check('bill report') ||
                        Gate::check('income vs expense report') ||
                        Gate::check('trial balance report'))
                    <li>
                        <a class="dash-link" href="#">{{ __('Double Entry') }}<span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                        </ul>
                    </li>
                @endif
                @if (\Auth::user()->type == 'company')
                    <li class="dash-item {{ Request::segment(1) == 'budget' ? 'active' : '' }}">
                        <a class="dash-link"></a>
                    </li>
                @endif
                @if (Gate::check('manage goal'))
                    <li class="dash-item {{ Request::segment(1) == 'goal' ? 'active' : '' }}">
                        <a class="dash-link"></a>
                    </li>
                @endif
                @if (Gate::check('manage constant tax') ||
                        Gate::check('manage constant category') ||
                        Gate::check('manage constant unit') ||
                        Gate::check('manage constant custom field'))
                    <li class="dash-item {{ Request::segment(1) == 'taxes' || Request::segment(1) == 'product-category' || Request::segment(1) == 'product-unit' || Request::segment(1) == 'payment-method' || Request::segment(1) == 'custom-field' || Request::segment(1) == 'chart-of-account-type' ? 'active dash-trigger' : '' }}">
                        <a class="dash-link"></a>
                    </li>
                @endif
                @if (Gate::check('manage print settings'))
                    <li class="dash-item {{ Request::route()->getName() == 'print-setting' ? ' active' : '' }}">
                        <a class="dash-link"></a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
@endif
{{-- End Accounting System Section --}}
