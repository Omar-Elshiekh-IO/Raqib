{{-- Project System Section --}}
@if (!empty($userPlan) && $userPlan->project == 1)
    @if (Gate::check('manage project') || Gate::check('manage project task') ||
        Gate::check('manage timesheet') || Gate::check('manage bug report') ||
        Gate::check('manage project task stage') || Gate::check('manage bug status'))
        <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'project' ||
            Request::segment(1) == 'bugs-report' ||
            Request::segment(1) == 'bugstatus' ||
            Request::segment(1) == 'project-task-stages' ||
            Request::segment(1) == 'calendar' ||
            Request::segment(1) == 'timesheet-list' ||
            Request::segment(1) == 'taskboard' ||
            Request::segment(1) == 'projects' ||
            Request::segment(1) == 'project_report'
                ? 'active dash-trigger'
                : '' }}">
            <a href="#!" class="dash-link"><span class="dash-micon"><i class="ti ti-share"></i></span><span class="dash-mtext">{{ __('Project System') }}</span><span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
            <ul class="dash-submenu">
                @can('manage project')
                    <li class="dash-item  {{ Request::segment(1) == 'project' || Request::route()->getName() == 'projects.list' || Request::route()->getName() == 'projects.index' || Request::route()->getName() == 'projects.show' || request()->is('projects/*') ? 'active' : '' }}">
                        <a class="dash-link" href="{{ route('projects.index') }}">{{ __('Projects') }}</a>
                    </li>
                @endcan
                @can('manage project task')
                    <li class="dash-item {{ request()->is('taskboard*') ? 'active' : '' }}">
                        <a class="dash-link" href="{{ route('taskBoard.view', 'list') }}">{{ __('Tasks') }}</a>
                    </li>
                @endcan
                @can('manage timesheet')
                    <li class="dash-item {{ request()->is('timesheet-list*') ? 'active' : '' }}">
                        <a class="dash-link" href="{{ route('timesheet.list') }}">{{ __('Timesheet') }}</a>
                    </li>
                @endcan
                @can('manage bug report')
                    <li class="dash-item {{ request()->is('bugs-report*') ? 'active' : '' }}">
                        <a class="dash-link" href="{{ route('bugs.view', 'list') }}">{{ __('Bug') }}</a>
                    </li>
                @endcan
                @can('manage project task')
                    <li class="dash-item {{ request()->is('calendar*') ? 'active' : '' }}">
                        <a class="dash-link" href="{{ route('task.calendar', ['all']) }}">{{ __('Task Calendar') }}</a>
                    </li>
                @endcan
                @if (\Auth::user()->type != 'super admin')
                    <li class="dash-item  {{ Request::segment(1) == 'time-tracker' ? 'active open' : '' }}">
                        <a class="dash-link" href="{{ route('time.tracker') }}">{{ __('Tracker') }}</a>
                    </li>
                @endif
                @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'Employee')
                    <li class="dash-item  {{ Request::route()->getName() == 'project_report.index' || Request::route()->getName() == 'project_report.show' ? 'active' : '' }}">
                        <a class="dash-link" href="{{ route('project_report.index') }}">{{ __('Project Report') }}</a>
                    </li>
                @endif
                @if (Gate::check('manage project task stage') || Gate::check('manage bug status'))
                    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'bugstatus' || Request::segment(1) == 'project-task-stages' ? 'active dash-trigger' : '' }}">
                        <a class="dash-link" href="#">{{ __('Project System Setup') }}<span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            @can('manage project task stage')
                            @endcan
                            @can('manage bug status')
                            @endcan
                        </ul>
                    </li>
                @endif
            </ul>
        </li>
    @endif
@endif
{{-- End Project System Section --}}
