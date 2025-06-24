@extends('layouts.admin')
@section('page-title')
    {{ __('Landing Page') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Landing Page')}}</li>
@endsection

@php

    $settings = \Modules\LandingPage\Entities\LandingPageSetting::landingPageSetting();
    $logo=\App\Models\Utility::get_file('uploads/landing_page_image');


@endphp



@push('script-page')
<script src="{{ asset('assets/js/jquery.repeater.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#imageUploadForm').repeater({
                show: function() {
                    $(this).slideDown();
                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
            });
        });

        function updateImagePreview(inputElement) {
            var imageElement = inputElement.parentElement.parentElement.querySelector('img');
            if (inputElement.files.length > 0) {
                imageElement.src = window.URL.createObjectURL(inputElement.files[0]);
            } else {
                imageElement.src = '{{ $logo . '/placeholder.png' }}'; // Provide the path to your placeholder image.
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(event) {
                if (event.target && event.target.classList.contains('delete-repeater-item')) {
                    event.preventDefault(); // Cancel the default action
                    var repeaterItem = event.target.closest('[data-repeater-item]');
                    if (repeaterItem) {
                        repeaterItem.remove();
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-button');
            const imageContainer = document.getElementById('imageContainer');
            const imageNamesInput = document.getElementById('imageNames');
            let deletedImageNames = [];

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const imageToDelete = button.getAttribute('data-image');
                    button.closest('.card').remove();
                    const currentImageNames = imageNamesInput.value.split(',');
                    const updatedImageNames = currentImageNames.filter(name => name !==
                        imageToDelete);
                    imageNamesInput.value = updatedImageNames.join(',');
                    deletedImageNames.push(imageToDelete);
                });
            });
        });
    </script>
    <script>
        document.getElementById('home_banner').onchange = function () {
                var src = URL.createObjectURL(this.files[0])
                document.getElementById('image').src = src
            }
            document.getElementById('home_logo').onchange = function () {
                var src = URL.createObjectURL(this.files[0])
                document.getElementById('image1').src = src
            }
    </script>
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Landing Page')}}</li>
@endsection


@section('content')
    <div class="row justify-content-center align-items-center min-vh-100" style="background: linear-gradient(135deg, #08253F 60%, #2B8B68 100%);">
        <div class="col-md-8 col-lg-6 text-center py-5">
            <img src="/assets/images/raqib.png" alt="Raqeeb Logo" style="inline-size:120px; block-size:auto; margin-block-end:2rem;">
            <h1 class="display-4 fw-bold mb-3" style="color:#2B8B68; letter-spacing:2px;">raqeeb</h1>
            <h2 class="mb-4" style="color:#fff; font-weight:600;">{{$settings['home_heading']}}</h2>
            <p class="lead mb-4" style="color:#fff;">{{$settings['home_description']}}</p>
            <div class="d-flex justify-content-center gap-3 mb-4">
                @if(!empty($settings['home_live_demo_link']))
                <a href="{{$settings['home_live_demo_link']}}" class="btn btn-lg" style="background:#2B8B68; color:#fff; border-radius:30px; min-inline-size:150px;">Live Demo</a>
                @endif
                @if(!empty($settings['home_buy_now_link']))
                <a href="{{$settings['home_buy_now_link']}}" class="btn btn-lg" style="background:#fff; color:#2B8B68; border-radius:30px; min-inline-size:150px; border:2px solid #2B8B68;">Buy Now</a>
                @endif
            </div>
            <div class="mt-5">
                <img src="{{$logo.'/'.$settings['home_banner']}}" alt="Banner" class="img-fluid rounded shadow" style="max-inline-size:100%; border:6px solid #fff;">
            </div>
        </div>
    </div>
@endsection



