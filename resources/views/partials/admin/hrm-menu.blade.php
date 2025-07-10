@if (!empty($userPlan) && $userPlan->hrm == 1)
    @if (Gate::check('manage employee') ||
        Gate::check('manage set salary') || Gate::check('manage pay slip') ||
        Gate::check('manage leave') || Gate::check('manage attendance') ||
        Gate::check('create attendance') || Gate::check('manage indicator') ||
        Gate::check('manage appraisal') || Gate::check('manage goal tracking') ||
        Gate::check('manage training') || Gate::check('manage trainer') ||
        Gate::check('manage job') || Gate::check('create job') ||
        Gate::check('manage job application') || Gate::check('manage custom question') ||
        Gate::check('manage job onBoard') || Gate::check('show interview schedule') ||
        Gate::check('show career') || Gate::check('manage award') ||
        Gate::check('manage transfer') || Gate::check('manage resignation') ||
        Gate::check('manage travel') || Gate::check('manage promotion') ||
        Gate::check('manage complaint') || Gate::check('manage warning') ||
        Gate::check('manage termination') || Gate::check('manage announcement') ||
        Gate::check('manage holiday') || Gate::check('manage event') ||
        Gate::check('manage meeting') || Gate::check('manage assets') ||
        Gate::check('manage document') || Gate::check('manage company policy') ||
        Gate::check('manage branch') || Gate::check('manage department') ||
        Gate::check('manage designation') || Gate::check('manage leave type') ||
        Gate::check('manage document type') || Gate::check('manage payslip type') ||
        Gate::check('manage allowance option') || Gate::check('manage loan option') ||
        Gate::check('manage deduction option') || Gate::check('manage goal type') ||
        Gate::check('manage training type') || Gate::check('manage award type') ||
        Gate::check('manage termination type') || Gate::check('manage job category') ||
        Gate::check('manage job stage') || Gate::check('manage performance type') ||
        Gate::check('manage competencies'))
        
        <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'employee' || 
            Request::segment(1) == 'setsalary' || Request::segment(1) == 'payslip' ||
            Request::segment(1) == 'leave' || Request::segment(1) == 'attendanceemployee' ||
            Request::segment(1) == 'indicator' || Request::segment(1) == 'appraisal' ||
            Request::segment(1) == 'goaltracking' || Request::segment(1) == 'training' ||
            Request::segment(1) == 'trainer' || Request::segment(1) == 'job' ||
            Request::segment(1) == 'job-application' || Request::segment(1) == 'award' ||
            Request::segment(1) == 'transfer' || Request::segment(1) == 'resignation' ||
            Request::segment(1) == 'travel' || Request::segment(1) == 'promotion' ||
            Request::segment(1) == 'complaint' || Request::segment(1) == 'warning' ||
            Request::segment(1) == 'termination' || Request::segment(1) == 'announcement' ||
            Request::segment(1) == 'holiday' || Request::segment(1) == 'event' ||
            Request::segment(1) == 'meeting' || Request::segment(1) == 'account-assets' ||
            Request::segment(1) == 'document-upload' || Request::segment(1) == 'policies' ||
            Request::segment(1) == 'branch' || Request::segment(1) == 'department' ||
            Request::segment(1) == 'designation' ? ' active dash-trigger' : '' }}">
            
            <a href="#!" class="dash-link">
                <span class="dash-micon"><i class="ti ti-user"></i></span>
                <span class="dash-mtext">{{ __('HRM System') }}</span>
                <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
            </a>
            
            <ul class="dash-submenu">
                {{-- Employee Management --}}
                @if (Gate::check('manage employee'))
                    <li class="dash-item {{ Request::segment(1) == 'employee' ? 'active' : '' }}">
                        @if (\Auth::user()->type == 'Employee')
                            @php
                                $employee = App\Models\Employee::where('user_id', \Auth::user()->id)->first();
                            @endphp
                            <a class="dash-link" href="{{ route('employee.show', \Illuminate\Support\Facades\Crypt::encrypt($employee->id)) }}">
                                {{ __('Employee Profile') }}
                            </a>
                        @else
                            <a href="{{ route('employee.index') }}" class="dash-link">
                                {{ __('Employee Management') }}
                            </a>
                        @endif
                    </li>
                @endif

                {{-- Payroll Management --}}
                @if (Gate::check('manage set salary') || Gate::check('manage pay slip'))
                    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'setsalary' || Request::segment(1) == 'payslip' ? 'active dash-trigger' : '' }}">
                        <a class="dash-link" href="#">
                            {{ __('Payroll Management') }}
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="dash-submenu">
                            @can('manage set salary')
                                <li class="dash-item {{ request()->is('setsalary*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('setsalary.index') }}">
                                        {{ __('Set Salary') }}
                                    </a>
                                </li>
                            @endcan
                            @can('manage pay slip')
                                <li class="dash-item {{ request()->is('payslip*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('payslip.index') }}">
                                        {{ __('Payslip') }}
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                {{-- Leave & Attendance --}}
                @if (Gate::check('manage leave') || Gate::check('manage attendance'))
                    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'leave' || Request::segment(1) == 'attendanceemployee' ? 'active dash-trigger' : '' }}">
                        <a class="dash-link" href="#">
                            {{ __('Leave & Attendance') }}
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="dash-submenu">
                            @can('manage leave')
                                <li class="dash-item {{ Request::route()->getName() == 'leave.index' ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('leave.index') }}">
                                        {{ __('Manage Leave') }}
                                    </a>
                                </li>
                            @endcan
                            @can('manage attendance')
                                <li class="dash-item {{ Request::route()->getName() == 'attendanceemployee.index' ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('attendanceemployee.index') }}">
                                        {{ __('Mark Attendance') }}
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                {{-- Performance Management --}}
                @if (Gate::check('manage indicator') || Gate::check('manage appraisal') || Gate::check('manage goal tracking'))
                    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'indicator' || Request::segment(1) == 'appraisal' || Request::segment(1) == 'goaltracking' ? 'active dash-trigger' : '' }}">
                        <a class="dash-link" href="#">
                            {{ __('Performance Management') }}
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="dash-submenu">
                            @can('manage indicator')
                                <li class="dash-item {{ request()->is('indicator*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('indicator.index') }}">
                                        {{ __('Indicator') }}
                                    </a>
                                </li>
                            @endcan
                            @can('manage appraisal')
                                <li class="dash-item {{ request()->is('appraisal*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('appraisal.index') }}">
                                        {{ __('Appraisal') }}
                                    </a>
                                </li>
                            @endcan
                            @can('manage goal tracking')
                                <li class="dash-item {{ request()->is('goaltracking*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('goaltracking.index') }}">
                                        {{ __('Goal Tracking') }}
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                {{-- Training Management --}}
                @if (Gate::check('manage training') || Gate::check('manage trainer'))
                    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'trainer' || Request::segment(1) == 'training' ? 'active dash-trigger' : '' }}">
                        <a class="dash-link" href="#">
                            {{ __('Training Management') }}
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="dash-submenu">
                            @can('manage training')
                                <li class="dash-item {{ request()->is('training*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('training.index') }}">
                                        {{ __('Training List') }}
                                    </a>
                                </li>
                            @endcan
                            @can('manage trainer')
                                <li class="dash-item {{ request()->is('trainer*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('trainer.index') }}">
                                        {{ __('Trainer') }}
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                {{-- HR Administration --}}
                @if (Gate::check('manage award') || Gate::check('manage transfer') || Gate::check('manage resignation') || 
                     Gate::check('manage travel') || Gate::check('manage promotion') || Gate::check('manage complaint') ||
                     Gate::check('manage warning') || Gate::check('manage termination') || Gate::check('manage announcement') ||
                     Gate::check('manage holiday'))
                    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'award' || Request::segment(1) == 'transfer' || 
                        Request::segment(1) == 'resignation' || Request::segment(1) == 'travel' || Request::segment(1) == 'promotion' ||
                        Request::segment(1) == 'complaint' || Request::segment(1) == 'warning' || Request::segment(1) == 'termination' ||
                        Request::segment(1) == 'announcement' || Request::segment(1) == 'holiday' ? 'active dash-trigger' : '' }}">
                        <a class="dash-link" href="#">
                            {{ __('HR Administration') }}
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="dash-submenu">
                            @can('manage award')
                                <li class="dash-item {{ request()->is('award*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('award.index') }}">
                                        {{ __('Award') }}
                                    </a>
                                </li>
                            @endcan
                            @can('manage transfer')
                                <li class="dash-item {{ request()->is('transfer*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('transfer.index') }}">
                                        {{ __('Transfer') }}
                                    </a>
                                </li>
                            @endcan
                            @can('manage resignation')
                                <li class="dash-item {{ request()->is('resignation*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('resignation.index') }}">
                                        {{ __('Resignation') }}
                                    </a>
                                </li>
                            @endcan
                            @can('manage travel')
                                <li class="dash-item {{ request()->is('travel*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('travel.index') }}">
                                        {{ __('Trip') }}
                                    </a>
                                </li>
                            @endcan
                            @can('manage promotion')
                                <li class="dash-item {{ request()->is('promotion*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('promotion.index') }}">
                                        {{ __('Promotion') }}
                                    </a>
                                </li>
                            @endcan
                            @can('manage complaint')
                                <li class="dash-item {{ request()->is('complaint*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('complaint.index') }}">
                                        {{ __('Complaints') }}
                                    </a>
                                </li>
                            @endcan
                            @can('manage warning')
                                <li class="dash-item {{ request()->is('warning*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('warning.index') }}">
                                        {{ __('Warning') }}
                                    </a>
                                </li>
                            @endcan
                            @can('manage termination')
                                <li class="dash-item {{ request()->is('termination*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('termination.index') }}">
                                        {{ __('Termination') }}
                                    </a>
                                </li>
                            @endcan
                            @can('manage announcement')
                                <li class="dash-item {{ request()->is('announcement*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('announcement.index') }}">
                                        {{ __('Announcement') }}
                                    </a>
                                </li>
                            @endcan
                            @can('manage holiday')
                                <li class="dash-item {{ request()->is('holiday*') || request()->is('holiday-calender') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('holiday.index') }}">
                                        {{ __('Holidays') }}
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                {{-- Events & Meetings --}}
                @can('manage event')
                    <li class="dash-item {{ request()->is('event*') ? 'active' : '' }}">
                        <a class="dash-link" href="{{ route('event.index') }}">
                            {{ __('Event Setup') }}
                        </a>
                    </li>
                @endcan
                
                @can('manage meeting')
                    <li class="dash-item {{ request()->is('meeting*') ? 'active' : '' }}">
                        <a class="dash-link" href="{{ route('meeting.index') }}">
                            {{ __('Meeting') }}
                        </a>
                    </li>
                @endcan

                {{-- Assets & Documents --}}
                @can('manage assets')
                    <li class="dash-item {{ request()->is('account-assets*') ? 'active' : '' }}">
                        <a class="dash-link" href="{{ route('account-assets.index') }}">
                            {{ __('Employee Assets') }}
                        </a>
                    </li>
                @endcan

                @can('manage document')
                    <li class="dash-item {{ request()->is('document-upload*') ? 'active' : '' }}">
                        <a class="dash-link" href="{{ route('document-upload.index') }}">
                            {{ __('Document Setup') }}
                        </a>
                    </li>
                @endcan

                @can('manage company policy')
                    <li class="dash-item {{ request()->is('policies*') ? 'active' : '' }}">
                        <a class="dash-link" href="{{ route('company-policy.index') }}">
                            {{ __('Company Policy') }}
                        </a>
                    </li>
                @endcan

                {{-- HRM System Setup --}}
                @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'HR')
                    @if (Gate::check('manage branch') || Gate::check('manage department') || Gate::check('manage designation'))
                        <li class="dash-item {{ Request::segment(1) == 'branch' || Request::segment(1) == 'department' || Request::segment(1) == 'designation' ? 'active' : '' }}">
                            <a class="dash-link" href="{{ route('branch.index') }}">
                                {{ __('HRM System Setup') }}
                            </a>
                        </li>
                    @endif
                @endif
            </ul>
        </li>
    @endif
@endif
