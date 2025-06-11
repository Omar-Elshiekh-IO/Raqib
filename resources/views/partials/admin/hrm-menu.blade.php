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
        <li>
            <ul class="dash-submenu">
                @if (Gate::check('manage award'))
                    {{-- Add award menu item here if needed --}}
                @endif
                @can('manage event')
                @endcan
                @can('manage meeting')
                @endcan
                @can('manage assets')
                @endcan
                @can('manage document')
                @endcan
                @can('manage company policy')
                @endcan
                @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'HR')
                @endif
            </ul>
        </li>
    @endif
@endif
