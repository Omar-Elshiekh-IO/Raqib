@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{ __('Support') }}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{ __('Support') }}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Support') }}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a href="{{ route('support.grid') }}" class="btn btn-sm btn-primary-subtle me-1" data-bs-toggle="tooltip"
            title="{{ __('Grid View') }}">
            <i class="ti ti-layout-grid text-white"></i>
        </a>
        <a href="#" data-size="lg" data-url="{{ route('support.create') }}" data-ajax-popup="true"
            data-bs-toggle="tooltip" title="{{ __('Create') }}" data-title="{{ __('Create Support') }}"
            class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
@endsection

@section('content')
    <div class="row mb-4 gy-4">
        <div class="col-xxl-3 col-xl-4 col-sm-6 col-12 support-ticket-card">
            <div class="support-card-inner d-flex align-items-start gap-3">
                <svg class="bottom-svg" width="135" height="80" viewBox="0 0 135 80" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M74.7692 35C27.8769 35 5.38462 65 0 80H135.692V0C134.923 11.6667 121.662 35 74.7692 35Z"
                        fill="#FF3A6E"></path>
                </svg>
                <div class="support-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M23.0002 12.9999C23.2502 12.9999 23.5003 12.7498 23.5003 12.4998V9.49976C23.5003 8.64968 22.8504 7.99976 22.0003 7.99976H18V21.9999H21.9998C22.8499 21.9999 23.4998 21.35 23.4998 20.4999V17.4999C23.4996 17.3673 23.4468 17.2403 23.3531 17.1465C23.2593 17.0528 23.1323 17 22.9997 16.9998C22.4746 16.9916 21.9738 16.7773 21.6054 16.4032C21.237 16.029 21.0305 15.5249 21.0305 14.9998C21.0305 14.4747 21.237 13.9707 21.6054 13.5965C21.9738 13.2223 22.4746 13.008 22.9997 12.9999H23.0002Z"
                            fill="white" />
                        <path
                            d="M22.6496 6.50021C22.8997 6.40037 23.0494 6.10037 22.9496 5.85029L21.9493 3.00005C21.6992 2.19989 20.7973 1.80005 20.0494 2.05013L5.84961 6.94997H21.8495C22.0866 6.75262 22.3578 6.60021 22.6496 6.50021Z"
                            fill="white" />
                        <path
                            d="M0.5 9.50024V12.5002C0.5 12.8002 0.70016 13.0004 1.00016 13.0004C1.2654 12.9963 1.52881 13.045 1.77505 13.1437C2.02129 13.2423 2.24545 13.389 2.43447 13.5751C2.6235 13.7612 2.77361 13.9831 2.87607 14.2277C2.97854 14.4724 3.0313 14.7351 3.0313 15.0003C3.0313 15.2656 2.97854 15.5282 2.87607 15.7729C2.77361 16.0176 2.6235 16.2394 2.43447 16.4256C2.24545 16.6117 2.02129 16.7583 1.77505 16.857C1.52881 16.9557 1.2654 17.0044 1.00016 17.0002C0.70016 17.0002 0.5 17.2004 0.5 17.5004V20.5004C0.5 21.3505 1.14992 22.0004 2 22.0004H17V8.00024H2C1.15184 8.00024 0.5 8.65016 0.5 9.50024ZM6.5 12.0001H9.5C9.8 12.0001 10.0002 12.2002 10.0002 12.5002C10.0002 12.8002 9.8 13.0004 9.5 13.0004H6.5C6.2 13.0004 5.99984 12.8002 5.99984 12.5002C5.99984 12.2002 6.2 12.0001 6.5 12.0001ZM6.5 14.4999H12.9997C13.2997 14.4999 13.4998 14.7001 13.4998 15.0001C13.4998 15.3001 13.2997 15.5002 12.9997 15.5002H6.5C6.2 15.5002 5.99984 15.3001 5.99984 15.0001C5.99984 14.7001 6.2 14.4999 6.5 14.4999ZM6.5 16.9998H12.9997C13.2997 16.9998 13.4998 17.1999 13.4998 17.4999C13.4998 17.7999 13.2997 18.0001 12.9997 18.0001H6.5C6.2 18.0001 5.99984 17.7999 5.99984 17.4999C5.99984 17.1999 6.2 17.0002 6.5 17.0002V16.9998Z"
                            fill="white" />
                    </svg>
                </div>
                <div class="support-content flex-1">
                    <span class="text-sm d-block mb-1">{{ __('Total') }}</span>
                    <h2 class="h5 mb-0">{{ __('Ticket') }}</h2>
                </div>
                <h3 class="mb-0 h4">{{ $countTicket }}</h3>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-4 col-sm-6 col-12 support-ticket-card">
            <div class="support-card-inner d-flex align-items-start gap-3">
                <svg class="bottom-svg" width="135" height="80" viewBox="0 0 135 80" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M74.7692 35C27.8769 35 5.38462 65 0 80H135.692V0C134.923 11.6667 121.662 35 74.7692 35Z"
                        fill="#FF3A6E"></path>
                </svg>
                <div class="support-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M23.0002 12.9999C23.2502 12.9999 23.5003 12.7498 23.5003 12.4998V9.49976C23.5003 8.64968 22.8504 7.99976 22.0003 7.99976H18V21.9999H21.9998C22.8499 21.9999 23.4998 21.35 23.4998 20.4999V17.4999C23.4996 17.3673 23.4468 17.2403 23.3531 17.1465C23.2593 17.0528 23.1323 17 22.9997 16.9998C22.4746 16.9916 21.9738 16.7773 21.6054 16.4032C21.237 16.029 21.0305 15.5249 21.0305 14.9998C21.0305 14.4747 21.237 13.9707 21.6054 13.5965C21.9738 13.2223 22.4746 13.008 22.9997 12.9999H23.0002Z"
                            fill="white" />
                        <path
                            d="M22.6496 6.50021C22.8997 6.40037 23.0494 6.10037 22.9496 5.85029L21.9493 3.00005C21.6992 2.19989 20.7973 1.80005 20.0494 2.05013L5.84961 6.94997H21.8495C22.0866 6.75262 22.3578 6.60021 22.6496 6.50021Z"
                            fill="white" />
                        <path
                            d="M0.5 9.50024V12.5002C0.5 12.8002 0.70016 13.0004 1.00016 13.0004C1.2654 12.9963 1.52881 13.045 1.77505 13.1437C2.02129 13.2423 2.24545 13.389 2.43447 13.5751C2.6235 13.7612 2.77361 13.9831 2.87607 14.2277C2.97854 14.4724 3.0313 14.7351 3.0313 15.0003C3.0313 15.2656 2.97854 15.5282 2.87607 15.7729C2.77361 16.0176 2.6235 16.2394 2.43447 16.4256C2.24545 16.6117 2.02129 16.7583 1.77505 16.857C1.52881 16.9557 1.2654 17.0044 1.00016 17.0002C0.70016 17.0002 0.5 17.2004 0.5 17.5004V20.5004C0.5 21.3505 1.14992 22.0004 2 22.0004H17V8.00024H2C1.15184 8.00024 0.5 8.65016 0.5 9.50024ZM6.5 12.0001H9.5C9.8 12.0001 10.0002 12.2002 10.0002 12.5002C10.0002 12.8002 9.8 13.0004 9.5 13.0004H6.5C6.2 13.0004 5.99984 12.8002 5.99984 12.5002C5.99984 12.2002 6.2 12.0001 6.5 12.0001ZM6.5 14.4999H12.9997C13.2997 14.4999 13.4998 14.7001 13.4998 15.0001C13.4998 15.3001 13.2997 15.5002 12.9997 15.5002H6.5C6.2 15.5002 5.99984 15.3001 5.99984 15.0001C5.99984 14.7001 6.2 14.4999 6.5 14.4999ZM6.5 16.9998H12.9997C13.2997 16.9998 13.4998 17.1999 13.4998 17.4999C13.4998 17.7999 13.2997 18.0001 12.9997 18.0001H6.5C6.2 18.0001 5.99984 17.7999 5.99984 17.4999C5.99984 17.1999 6.2 17.0002 6.5 17.0002V16.9998Z"
                            fill="white" />
                    </svg>
                </div>
                <div class="support-content flex-1">
                    <span class="text-sm d-block mb-1">{{ __('Open') }}</span>
                    <h2 class="h5 mb-0">{{ __('Ticket') }}</h2>
                </div>
                <h3 class="mb-0 h4">{{ $countOpenTicket }}</h3>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-4 col-sm-6 col-12 support-ticket-card">
            <div class="support-card-inner d-flex align-items-start gap-3">
                <svg class="bottom-svg" width="135" height="80" viewBox="0 0 135 80" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M74.7692 35C27.8769 35 5.38462 65 0 80H135.692V0C134.923 11.6667 121.662 35 74.7692 35Z"
                        fill="#FF3A6E"></path>
                </svg>
                <div class="support-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M23.0002 12.9999C23.2502 12.9999 23.5003 12.7498 23.5003 12.4998V9.49976C23.5003 8.64968 22.8504 7.99976 22.0003 7.99976H18V21.9999H21.9998C22.8499 21.9999 23.4998 21.35 23.4998 20.4999V17.4999C23.4996 17.3673 23.4468 17.2403 23.3531 17.1465C23.2593 17.0528 23.1323 17 22.9997 16.9998C22.4746 16.9916 21.9738 16.7773 21.6054 16.4032C21.237 16.029 21.0305 15.5249 21.0305 14.9998C21.0305 14.4747 21.237 13.9707 21.6054 13.5965C21.9738 13.2223 22.4746 13.008 22.9997 12.9999H23.0002Z"
                            fill="white" />
                        <path
                            d="M22.6496 6.50021C22.8997 6.40037 23.0494 6.10037 22.9496 5.85029L21.9493 3.00005C21.6992 2.19989 20.7973 1.80005 20.0494 2.05013L5.84961 6.94997H21.8495C22.0866 6.75262 22.3578 6.60021 22.6496 6.50021Z"
                            fill="white" />
                        <path
                            d="M0.5 9.50024V12.5002C0.5 12.8002 0.70016 13.0004 1.00016 13.0004C1.2654 12.9963 1.52881 13.045 1.77505 13.1437C2.02129 13.2423 2.24545 13.389 2.43447 13.5751C2.6235 13.7612 2.77361 13.9831 2.87607 14.2277C2.97854 14.4724 3.0313 14.7351 3.0313 15.0003C3.0313 15.2656 2.97854 15.5282 2.87607 15.7729C2.77361 16.0176 2.6235 16.2394 2.43447 16.4256C2.24545 16.6117 2.02129 16.7583 1.77505 16.857C1.52881 16.9557 1.2654 17.0044 1.00016 17.0002C0.70016 17.0002 0.5 17.2004 0.5 17.5004V20.5004C0.5 21.3505 1.14992 22.0004 2 22.0004H17V8.00024H2C1.15184 8.00024 0.5 8.65016 0.5 9.50024ZM6.5 12.0001H9.5C9.8 12.0001 10.0002 12.2002 10.0002 12.5002C10.0002 12.8002 9.8 13.0004 9.5 13.0004H6.5C6.2 13.0004 5.99984 12.8002 5.99984 12.5002C5.99984 12.2002 6.2 12.0001 6.5 12.0001ZM6.5 14.4999H12.9997C13.2997 14.4999 13.4998 14.7001 13.4998 15.0001C13.4998 15.3001 13.2997 15.5002 12.9997 15.5002H6.5C6.2 15.5002 5.99984 15.3001 5.99984 15.0001C5.99984 14.7001 6.2 14.4999 6.5 14.4999ZM6.5 16.9998H12.9997C13.2997 16.9998 13.4998 17.1999 13.4998 17.4999C13.4998 17.7999 13.2997 18.0001 12.9997 18.0001H6.5C6.2 18.0001 5.99984 17.7999 5.99984 17.4999C5.99984 17.1999 6.2 17.0002 6.5 17.0002V16.9998Z"
                            fill="white" />
                    </svg>
                </div>
                <div class="support-content flex-1">
                    <span class="text-sm d-block mb-1">{{ __('On Hold') }}</span>
                    <h2 class="h5 mb-0">{{ __('Ticket') }}</h2>
                </div>
                <h3 class="mb-0 h4">{{ $countonholdTicket }}</h3>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-4 col-sm-6 col-12 support-ticket-card">
            <div class="support-card-inner d-flex align-items-start gap-3">
                <svg class="bottom-svg" width="135" height="80" viewBox="0 0 135 80" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M74.7692 35C27.8769 35 5.38462 65 0 80H135.692V0C134.923 11.6667 121.662 35 74.7692 35Z"
                        fill="#FF3A6E"></path>
                </svg>
                <div class="support-icon">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.1668 10.8333C19.3752 10.8333 19.5836 10.6249 19.5836 10.4165V7.9165C19.5836 7.2081 19.042 6.6665 18.3336 6.6665H15V18.3333H18.3332C19.0416 18.3333 19.5832 17.7917 19.5832 17.0833V14.5833C19.583 14.4728 19.539 14.367 19.4609 14.2888C19.3827 14.2107 19.2769 14.1667 19.1664 14.1665C18.7288 14.1597 18.3115 13.9811 18.0045 13.6694C17.6975 13.3575 17.5254 12.9375 17.5254 12.4999C17.5254 12.0623 17.6975 11.6423 18.0045 11.3305C18.3115 11.0186 18.7293 10.84 19.1668 10.8333Z" fill="#3EC9D6"/>
                        <path d="M18.8745 5.41684C19.0829 5.33364 19.2077 5.08364 19.1245 4.87524L18.2909 2.50004C18.0825 1.83324 17.3309 1.50004 16.7077 1.70844L4.87451 5.79164H18.2078C18.4053 5.62718 18.6313 5.50017 18.8745 5.41684Z" fill="#3EC9D6"/>
                        <path d="M0.416504 7.91699V10.417C0.416504 10.667 0.583304 10.8338 0.833304 10.8338C1.05434 10.8304 1.27385 10.871 1.47905 10.9532C1.68425 11.0354 1.87105 11.1576 2.02856 11.3127C2.18609 11.4678 2.31118 11.6527 2.39656 11.8565C2.48195 12.0605 2.52592 12.2794 2.52592 12.5004C2.52592 12.7215 2.48195 12.9403 2.39656 13.1442C2.31118 13.3481 2.18609 13.533 2.02856 13.6881C1.87105 13.8432 1.68425 13.9654 1.47905 14.0476C1.27385 14.1299 1.05434 14.1705 0.833304 14.167C0.583304 14.167 0.416504 14.3338 0.416504 14.5838V17.0838C0.416504 17.7922 0.958104 18.3338 1.6665 18.3338H14.1665V6.66699H1.6665C0.959704 6.66699 0.416504 7.20859 0.416504 7.91699ZM5.4165 10.0002H7.9165C8.1665 10.0002 8.33334 10.167 8.33334 10.417C8.33334 10.667 8.1665 10.8338 7.9165 10.8338H5.4165C5.1665 10.8338 4.9997 10.667 4.9997 10.417C4.9997 10.167 5.1665 10.0002 5.4165 10.0002ZM5.4165 12.0834H10.8329C11.0829 12.0834 11.2497 12.2502 11.2497 12.5002C11.2497 12.7502 11.0829 12.917 10.8329 12.917H5.4165C5.1665 12.917 4.9997 12.7502 4.9997 12.5002C4.9997 12.2502 5.1665 12.0834 5.4165 12.0834ZM5.4165 14.1666H10.8329C11.0829 14.1666 11.2497 14.3334 11.2497 14.5834C11.2497 14.8334 11.0829 15.0002 10.8329 15.0002H5.4165C5.1665 15.0002 4.9997 14.8334 4.9997 14.5834C4.9997 14.3334 5.1665 14.1666 5.4165 14.1666Z" fill="#3EC9D6"/>
                        <rect x="4.1665" y="9.16675" width="7.5" height="6.66667" fill="#3EC9D6"/>
                        <g clip-path="url(#clip0_767_1770)">
                        <path class="active-checkmark" d="M8.88419 12.5003L10.7536 10.6308C10.805 10.5794 10.8334 10.5107 10.8335 10.4375C10.8335 10.3642 10.8051 10.2955 10.7536 10.2441L10.5898 10.0803C10.5383 10.0287 10.4696 10.0005 10.3963 10.0005C10.3232 10.0005 10.2545 10.0287 10.203 10.0803L8.33358 11.9497L6.46407 10.0803C6.41264 10.0287 6.34394 10.0005 6.27069 10.0005C6.19752 10.0005 6.12882 10.0287 6.0774 10.0803L5.9135 10.2441C5.80683 10.3508 5.80683 10.5243 5.9135 10.6308L7.78297 12.5003L5.9135 14.3698C5.86203 14.4213 5.8337 14.49 5.8337 14.5632C5.8337 14.6364 5.86203 14.705 5.9135 14.7565L6.07736 14.9203C6.12878 14.9719 6.19752 15.0002 6.27065 15.0002C6.3439 15.0002 6.4126 14.9719 6.46402 14.9203L8.33354 13.0509L10.203 14.9203C10.2545 14.9719 10.3231 15.0002 10.3963 15.0002H10.3964C10.4696 15.0002 10.5383 14.9719 10.5898 14.9203L10.7536 14.7565C10.805 14.7051 10.8334 14.6364 10.8334 14.5632C10.8334 14.49 10.805 14.4213 10.7536 14.3698L8.88419 12.5003Z" fill="white"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_767_1770">
                        <rect width="5" height="5" fill="white" transform="translate(5.8335 10)"/>
                        </clipPath>
                        </defs>
                        </svg>
                </div>
                <div class="support-content flex-1">
                    <span class="text-sm d-block mb-1">{{ __('Close') }}</span>
                    <h2 class="h5 mb-0">{{ __('Ticket') }}</h2>
                </div>
                <h3 class="mb-0 h4">{{ $countCloseTicket }}</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Created By') }}</th>
                                    <th scope="col">{{ __('Ticket') }}</th>
                                    <th scope="col">{{ __('Code') }}</th>
                                    <th scope="col">{{ __('Attachment') }}</th>
                                    <th scope="col">{{ __('Assign User') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                    <th scope="col">{{ __('Created At') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @php
                                    $supportpath = \App\Models\Utility::get_file('uploads/supports');
                                @endphp
                                @foreach ($supports as $support)
                                    <tr>
                                        <td scope="row">
                                            <div class="media align-items-center">
                                                <div>
                                                    <div class="avatar-parent-child">
                                                        <img alt=""
                                                            class="avatar rounded border-2 border border-primary avatar-sm me-1"
                                                            @if (
                                                                !empty($support->createdBy) &&
                                                                    !empty($support->createdBy->avatar) &&
                                                                    file_exists('storage/uploads/avatar/' . $support->createdBy->avatar)) src="{{ asset(Storage::url('uploads/avatar')) . '/' . $support->createdBy->avatar }}" @else  src="{{ asset(Storage::url('uploads/avatar')) . '/avatar.png' }}" @endif>
                                                        @if ($support->replyUnread() > 0)
                                                            <span class="avatar-child avatar-badge bg-success"></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    {{ !empty($support->createdBy) ? $support->createdBy->name : '' }}
                                                </div>
                                            </div>
                                        </td>
                                        <td scope="row">
                                            <div class="media align-items-center">
                                                <div class="media-body">
                                                    <a href="{{ route('support.reply', \Crypt::encrypt($support->id)) }}"
                                                        class="name h6 mb-2 d-block text-sm">{{ $support->subject }}</a>
                                                    @if ($support->priority == 0)
                                                        <span data-toggle="tooltip" data-title="{{ __('Priority') }}"
                                                            class="text-capitalize status_badge badge bg-primary p-2 px-3 rounded">
                                                            {{ __(\App\Models\Support::$priority[$support->priority]) }}</span>
                                                    @elseif($support->priority == 1)
                                                        <span data-toggle="tooltip" data-title="{{ __('Priority') }}"
                                                            class="text-capitalize status_badge badge bg-info p-2 px-3 rounded">
                                                            {{ __(\App\Models\Support::$priority[$support->priority]) }}</span>
                                                    @elseif($support->priority == 2)
                                                        <span data-toggle="tooltip" data-title="{{ __('Priority') }}"
                                                            class="text-capitalize status_badge badge bg-warning p-2 px-3 rounded">
                                                            {{ __(\App\Models\Support::$priority[$support->priority]) }}</span>
                                                    @elseif($support->priority == 3)
                                                        <span data-toggle="tooltip" data-title="{{ __('Priority') }}"
                                                            class="text-capitalize status_badge badge bg-danger p-2 px-3 rounded">
                                                            {{ __(\App\Models\Support::$priority[$support->priority]) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $support->ticket_code }}</td>
                                        <td>
                                            @if (!empty($support->attachment))
                                                <a class="bg-primary ms-2 btn btn-sm align-items-center"
                                                    href="{{ $supportpath . '/' . $support->attachment }}" download=""
                                                    data-bs-toggle="tooltip" title="{{ __('Download') }}"
                                                    target="_blank">
                                                    <i class="ti ti-download text-white"></i>
                                                </a>
                                                <a href="{{ $supportpath . '/' . $support->attachment }}"
                                                    class=" bg-secondary ms-2 mx-3 btn btn-sm align-items-center"
                                                    data-bs-toggle="tooltip" title="{{ __('Preview') }}">
                                                    <span class="btn-inner--icon"><i
                                                            class="ti ti-crosshair text-white"></i></span>
                                                </a>
                                            @else
                                                -
                                            @endif

                                        </td>
                                        <td>{{ !empty($support->assignUser) ? $support->assignUser->name : '-' }}</td>

                                        <td>
                                            @if ($support->status == 'Open')
                                                <span
                                                    class="status_badge text-capitalize badge bg-success p-2 px-3 rounded">{{ __(\App\Models\Support::$status[$support->status]) }}</span>
                                            @elseif($support->status == 'Close')
                                                <span
                                                    class="status_badge text-capitalize badge bg-danger p-2 px-3 rounded">{{ __(\App\Models\Support::$status[$support->status]) }}</span>
                                            @elseif($support->status == 'On Hold')
                                                <span
                                                    class="status_badge text-capitalize badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Support::$status[$support->status]) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ \Auth::user()->dateFormat($support->created_at) }}</td>
                                        <td class="Action">
                                            <span>
                                                <div class="action-btn me-2">
                                                    <a href="{{ route('support.reply', \Crypt::encrypt($support->id)) }}"
                                                        data-title="{{ __('Support Reply') }}"
                                                        class="mx-3 btn btn-sm align-items-center bg-warning"
                                                        data-bs-toggle="tooltip" title="{{ __('Reply') }}"
                                                        data-original-title="{{ __('Reply') }}">
                                                        <i class="ti ti-corner-up-left text-white"></i>
                                                    </a>
                                                </div>
                                                @if (\Auth::user()->type == 'company' || \Auth::user()->id == $support->ticket_created)
                                                    <div class="action-btn me-2">
                                                        <a href="#" data-size="lg"
                                                            data-url="{{ route('support.edit', $support->id) }}"
                                                            data-ajax-popup="true" data-title="{{ __('Edit Support') }}"
                                                            class="mx-3 btn btn-sm align-items-center bg-info"
                                                            data-bs-toggle="tooltip" title="{{ __('Edit') }}"
                                                            data-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                    <div class="action-btn ">
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['support.destroy', $support->id],
                                                            'id' => 'delete-form-' . $support->id,
                                                        ]) !!}
                                                        <a href="#!"
                                                            class="mx-3 btn btn-sm  align-items-center bs-pass-para bg-danger"
                                                            data-bs-toggle="tooltip"
                                                            data-original-title="{{ __('Delete') }}"
                                                            data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                                                            title="{{ __('Delete') }}"
                                                            data-confirm-yes="document.getElementById('delete-form-{{ $support->id }}').submit();">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                        {!! Form::close() !!}
                                                    </div>
                                                @endif
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
