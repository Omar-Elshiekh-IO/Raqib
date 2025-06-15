@extends('layouts.admin')
@php
    $dir = asset(Storage::url('uploads/plan'));
@endphp
@section('page-title')
    {{ __('Manage Plan') }}
@endsection
@push('css-page')
<style>
    /* 20.01  */
    .price-card .list-unstyled .theme-avtar{
        width: 20px ;
        margin-right: 5px !important;
    }

        .request-btn .btn{
        padding: 8px 12px !important;
    }

    @media screen and (max-width:991px){
        .plan_card{
            width: 50%;
        }
    }
    @media screen and (max-width:767px){
        .plan_card{
            width: 100%;
        }
        .plan_card .price-card{
            height: auto ;
            margin-bottom: 0;
        }
    }
    @media screen and (max-width:481px){
        .plan_card .card-body .row .col-6{
            width: 100%;
        }
        .plan_card .card-body .row .col-6:not(:first-of-type) .list-unstyled{
            margin:0 0 20px!important;
        }
        .plan_card .card-body .row .col-6:first-of-type .list-unstyled{
            margin:20px 0 7px!important;
        }
        .plan_card .price-card{
            max-height: unset;
        }
    }
/* 20.01  */
</style>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Plan') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        @can('create plan')
                    <a href="#" data-size="lg" data-url="{{ route('plans.create') }}" data-ajax-popup="true"
                        data-bs-toggle="tooltip" title="{{ __('Create') }}" data-title="{{ __('Create New Plan') }}"
                        class="btn btn-sm btn-primary">
                        <i class="ti ti-plus"></i>
                    </a>
        @endcan
    </div>
@endsection

