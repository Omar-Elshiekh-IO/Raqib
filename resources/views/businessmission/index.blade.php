@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Business Mission') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Business Mission') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        @can('create business mission')
            <a href="#" data-url="{{ route('business-mission.create') }}" data-ajax-popup="true" data-title="{{ __('Create New Business Mission') }}" data-bs-toggle="tooltip" title="{{ __('Create') }}" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
    </div>
@endsection
@section('content')
    <div class="row">
      <div class="col-12">
        @include('layouts.manage_requests')
      </div>
      
      {{-- Show pending approvals for managers --}}
      @if(isset($pendingApprovals) && $pendingApprovals->count() > 0)
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Pending Approvals') }}</h5>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Employee') }}</th>
                                    <th>{{ __('Mission Title') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Remark') }}</th>
                                    <th width="200px">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendingApprovals as $approval)
                                    <tr>
                                        <td>{{ $approval->businessMission->employee->name ?? '-' }}</td>
                                        <td>{{ $approval->businessMission->title }}</td>
                                        <td>{{ $approval->businessMission->start_date }}</td>
                                        <td>{{ $approval->businessMission->end_date }}</td>
                                        <td>{{ $approval->businessMission->description }}</td>
                                        <td>
                                            <div class="badge bg-warning p-2 px-3 rounded">{{ __('Pending Approval') }}</div>
                                        </td>
                                        <td>{{ $approval->businessMission->remark ?? "None" }}</td>
                                        <td class="Action">
                                            <span>
                                                <div class="action-btn me-2">
                                                    <a href="#" data-url="{{ route('business-mission.action', $approval->id) }}" data-ajax-popup="true" data-title="{{ __('Business Mission Action') }}" class="mx-3 btn btn-sm align-items-center bg-warning" data-bs-toggle="tooltip" title="{{ __('Take Action') }}">
                                                        <i class="ti ti-caret-right text-white"></i>
                                                    </a>
                                                </div>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
      @endif
      
      {{-- Show regular business missions list --}}

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('My Business Missions') }}</h5>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Employee') }}</th>
                                    <th>{{ __('Mission Title') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Remark') }}</th>
                                    <th>{{ __('Applied On') }}</th>
                                    <th width="200px">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($businessMissions as $mission)
                                    <tr>
                                        <td>{{ $mission->employee->name ?? '-' }}</td>
                                        <td>{{ $mission->title }}</td>
                                        <td>{{ $mission->start_date }}</td>
                                        <td>{{ $mission->end_date }}</td>
                                        <td>{{ $mission->description }}</td>
                                        <td>{{ $mission->status }}</td>
                                        <td>{{ $mission->remark ?? "None" }}</td>
                                        <td>{{ $mission->created_at }}</td>
                                        <td class="Action">
                                            <span>
                                                @can('edit business mission')
                                                    <div class="action-btn me-2">
                                                        <a href="#" data-url="{{ route('business-mission.edit', $mission->id) }}" data-ajax-popup="true" data-title="{{ __('Edit Business Mission') }}" class="mx-3 btn btn-sm align-items-center bg-info" data-bs-toggle="tooltip" title="{{ __('Edit') }}"><i class="ti ti-pencil text-white"></i></a>
                                                    </div>
                                                @endcan
                                                @can('delete business mission')
                                                    <div class="action-btn">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['business-mission.destroy', $mission->id], 'id' => 'delete-form-' . $mission->id]) !!}
                                                        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para bg-danger" data-bs-toggle="tooltip" title="{{ __('Delete') }}" data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="document.getElementById('delete-form-{{ $mission->id }}').submit();"><i class="ti ti-trash text-white"></i></a>
                                                        {!! Form::close() !!}
                                                    </div>
                                                @endcan
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 