@if (\Auth::user()->type != 'super admin' && (Gate::check('manage user') || Gate::check('manage role') || Gate::check('manage client')))
    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'users' ||
        Request::segment(1) == 'roles' ||
        Request::segment(1) == 'clients' ||
        Request::segment(1) == 'userlogs'
            ? ' active dash-trigger'
            : '' }}">
        <a href="#!" class="dash-link "><span class="dash-micon"><i class="ti ti-users"></i></span><span class="dash-mtext">{{ __('User Management') }}</span><span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
        <ul class="dash-submenu">
            @can('manage user')
                <li class="dash-item {{ Request::route()->getName() == 'users.index' || Request::route()->getName() == 'users.create' || Request::route()->getName() == 'users.edit' || Request::route()->getName() == 'user.userlog' ? ' active' : '' }}">
                    <a class="dash-link" href="{{ route('users.index') }}">{{ __('User') }}</a>
                </li>
            @endcan
            @can('manage role')
                <li class="dash-item {{ Request::route()->getName() == 'roles.index' || Request::route()->getName() == 'roles.create' || Request::route()->getName() == 'roles.edit' ? ' active' : '' }} ">
                    <a class="dash-link" href="{{ route('roles.index') }}">{{ __('Role') }}</a>
                </li>
            @endcan
            @can('manage client')
                <li class="dash-item {{ Request::route()->getName() == 'clients.index' || Request::segment(1) == 'clients' || Request::route()->getName() == 'clients.edit' ? ' active' : '' }}">
                    <a class="dash-link" href="{{ route('clients.index') }}">{{ __('Client') }}</a>
                </li>
            @endcan
        </ul>
    </li>
@endif
