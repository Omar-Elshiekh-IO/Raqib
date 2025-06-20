{{-- SEO settings --}}
   <div id="seo-settings" class="card">
                        <div class="card-header p-3 d-flex justify-content-between align-items-center">
                            <h5>{{ __('SEO Settings') }}</h5>
                            @php
                                $settings = \App\Models\Utility::settings();
                            @endphp
                            @if (!empty($settings['chat_gpt_key']))
                                <div class="d-flex justify-content-end">
                                    <div class="mt-0">
                                        <a data-size="md" class="btn btn-primary text-white btn-sm"
                                            data-ajax-popup-over="true" data-url="{{ route('generate', ['seo']) }}"
                                            data-bs-placement="top" data-title="{{ __('Generate content with AI') }}">
                                            <i class="fas fa-robot"></i> <span>{{ __('Generate with AI') }}</span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        {{ Form::open(['url' => route('seo.settings.store'), 'method' => 'post','class' => 'mb-0', 'enctype' => 'multipart/form-data']) }}
                        @csrf
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('Meta Keywords', __('Meta Keywords'), ['class' => 'col-form-label']) }}
                                        {{ Form::text('meta_title', !empty($setting['meta_title']) ? $setting['meta_title'] : '', ['class' => 'form-control ', 'placeholder' => 'Meta Keywords']) }}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('Meta Description', __('Meta Description'), ['class' => 'col-form-label']) }}
                                        {{ Form::textarea('meta_desc', !empty($setting['meta_desc']) ? $setting['meta_desc'] : '', ['class' => 'form-control ', 'placeholder' => 'Meta Description', 'rows' => 7]) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        {{ Form::label('Meta Image', __('Meta Image'), ['class' => 'col-form-label']) }}
                                    </div>
                                    <div class="setting-card">
                                        <div class="logo-content">
                                            <img id="image2"
                                                src="{{ $meta_image . '/' . (isset($setting['meta_image']) && !empty($setting['meta_image']) ? $setting['meta_image'] : 'default.png') }}"
                                                class="img_setting seo_image">
                                        </div>
                                        <div class="choose-files mt-4">
                                            <label for="meta_image">
                                                <div class="bg-primary company_favicon_update"> <i
                                                        class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                </div>
                                                <input type="file" class="form-control file" id="meta_image"
                                                    name="meta_image" data-filename="meta_image">
                                            </label>
                                        </div>
                                        @error('meta_image')
                                            <div class="row">
                                                <span class="invalid-logo" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer p-3 text-end">
                            <input class="btn btn-print-invoice btn-primary" type="submit"
                                value="{{ __('Save Changes') }}">
                        </div>
                        {{ Form::close() }}
                    </div>
