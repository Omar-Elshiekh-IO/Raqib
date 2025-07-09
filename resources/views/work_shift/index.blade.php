@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Work Shift') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Work Shift') }}</li>
@endsection

@section('action-btn')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @include('layouts.hrm_setup')
        </div>
        <div class="col-12">
            <div class="my-3 d-flex justify-content-end">
                @can('create work shift')
                    <a href="#" data-url="{{ route('work-shift.create') }}" data-ajax-popup="true"
                        data-title="{{ __('Create New Work Shift') }}" data-bs-toggle="tooltip" title="{{ __('Create') }}"
                        class="btn btn-sm btn-primary">
                        <i class="ti ti-plus"></i>
                    </a>
                @endcan
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body table-border-style">
                            <div class="table-responsive">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Work Shift') }}</th>
                                            <th>{{ __('From') }}</th>
                                            <th>{{ __('To') }}</th>
                                            <th>{{ __('Days') }}</th>
                                            <th width="200px">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="font-style">
                                        @foreach ($shifts as $shift)
                                            <tr>
                                                <td>{{ $shift->title }}</td>
                                                @if ($setting['site_time_format'] === 'H:i')
                                                <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $shift->from)->format('H:i') }}</td>
                                                <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $shift->to)->format('H:i') }}</td>
                                                @else
                                                <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $shift->from)->format('h:i A') }}</td>
                                                <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $shift->to)->format('h:i A') }}</td>
                                                @endif
                                                @php
                                                $days = [];
                                                foreach($shift->workShiftDays as $workshiftday){
                                                  $days[] = App\Models\WorkShiftDays::getDayName($workshiftday->day);
                                                }
                                                @endphp
                                                <td>{{ $shift->days = implode(', ',$days) }}</td>
                                                <td>
                                                    @can('edit work shift')
                                                        <div class="action-btn me-2">
                                                            <a href="#" class="mx-3 btn btn-sm align-items-center bg-info"
                                                                data-url="{{ route('work-shift.edit', $shift->id) }}"
                                                                data-ajax-popup="true"
                                                                data-title="{{ __('Edit Work Shift') }}"
                                                                data-bs-toggle="tooltip" title="{{ __('Edit') }}"
                                                                data-original-title="{{ __('Edit') }}">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    @endcan
                                                    @can('delete work shift')
                                                        <div class="action-btn ">
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'route' => ['work-shift.destroy', $shift->id],
                                                                'id' => 'delete-form-' . $shift->id,
                                                            ]) !!}
                                                            <a href="#"
                                                                class="mx-3 btn btn-sm  align-items-center bs-pass-para bg-danger"
                                                                data-bs-toggle="tooltip" title="{{ __('Delete') }}"><i
                                                                    class="ti ti-trash text-white text-white"></i></a>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    @endcan
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
        </div>
    </div>
@endsection
