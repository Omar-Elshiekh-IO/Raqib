@extends('layouts.admin')

@section('page-title')
    {{ __('Security - Excuse Out Requests') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Security - Excuse Out Requests') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Excuse Out Requests (Fully Approved)') }}</h5>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable align-middle">
                            <thead>
                                <tr>
                                    <th>{{ __('Employee') }}</th>
                                    <th>{{ __('Excuse Date') }}</th>
                                    <th>{{ __('Duration (min)') }}</th>
                                    <th>{{ __('Reason') }}</th>
                                    <th>{{ __('Actual Leave Time') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($leaves as $leave)
                                    <tr>
                                        <td>{{ $leave->employee->name ?? '-' }}</td>
                                        <td>{{ Auth::user()->dateFormat($leave->excuse_date) }}</td>
                                        <td>{{ $leave->duration }}</td>
                                        <td>{{ $leave->reason }}</td>
                                        <td class="leave-time-{{ $leave->id }}">
                                            @if($leave->actual_leave_time)
                                                {{ Auth::user()->timeFormat($leave->actual_leave_time) }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ url('/security/mark-leave/'.$leave->id) }}" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary" @if($leave->actual_leave_time) disabled @endif>
                                                    {{ $leave->actual_leave_time ? __('Left') : __('Leave') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">{{ __('No fully approved excuses found.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
