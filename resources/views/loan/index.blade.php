@extends('layouts.admin')
@section('page-title')
  {{ __('Manage Loan') }}
@endsection
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
  <li class="breadcrumb-item">{{ __('Loan') }}</li>
@endsection
@section('action-btn')
  <div class="float-end">
    @can('create loan')
    <a href="#" data-url="{{ route('loan.create') }}" data-ajax-popup="true" data-title="{{ __('Create New Loan') }}"
    data-bs-toggle="tooltip" title="{{ __('Create') }}" class="btn btn-sm btn-primary">
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
          <th>{{ __('Title') }}</th>
          <th>{{ __('Loan Option') }}</th>
          <th>{{ __('Amount') }}</th>
          <th>{{ __('Reason') }}</th>
          <th>{{ __('Status') }}</th>
          <th>{{__('Approved On')}}</th>
          <th>{{__('With Deduction')}}</th>
          <th>{{__('Deduction Amount')}}</th>
          <th>{{__('Deduction Start')}}</th>
          <th>{{__('Deduction End')}}</th>
          <th>{{__('Total Deduction Months')}}</th>
          @can('edit loan')
        <th width="200px">{{ __('Action') }}</th>
      @endcan
          </tr>
        </thead>
        <tbody>
          @foreach ($loans as $loan)
        <tr>
        <td>{{ $loan->employee->name ?? '-' }}</td>
        <td>{{ $loan->title }}</td>
        <td>{{ $loan->loanOption->name ?? '-' }}</td>
        <td>{{ $loan->amount }}</td>
        <td>{{ $loan->reason }}</td>
        <td>
          @if($loan->status == "Pending")
        <div class="badge bg-warning p-2 px-3 rounded">{{ $loan->status }}</div>
        @elseif($loan->status == "Approved")
        <div class="badge bg-success p-2 px-3 rounded">{{ $loan->status }}</div>
        @elseif($loan->status == "Rejected")
        <div class="badge bg-danger p-2 px-3 rounded">{{ $loan->status }}</div>
        @else
        <div class="badge bg-secondary p-2 px-3 rounded">{{ $loan->status }}</div>
        @endif
        </td>
        <td>{{ $loan->approved_on ? Auth::user()->dateFormat($loan->approved_on) : '' }}</td>
        <td>
          @if($loan->with_deduction)
        <span class="badge bg-success">{{ __('Yes') }}</span>
        @else
        <span class="badge bg-secondary">{{ __('No') }}</span>
        @endif
        </td>
        <td>{{ $loan->deduction_amount ?? '-' }}</td>
        <td>
          {{ $loan->start_deduction_date ? \Carbon\Carbon::parse($loan->start_deduction_date)->format('Y-m') : '-' }}
        </td>
        <td>
          {{ $loan->end_deduction_date ? \Carbon\Carbon::parse($loan->end_deduction_date)->format('Y-m') : '-' }}
        </td>
        <td>{{ $loan->total_deduction_months ?? '-' }}</td>
        <td class="Action">
          <span>
          @can('edit loan')
        <div class="action-btn me-2">
        <a href="#" data-url="{{ route('loan.edit-pop-up', $loan->id) }}" data-ajax-popup="true"
        data-title="{{ __('Edit Loan') }}" class="mx-3 btn btn-sm align-items-center bg-info"
        data-bs-toggle="tooltip" title="{{ __('Edit') }}"><i class="ti ti-pencil text-white"></i></a>
        </div>
        @endcan
          @can('delete loan')
        <div class="action-btn">
        {!! Form::open(['method' => 'DELETE', 'route' => ['loan.destroy', $loan->id], 'id' => 'delete-form-' . $loan->id]) !!}
        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para bg-danger"
        data-bs-toggle="tooltip" title="{{ __('Delete') }}"
        data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
        data-confirm-yes="document.getElementById('delete-form-{{ $loan->id }}').submit();"><i
        class="ti ti-trash text-white"></i></a>
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