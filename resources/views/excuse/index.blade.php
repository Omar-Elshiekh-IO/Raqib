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
        <div class="col-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Employee') }}</th>
                                    <th>{{ __('Excuse Date') }}</th>
                                    <th>{{ __('Start Time') }}</th>
                                    <th>{{ __('End Time') }}</th>
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
                                        <td>{{ $excuse->start_time }}</td>
                                        <td>{{ $excuse->end_time }}</td>
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