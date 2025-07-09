@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div id="ajax-errors" class="alert alert-danger d-none"></div>
{{ Form::open(['url' => 'business-mission', 'method' => 'post', 'class' => 'needs-validation', 'novalidate', 'id' => 'business-mission-create-form']) }}
<div class="modal-body">
    <div class="row">
        {{-- Employee --}}
        <div class="form-group col-md-6">
            {{ Form::label('employee_id', __('Employee'), ['class' => 'form-label']) }}<x-required />
            {{ Form::select('employee_id', $employees, old('employee_id'), [
                'class' => 'form-control select' . ($errors->has('employee_id') ? ' is-invalid' : ''),
                'required' => 'required',
                'placeholder' => __('Select Employee')
            ]) }}
            @error('employee_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Title --}}
        <div class="form-group col-md-6">
            {{ Form::label('title', __('Mission Title'), ['class' => 'form-label']) }}<x-required />
            {{ Form::text('title', old('title'), [
                'class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : ''),
                'required' => 'required',
                'placeholder' => __('Enter Mission Title')
            ]) }}
            @error('title')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Start Date --}}
        <div class="form-group col-md-6">
            {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}<x-required />
            {{ Form::date('start_date', old('start_date'), [
                'class' => 'form-control' . ($errors->has('start_date') ? ' is-invalid' : ''),
                'required' => 'required'
            ]) }}
            @error('start_date')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- End Date --}}
        <div class="form-group col-md-6">
            {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}<x-required />
            {{ Form::date('end_date', old('end_date'), [
                'class' => 'form-control' . ($errors->has('end_date') ? ' is-invalid' : ''),
                'required' => 'required'
            ]) }}
            @error('end_date')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Description --}}
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}<x-required />
                {{ Form::textarea('description', old('description'), [
                    'class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : ''),
                    'required' => 'required',
                    'rows' => 3,
                    'placeholder' => __('Enter Description')
                ]) }}
                @error('description')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Remark --}}
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('remark', __('Remark'), ['class' => 'form-label']) }}
                {{ Form::text('remark', old('remark'), [
                    'class' => 'form-control' . ($errors->has('remark') ? ' is-invalid' : ''),
                    'placeholder' => __('Enter Remark')
                ]) }}
                @error('remark')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-secondary" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>
{{ Form::close() }}

<script>
$(document).on('submit', '#business-mission-create-form', function(e) {
    e.preventDefault();
    var $form = $(this);
    var $submitBtn = $form.find('input[type=submit]');
    $submitBtn.prop('disabled', true);

    // Clear previous errors
    $('#ajax-errors').addClass('d-none').html('');
    $form.find('.is-invalid').removeClass('is-invalid');
    $form.find('.invalid-feedback.d-block').remove();

    $.ajax({
        url: $form.attr('action'),
        method: $form.attr('method'),
        data: $form.serialize(),
        success: function(response) {
            location.reload();
        },
        error: function(xhr) {
            $submitBtn.prop('disabled', false);
            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors;
                var errorList = '';
                $.each(errors, function(field, messages) {
                    errorList += messages[0] + '<br>';
                });
                show_toastr('error', errorList);
            } else {
                show_toastr('error', 'An unexpected error occurred.');
            }
        }
    });
});
</script>
