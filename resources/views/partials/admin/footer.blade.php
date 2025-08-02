@php
    use App\Models\Utility;
    $setting = \App\Models\Utility::settings();
    $setting_arr = Utility::file_validate();
@endphp
<!-- [ Main Content ] end -->
<footer class="dash-footer">
    <div class="footer-wrapper">
        <div class="py-1">
            <p class="mb-0 text-muted"> &copy;
                {{ date('Y') }} {{ $setting['footer_text'] ? $setting['footer_text'] : config('app.name', 'Raqib') }}
            </p>
        </div>
    </div>
</footer>


<!-- Warning Section Ends -->
<!-- Required Js -->

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery.form.js') }}"></script>
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>


<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/dash.js') }}"></script>
<script src="{{ asset('assets/js/immediate-submenu-fix.js') }}"></script>
<script src="{{ asset('assets/js/menu-fix.js') }}"></script>
<script src="{{ asset('assets/js/hrm-submenu-fix.js') }}"></script>
<script src="{{ asset('assets/js/sidebar-auto-close.js') }}"></script>
@if(config('app.debug'))
<script src="{{ asset('assets/js/menu-test.js') }}"></script>
@endif

<!-- HRM Submenu Override Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Force visibility of HRM submenu items
    function forceHRMVisibility() {
        const hrmLinks = document.querySelectorAll('a[href*="training"], a[href*="trainer"], a[href*="payslip"], a[href*="setsalary"]');
        hrmLinks.forEach(link => {
            const parentItem = link.closest('.dash-item');
            if (parentItem && parentItem.closest('.dash-submenu')) {
                parentItem.style.display = 'block';
                parentItem.style.visibility = 'visible';
                parentItem.style.opacity = '1';
                link.style.display = 'block';
                link.style.visibility = 'visible';
            }
        });
        
        // Also check by text content
        const submenuItems = document.querySelectorAll('.dash-submenu .dash-item');
        submenuItems.forEach(item => {
            const link = item.querySelector('a');
            if (link) {
                const text = link.textContent.trim().toLowerCase();
                if (text.includes('training') || text.includes('trainer') || 
                    text.includes('payslip') || text.includes('set salary')) {
                    item.style.display = 'block';
                    item.style.visibility = 'visible';
                    item.style.opacity = '1';
                    link.style.display = 'block';
                    link.style.visibility = 'visible';
                }
            }
        });
    }
    
    // Apply immediately and repeatedly to override other scripts
    forceHRMVisibility();
    setTimeout(forceHRMVisibility, 100);
    setTimeout(forceHRMVisibility, 500);
    setTimeout(forceHRMVisibility, 1000);
    
    // Apply whenever menu is clicked
    document.addEventListener('click', function(e) {
        if (e.target.closest('.dash-hasmenu')) {
            setTimeout(forceHRMVisibility, 50);
        }
    });
});
</script>
<script src="{{ asset('js/moment.min.js') }}"></script>

<script src="{{ asset('assets/js/plugins/bootstrap-switch-button.min.js') }}"></script>

<script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/simple-datatables.js') }}"></script>

<!-- Apex Chart -->
<script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>

<script src="{{ asset('js/jscolor.js') }}"></script>

<script src="{{ asset('js/popper.min.js') }}"></script>


<script>
    var file_size = "{{ $setting_arr['max_size'] }}";
    var file_types = "{{ $setting_arr['types'] }}";
    var type_err = "{{ __('Invalid file type. Please select a valid file ('.$setting_arr['types'].').') }}";
    var size_err = "{{ __('File size exceeds the maximum limit of '. $setting_arr['max_size'] / 1024 .'MB.') }}";
</script>
<script>
    var site_currency_symbol_position = '{{ $setting['site_currency_symbol_position'] }}';
    var site_currency_symbol = '{{ $setting['site_currency_symbol'] }}';

</script>
<script src="{{ asset('js/custom.js') }}"></script>

@if($message = Session::get('success'))
    <script>
        show_toastr('success', '{!! $message !!}');
    </script>
@endif
@if($message = Session::get('error'))
    <script>
        show_toastr('error', '{!! $message !!}');
    </script>
@endif
@if($setting['enable_cookie'] == 'on')
    @include('layouts.cookie_consent')
@endif
@stack('script-page')

@stack('old-datatable-js')



<script>




    feather.replace();
    var pctoggle = document.querySelector("#pct-toggler");
    if (pctoggle) {
        pctoggle.addEventListener("click", function () {
            if (
                !document.querySelector(".pct-customizer").classList.contains("active")
            ) {
                document.querySelector(".pct-customizer").classList.add("active");
            } else {
                document.querySelector(".pct-customizer").classList.remove("active");
            }
        });
    }

    var themescolors = document.querySelectorAll(".themes-color > a");
    for (var h = 0; h < themescolors.length; h++) {
        var c = themescolors[h];

        c.addEventListener("click", function (event) {
            var targetElement = event.target;
            if (targetElement.tagName == "SPAN") {
                targetElement = targetElement.parentNode;
            }
            var temp = targetElement.getAttribute("data-value");
            removeClassByPrefix(document.querySelector("body"), "theme-");
            document.querySelector("body").classList.add(temp);
        });
    }

    var custthemebg = document.querySelector("#cust-theme-bg");
    custthemebg.addEventListener("click", function () {
        if (custthemebg.checked) {
            document.querySelector(".dash-sidebar").classList.add("transprent-bg");
            document
                .querySelector(".dash-header:not(.dash-mob-header)")
                .classList.add("transprent-bg");
        } else {
            document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
            document
                .querySelector(".dash-header:not(.dash-mob-header)")
                .classList.remove("transprent-bg");
        }
    });




    function removeClassByPrefix(node, prefix) {
        for (let i = 0; i < node.classList.length; i++) {
            let value = node.classList[i];
            if (value.startsWith(prefix)) {
                node.classList.remove(value);
            }
        }
    }
</script>


