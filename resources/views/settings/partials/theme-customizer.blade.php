{{-- Theme Customizer Section --}}
<div class="ms-3"><!-- Added left margin -->
    <h4 class="small-title h5 mb-3">{{ __('Theme Customizer') }}</h4>
    <div class="setting-card">
        <div class="row row-gap-1">
            <div class="col-xxl-4 col-sm-6 col-12">
                <div class="card h-100 mb-0">
                    <div class="card-header p-3">
                        <h6 class="mb-0 d-flex align-items-center gap-2">
                            <i
                                data-feather="credit-card"></i>{{ __('Primary color settings') }}
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="color-wrp mt-0">
                            <div class="theme-color themes-color">
                                <a href="#!"
                                    class="themes-color-change {{ $color == 'theme-1' ? 'active_color' : '' }}"
                                    data-value="theme-1"></a>
                                <input type="radio" class="theme_color d-none"
                                    name="color"
                                    value="theme-1"{{ $color == 'theme-1' ? 'checked' : '' }}>
                                <a href="#!"
                                    class="themes-color-change {{ $color == 'theme-2' ? 'active_color' : '' }}"
                                    data-value="theme-2"></a>
                                <input type="radio" class="theme_color d-none"
                                    name="color"
                                    value="theme-2"{{ $color == 'theme-2' ? 'checked' : '' }}>
                                <a href="#!"
                                    class="themes-color-change {{ $color == 'theme-3' ? 'active_color' : '' }}"
                                    data-value="theme-3"></a>
                                <input type="radio" class="theme_color d-none"
                                    name="color"
                                    value="theme-3"{{ $color == 'theme-3' ? 'checked' : '' }}>
                                <a href="#!"
                                    class="themes-color-change {{ $color == 'theme-4' ? 'active_color' : '' }}"
                                    data-value="theme-4"></a>
                                <input type="radio" class="theme_color d-none"
                                    name="color"
                                    value="theme-4"{{ $color == 'theme-4' ? 'checked' : '' }}>
                                <a href="#!"
                                    class="themes-color-change {{ $color == 'theme-5' ? 'active_color' : '' }}"
                                    data-value="theme-5"></a>
                                <input type="radio" class="theme_color d-none"
                                    name="color"
                                    value="theme-5"{{ $color == 'theme-5' ? 'checked' : '' }}>

                                <a href="#!"
                                    class="themes-color-change {{ $color == 'theme-6' ? 'active_color' : '' }}"
                                    data-value="theme-6"></a>
                                <input type="radio" class="theme_color d-none"
                                    name="color"
                                    value="theme-6"{{ $color == 'theme-6' ? 'checked' : '' }}>
                                <a href="#!"
                                    class="themes-color-change {{ $color == 'theme-7' ? 'active_color' : '' }}"
                                    data-value="theme-7"></a>
                                <input type="radio" class="theme_color d-none"
                                    name="color"
                                    value="theme-7"{{ $color == 'theme-7' ? 'checked' : '' }}>
                                <a href="#!"
                                    class="themes-color-change {{ $color == 'theme-8' ? 'active_color' : '' }}"
                                    data-value="theme-8"></a>
                                <input type="radio" class="theme_color d-none"
                                    name="color"
                                    value="theme-8"{{ $color == 'theme-8' ? 'checked' : '' }}>
                                <a href="#!"
                                    class="themes-color-change {{ $color == 'theme-9' ? 'active_color' : '' }}"
                                    data-value="theme-9"></a>
                                <input type="radio" class="theme_color d-none"
                                    name="color"
                                    value="theme-9"{{ $color == 'theme-9' ? 'checked' : '' }}>
                                <a href="#!"
                                    class="themes-color-change {{ $color == 'theme-10' ? 'active_color' : '' }}"
                                    data-value="theme-10"></a>
                                <input type="radio" class="theme_color d-none"
                                    name="color"
                                    value="theme-10"{{ $color == 'theme-10' ? 'checked' : '' }}>
                            </div>
                            <div class="color-picker-wrp">
                                <input type="color" value="{{ $color ? $color : '' }}"
                                    class="colorPicker {{ isset($flag) && $flag == 'true' ? 'active_color' : '' }}"
                                    name="custom_color" id="color-picker">
                                <input type='hidden' name="color_flag"
                                    value={{ isset($flag) && $flag == 'true' ? 'true' : 'false' }}>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          
           
                                         <!-- Transparent Layout option removed -->
       
            <div class="col-xxl-3 col-sm-6 col-12">
                <div class="card h-100 mb-0">
                    <div class="card-header p-3">
                        <h6 class="mb-0 d-flex align-items-center gap-2">
                            <i data-feather="sun"></i>{{ __('Layout settings') }}
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="form-check form-switch d-flex gap-2 flex-column p-0">
                            <label class="form-check-label f-w-600 pl-1"
                                for="cust-darklayout">{{ __('Dark Layout') }}</label>
                            <input type="checkbox" class="form-check-input mx-0"
                                id="cust-darklayout"
                                name="cust_darklayout"{{ !empty($settings['cust_darklayout']) && $settings['cust_darklayout'] == 'on' ? 'checked' : '' }} />
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xxl-2 col-sm-6 col-12">
                <div class="card h-100 mb-0">
                    <div class="card-header p-3">
                        <h6 class="mb-0 d-flex align-items-center gap-2">
                            <i class="ti ti-align-right"></i>{{ __('Enable RTL') }}
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="form-check form-switch d-flex gap-2 flex-column p-0">
                            <label class="form-check-label f-w-600 pl-1"
                                for="SITE_RTL">{{ __('RTL Layout') }}</label>
                            <input type="checkbox" name="SITE_RTL"
                                id="SITE_RTL"class="form-check-input mx-0"
                                {{ $settings['SITE_RTL'] == 'on' ? 'checked="checked"' : '' }}>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- End Theme Customizer Section --}}
