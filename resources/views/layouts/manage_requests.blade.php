<ul class="card flex-row nav nav-pills nav-fill information-tab hrm_setup_tab" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="{{ route('leave.index') }}" class="list-group-item list-group-item-action border-0">
                <button class="nav-link {{ request()->is('leave*') ? 'active' : '' }} "
                    id="leave-setting-tab" data-bs-toggle="pill" data-bs-target="#leave-setting"
                    type="button">{{ __('Leave') }}</button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('loan.index') }}" class="list-group-item list-group-item-action border-0">
                <button class="nav-link {{ request()->is('loan*') ? 'active' : '' }} " id="loan-setting-tab"
                    data-bs-toggle="pill" data-bs-target="#loan-setting"
                    type="button">{{ __('Loan') }}</button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('business-mission.index') }}" class="list-group-item list-group-item-action border-0">
                <button class="nav-link {{ request()->is('business-mission*') ? 'active' : '' }} "
                    id="business-mission-tab" data-bs-toggle="pill" data-bs-target="#business-mission"
                    type="button">{{ __('Business Mission') }}</button>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('excuse.index') }}" class="list-group-item list-group-item-action border-0">
                <button class="nav-link {{ request()->is('excuse*') ? 'active' : '' }} "
                    id="excuse-tab" data-bs-toggle="pill" data-bs-target="#excuse"
                    type="button">{{ __('Excuse') }}</button>
            </a>
        </li>
</ul>
