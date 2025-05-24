@extends('layouts.admin')

@push('script-page')
    <script type="text/javascript">

        $(document).on("click", ".email-template-checkbox", function () {
            var chbox = $(this);
            $.ajax({
                url: chbox.attr('data-url'),
                data: {_token: $('meta[name="csrf-token"]').attr('content'), status: chbox.val()},
                type: 'PUT',
                success: function (response) {
                    if (response.is_success) {
                        show_toastr('success', response.success, 'success');
                        if (chbox.val() == 1) {
                            $('#' + chbox.attr('id')).val(0);
                        } else {
                            $('#' + chbox.attr('id')).val(1);
                        }
                    } else {
                        show_toastr('error', response.error, 'error');
                    }
                },
                error: function (response) {
                    response = response.responseJSON;
                    if (response.is_success) {
                        show_toastr('error', response.error, 'error');
                    } else {
                        show_toastr('error', response, 'error');
                    }
                }
            })
        });

    </script>
@endpush
@section('page-title')
    @if(\Auth::user()->type=='company')
        {{__('Email Notification')}}
    @else
        {{__('Email Templates')}}
    @endif
@endsection
@section('title')
    <div class="d-inline-block">
        @if(\Auth::user()->type=='company')
            <h5 class="h4 d-inline-block font-weight-400 mb-0">{{__('Email Notification')}}</h5>
        @else
            <h5 class="h4 d-inline-block font-weight-400 mb-0">{{__('Email Templates')}}</h5>
        @endif
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    @if(\Auth::user()->type=='company')
        <li class="breadcrumb-item active" aria-current="page">{{__('Email Notification')}}</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">{{__('Email Template')}}</li>
    @endif
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <h5></h5>
                <div class="table-responsive">
                    <table class="table datatable" id="pc-dt-simple">
                        <thead>
                        <tr>
                            <th scope="col" class="sort" data-sort="name"> {{__('Name')}}</th>
                            @if(\Auth::user()->type=='company')
                                <th class="">{{__('On / Off')}}</th>
                            @else
                                <th class="">{{__('Action')}}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($EmailTemplates as $EmailTemplate)
                            <tr>
                                <td>{{ $EmailTemplate->name }}</td>
                                <td>
                                    @if(\Auth::user()->type=='super admin')
                                        <div class="">
                                            <div class="action-btn ms-2">
                                                <a href="{{ route('manage.email.language',[$EmailTemplate->id,\Auth::user()->lang]) }}" class="mx-3 btn btn-sm align-items-center  bg-warning" data-bs-toggle="tooltip" data-bs-original-title="{{__('View')}}">
                                                    <i class="ti ti-eye text-white"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    @if(\Auth::user()->type=='company')
                                        <div class="">

                                            <div class="form-check form-switch d-inline-block">
                                                <label class="form-check-label form-switch">
                                                    <input type="checkbox" class="form-check-input email-template-checkbox" id="email_tempalte_{{!empty($EmailTemplate->template)?$EmailTemplate->template->id:''}}"
                                                           @if(!empty($EmailTemplate->template)?$EmailTemplate->template->is_active:'0' == 1) checked="checked" @endif type="checkbox" value="{{!empty($EmailTemplate->template)?$EmailTemplate->template->is_active:''}} "
                                                           data-url="{{route('status.email.language',[!empty($EmailTemplate->template)?$EmailTemplate->template->id:''])}}"/>
                                                    <span class="slider1 round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    @endif
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
