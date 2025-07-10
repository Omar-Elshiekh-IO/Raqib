{{-- Cache settings --}}
                    <div class="card" id="cache-settings">
                        <div class="card-header p-3">
                            <h5>{{ 'Cache Settings' }}</h5>
                            <small class="text-secondary font-weight-bold">
                                {{ __("This is a page meant for more advanced users, simply ignore it if you don't understand what cache is.") }}
                            </small>
                        </div>
                        <form method="POST" action="{{ route('cache.settings.store') }}" accept-charset="UTF-8" class="mb-0">
                            @csrf
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-12 form-group mb-0">
                                        {{ Form::label('Current cache size', __('Current cache size'), ['class' => 'col-form-label']) }}
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="{{ $file_size }}"
                                                readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text"
                                                    id="basic-addon6">{{ __('MB') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer p-3 text-end">
                                <input class="btn btn-print-invoice btn-primary" type="submit"
                                    value="{{ __('Cache Clear') }}">
                            </div>
                            {{ Form::close() }}
                    </div>

                