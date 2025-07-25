@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Excuse') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Excuse') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        @can('create excuse')
            <a href="#" data-url="{{ route('excuse.create') }}" data-ajax-popup="true" data-title="{{ __('Create New Excuse') }}" data-bs-toggle="tooltip" title="{{ __('Create') }}" class="btn btn-sm btn-primary">
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
                                    <th>{{ __('Excuse Date') }}</th>
                                    <th>{{ __('Duration') }}</th>
                                    <th>{{ __('Reason') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Remark') }}</th>
                                    <th width="200px">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendingApprovals as $approval)
                                    <tr>
                                        <td>{{ $approval->excuse->employee->name ?? '-' }}</td>
                                        <td>{{ $approval->excuse->excuse_date }}</td>
                                        <td>{{ $approval->excuse->duration }}</td>
                                        <td>{{ $approval->excuse->reason }}</td>
                                        <td>
                                            <div class="badge bg-warning p-2 px-3 rounded">{{ __('Pending Approval') }}</div>
                                        </td>
                                        <td>{{ $approval->excuse->remark }}</td>
                                        <td class="Action">
                                            <span>
                                                <div class="action-btn me-2">
                                                    <a href="#" data-url="{{ route('excuse.action', $approval->id) }}" data-ajax-popup="true" data-title="{{ __('Excuse Action') }}" class="mx-3 btn btn-sm align-items-center bg-warning" data-bs-toggle="tooltip" title="{{ __('Take Action') }}">
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
      
      {{-- Show regular excuses list --}}

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                  @if (Auth::user()->type == 'company' || Auth::user()->type == 'HR')
                  <h5 class="mb-0">{{ __('Excuses') }}</h5>
                  @else
                  <h5 class="mb-0">{{ __('My Excuses') }}</h5>
                  @endif
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Employee') }}</th>
                                    <th>{{ __('Excuse Date') }}</th>
                                    <th>{{ __('Duration') }}</th>
                                    <th>{{ __('Reason') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Remark') }}</th>
                                    <th>{{ __('Deduction') }}</th>
                                    <th width="200px">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($excuses as $excuse)
                                    <tr>
                                        <td>{{ $excuse->employee->name ?? '-' }}</td>
                                        <td>{{ $excuse->excuse_date }}</td>
                                        <td>{{ $excuse->duration }}</td>
                                        <td>{{ $excuse->reason }}</td>
                                        <td>
                                            @if($excuse->status=="Pending")<div class="badge bg-warning p-2 px-3 rounded">{{ $excuse->status }}</div>
                                            @elseif($excuse->status=="Approved")
                                                <div class="badge bg-success p-2 px-3 rounded">{{ $excuse->status }}</div>
                                            @elseif($excuse->status=="Rejected")
                                                <div class="badge bg-danger p-2 px-3 rounded">{{ $excuse->status }}</div>
                                            @else
                                                <div class="badge bg-secondary p-2 px-3 rounded">{{ $excuse->status }}</div>
                                            @endif
                                        </td>
                                        <td>{{ $excuse->remark }}</td>
                                        <td>{{ $excuse->deduction_amount }}</td>
                                        <td class="Action">
                                            <span>
                                                @can('edit excuse')
                                                    <div class="action-btn me-2">
                                                        <a href="#" data-url="{{ route('excuse.edit', $excuse->id) }}" data-ajax-popup="true" data-title="{{ __('Edit Excuse') }}" class="mx-3 btn btn-sm align-items-center bg-info" data-bs-toggle="tooltip" title="{{ __('Edit') }}"><i class="ti ti-pencil text-white"></i></a>
                                                    </div>
                                                @endcan
                                                @can('delete excuse')
                                                    <div class="action-btn">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['excuse.destroy', $excuse->id], 'id' => 'delete-form-' . $excuse->id]) !!}
                                                        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para bg-danger" data-bs-toggle="tooltip" title="{{ __('Delete') }}" data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="document.getElementById('delete-form-{{ $excuse->id }}').submit();"><i class="ti ti-trash text-white"></i></a>
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