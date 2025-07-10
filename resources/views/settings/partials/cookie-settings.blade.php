{{-- Cookie settings --}}
                    <div class="card" id="cookie-settings">

                        {{ Form::model($settings, ['route' => 'cookie.setting','class' => 'mb-0', 'method' => 'post']) }}
                        <div
                            class="card-header p-3 flex-column flex-lg-row d-flex align-items-lg-center gap-2 justify-content-between">
                            <h5>{{ __('Cookie Settings') }}</h5>
                            <div class="d-flex align-items-center">
                                {{ Form::label('enable_cookie', __('Enable cookie'), ['class' => 'col-form-label p-0 fw-bold me-3']) }}
                                <div class="custom-control custom-switch me-2" onclick="enablecookie()">
                                    <input type="checkbox" data-toggle="switchbutton" data-onstyle="primary"
                                        name="enable_cookie" class="form-check-input input-primary "
                                        id="enable_cookie" {{ $settings['enable_cookie'] == 'on' ? ' checked ' : '' }}>
                                    <label class="custom-control-label mb-1" for="enable_cookie"></label>
                                </div>
                            </div>
                        </div>
                        <div
                            class="card-body p-3 cookieDiv {{ $settings['enable_cookie'] == 'off' ? 'disabledCookie ' : '' }}">
                            @php
                                $settings = \App\Models\Utility::settings();
                            @endphp
                            <div class="row">
                                <div class="text-end mb-3">
                                    @if (!empty($settings['chat_gpt_key']))
                                        <div class="mt-0">
                                            <a data-size="md" class="btn btn-primary text-white btn-sm"
                                                data-ajax-popup-over="true"
                                                data-url="{{ route('generate', ['cookie']) }}" data-bs-placement="top"
                                                data-title="{{ __('Generate content with AI') }}">
                                                <i class="fas fa-robot"></i> <span>{{ __('Generate with AI') }}</span>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row row-gap-1">
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-body p-3">
                                    <div class="form-check form-switch custom-switch-v1" id="cookie_log">
                                        <input type="checkbox" name="cookie_logging"
                                            class="form-check-input input-primary cookie_setting" id="cookie_logging"
                                            {{ $settings['cookie_logging'] == 'on' ? ' checked ' : '' }}>
                                        <label class="form-check-label"
                                            for="cookie_logging">{{ __('Enable logging') }}</label>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('cookie_title', __('Cookie Title'), ['class' => 'col-form-label']) }}
                                        {{ Form::text('cookie_title', null, ['class' => 'form-control cookie_setting', 'placeholder' => __('Cookie Title')]) }}
                                    </div>
                                    <div class="form-group mb-0">
                                        {{ Form::label('cookie_description', __('Cookie Description'), ['class' => ' form-label']) }}
                                        {!! Form::textarea('cookie_description', null, [
                                            'class' => 'form-control cookie_setting',
                                            'rows' => '3',
                                            'placeholder' => __('Cookie Description'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-body p-3">
                                    <div class="form-check form-switch custom-switch-v1 ">
                                        <input type="checkbox" name="necessary_cookies"
                                            class="form-check-input input-primary" id="necessary_cookies" checked
                                            onclick="return false">
                                        <label class="form-check-label"
                                            for="necessary_cookies">{{ __('Strictly necessary cookies') }}</label>
                                    </div>
                                </div>
                            </div>
                                    <div class="form-group ">
                                        {{ Form::label('strictly_cookie_title', __(' Strictly Cookie Title'), ['class' => 'col-form-label']) }}
                                        {{ Form::text('strictly_cookie_title', null, ['class' => 'form-control cookie_setting', 'placeholder' => __('Strictly Cookie Title')]) }}
                                    </div>
                                    <div class="form-group mb-0">
                                        {{ Form::label('strictly_cookie_description', __('Strictly Cookie Description'), ['class' => ' form-label']) }}
                                        {!! Form::textarea('strictly_cookie_description', null, [
                                            'class' => 'form-control cookie_setting ',
                                            'rows' => '3',
                                            'placeholder' => __('Strivtly Cookie Title'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h5 class="mb-0">{{ __('More Information') }}</h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        {{ Form::label('more_information_description', __('Contact Us Description'), ['class' => 'col-form-label']) }}
                                        {{ Form::text('more_information_description', null, ['class' => 'form-control cookie_setting', 'placeholder' => __('Contact Us Description')]) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0 ">
                                        {{ Form::label('contactus_url', __('Contact Us URL'), ['class' => 'col-form-label']) }}
                                        {{ Form::text('contactus_url', null, ['class' => 'form-control cookie_setting', 'placeholder' => __('Contact Us URL')]) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer p-3 d-flex align-items-center gap-2 flex-wrap justify-content-between">
                                    @if (isset($settings['cookie_logging']) && $settings['cookie_logging'] == 'on')
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <label for="file"
                                            class="form-label mb-0">{{ __('Download cookie accepted data') }}</label>
                                        <a href="{{ asset(Storage::url('uploads/sample')) . '/data.csv' }}"
                                            class="btn btn-primary mr-3" download="">
                                            <i class="ti ti-download"></i>
                                        </a>
                                    </div>
                                    @endif
                                    <input class="btn btn-print-invoice btn-primary cookie_btn" type="submit"
                                        value="{{ __('Save Changes') }}">
                        </div>
                        {{ Form::close() }}
                    </div>