@section('content')
    <div class="row">
        @foreach ($plans as $plan)
            <div class="plan_card">
                <div class="card price-card price-1 wow animate__fadeInUp" data-wow-delay="0.2s"
                    style="
                   visibility: visible;
                   animation-delay: 0.2s;
                   animation-name: fadeInUp;
                   ">
                    <div class="card-body">
                        <span class="price-badge bg-primary">{{ $plan->name }}</span>
                        @if (\Auth::user()->type == 'company' && \Auth::user()->plan == $plan->id)
                            <div class="d-flex flex-row-reverse m-0 p-0 active-tag">
                                <span class=" align-items-right">
                                    <i class="f-10 lh-1 fas fa-circle text-primary"></i>
                                    <span class="ms-2">{{ __('Active') }}</span>
                                </span>
                            </div>
                        @endif
                        @if (\Auth::user()->type == 'super admin' && $plan->price > 0)
                        {{$plan->created_at}} {{-- plan creation time style it --}}
                        {{$plan->updated_at}} {{-- plan last edit time style it --}}
                        <div class="d-flex flex-row-reverse m-0 p-0 active-tag">
                            <div class="form-check form-switch custom-switch-v1 float-end">
                                <input type="checkbox" name="plan_disable"
                                class="form-check-input input-primary is_disable" value="1"
                                data-id='{{ $plan->id }}'
                                data-name="{{ __('plan') }}"
                                {{ $plan->is_disable == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="plan_disable"></label>
                          </div>
                        </div>
                    @endif
                        <h1 class="mb-4 f-w-600 ">
                            {{ isset($admin_payment_setting['currency_symbol']) ? $admin_payment_setting['currency_symbol'] : '$' }}{{ number_format($plan->price) }}
                            <small class="text-sm">/{{ __(\App\Models\Plan::$arrDuration[$plan->duration]) }}</small>
                        </h1>
                        <p class="mb-0">
                            {{ __('Free Trial Days : ') . __($plan->trial_days ? $plan->trial_days : 0) }}<br />
                        </p>

                        <div class="row ">
                            <div class="col-6">
                                <ul class="list-unstyled my-5">
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i
                                                class="text-primary ti ti-circle-plus"></i></span>{{ $plan->max_users == -1 ? __('Unlimited') : $plan->max_users }}
                                        {{ __('Users') }}</li>
                                    <li class="text-wrap"><span class="theme-avtar"><i
                                                class="text-primary ti ti-circle-plus"></i></span>{{ $plan->max_customers == -1 ? __('Unlimited') : $plan->max_customers }}
                                        {{ __('Customers') }}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i
                                                class="text-primary ti ti-circle-plus"></i></span>{{ $plan->max_venders == -1 ? __('Unlimited') : $plan->max_venders }}
                                        {{ __('Vendors') }}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i
                                                class="text-primary ti ti-circle-plus"></i></span>{{ $plan->max_clients == -1 ? __('Unlimited') : $plan->max_clients }}
                                        {{ __('Clients') }}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i
                                                class="text-primary ti ti-circle-plus"></i></span>{{ $plan->storage_limit == -1 ? __('Unlimited') : $plan->storage_limit . ' MB'}}
                                        {{ __('Storage') }}</li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <ul class="list-unstyled my-5">
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i
                                                class="text-primary ti ti-circle-plus"></i></span>{{ $plan->account == 1 ? __('Enable') : __('Disable') }}
                                        {{ __('Account') }}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i
                                                class="text-primary ti ti-circle-plus"></i></span>{{ $plan->crm == 1 ? __('Enable') : __('Disable') }}
                                        {{ __('CRM') }}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i
                                                class="text-primary ti ti-circle-plus"></i></span>{{ $plan->hrm == 1 ? __('Enable') : __('Disable') }}
                                        {{ __('HRM') }}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i
                                                class="text-primary ti ti-circle-plus"></i></span>{{ $plan->project == 1 ? __('Enable') : __('Disable') }}
                                        {{ __('Project') }}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i
                                                class="text-primary ti ti-circle-plus"></i></span>{{ $plan->pos == 1 ? __('Enable') : __('Disable') }}
                                        {{ __('POS') }}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i
                                                class="text-primary ti ti-circle-plus"></i></span>{{ $plan->chatgpt == 1 ? __('Enable') : __('Disable') }}
                                        {{ __('Chat GPT') }}</li>

                                </ul>
                            </div>
                        </div>

                        @if (\Auth::user()->type == 'super admin')
                        <div class="d-flex align-items-center justify-content-center">
                                <a title="{{ __('Edit') }}" href="#" class="btn btn-info btn-sm align-items-center"
                                    data-url="{{ route('plans.edit', $plan->id) }}" data-ajax-popup="true"
                                    data-title="{{ __('Edit Plan') }}" data-size="lg" data-bs-toggle="tooltip"
                                    data-bs-original-title="{{ __('Edit') }}">
                                    <i class="ti ti-pencil text-white"></i>

                                </a>
                            @if($plan->price > 0)
                            {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['plans.destroy', $plan->id],
                                                            'id' => 'delete-form-' . $plan->id,
                                                        ]) !!}
                                                        <a href="#!" class="bs-pass-para btn-icon mx-2 btn btn-danger btn-sm align-items-center" data-bs-toggle="tooltip"
                                                        data-bs-original-title="{{ __('Delete') }}">
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                        {!! Form::close() !!}
                            @endif
                        </div>

                        @endif
                                    @if (\Auth::user()->type != 'super admin')
                                    <div class="request-btn">
                                            @if (
                                                $plan->price > 0 &&
                                                    \Auth::user()->trial_plan == 0 &&
                                                    \Auth::user()->plan != $plan->id && $plan->trial == 1)
                                                <a href="{{ route('plan.trial', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}"
                                                    class="btn btn-lg btn-primary btn-icon m-1">{{ __('Start Free Trial') }}</a>
                                            @endif
                                            @if ($plan->id != \Auth::user()->plan)
                                                @if ($plan->price > 0)
                                                    <a href="{{ route('stripe', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}"
                                                        class="btn btn-lg btn-primary btn-icon m-1">{{ __('Buy Plan') }}</a>
                                                @endif
                                            @endif
                                            @if ($plan->id != 1 && $plan->id != \Auth::user()->plan)
                                                @if (\Auth::user()->requested_plan != $plan->id)
                                                    <a href="{{ route('send.request', [\Illuminate\Support\Facades\Crypt::encrypt($plan->id)]) }}"
                                                        class="btn btn-lg btn-primary btn-icon m-1"
                                                        data-title="{{ __('Send Request') }}" data-bs-toggle="tooltip"
                                                        title="{{ __('Send Request') }}">
                                                        <span class="btn-inner--icon"><i class="ti ti-corner-up-right"></i></span>
                                                    </a>
                                                @else
                                                    <a href="{{ route('request.cancel', \Auth::user()->id) }}"
                                                        class="btn btn-lg btn-danger btn-icon m-1"
                                                        data-title="{{ __('`Cancle Request') }}" data-bs-toggle="tooltip"
                                                        title="{{ __('Cancle Request') }}">
                                                        <span class="btn-inner--icon"><i class="ti ti-x"></i></span>
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                        @endif

                        @if (\Auth::user()->type == 'company' && \Auth::user()->trial_expire_date)
                            @if (\Auth::user()->type == 'company' && \Auth::user()->trial_plan == $plan->id)
                            <p class="display-total-time mb-0">
                                {{ __('Plan Trial Expired : ') }}
                                {{ !empty(\Auth::user()->trial_expire_date) ? \Auth::user()->dateFormat(\Auth::user()->trial_expire_date) : 'lifetime' }}
                            </p>
                            @endif
                        @else
                            @if (\Auth::user()->type == 'company' && \Auth::user()->plan == $plan->id)
                            <p class="display-total-time mb-0">
                                {{ __('Plan Expired : ') }}
                                {{ !empty(\Auth::user()->plan_expire_date) ? \Auth::user()->dateFormat(\Auth::user()->plan_expire_date) : 'lifetime' }}
                            </p>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('script-page')
    <script>
        $(document).on('change', '#trial', function() {
            if ($(this).is(':checked')) {
                $('.plan_div').removeClass('d-none');
                $('#trial_days').attr("required", true);

            } else {
                $('.plan_div').addClass('d-none');
                $('#trial_days').removeAttr("required");
            }
        });
    </script>

    <script>
        $(document).on("click", ".is_disable", function() {

        var id = $(this).attr('data-id');
        var is_disable = ($(this).is(':checked')) ? $(this).val() : 0;

        $.ajax({
            url: '{{ route('plan.disable') }}',
            type: 'POST',
            data: {
                "is_disable": is_disable,
                "id": id,
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                if (data.success) {
                    show_toastr('success', data.success);
                } else {
                    show_toastr('error', data.error);

                }

            }
        });
    });
</script>
@endpush
