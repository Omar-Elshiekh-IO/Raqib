@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div id="ajax-errors" class="alert alert-danger d-none"></div>
{{ Form::model($businessMission, ['route' => ['business-mission.update', $businessMission->id], 'method' => 'PUT', 'class' => 'needs-validation', 'novalidate', 'id' => 'business-mission-edit-form']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('employee_id', __('Employee'), ['class' => 'form-label']) }}<x-required></x-required>
            {{ Form::select('employee_id', $employees, null, ['class' => 'form-control select', 'required' => 'required', 'placeholder' => __('Select Employee')]) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('title', __('Mission Title'), ['class' => 'form-label']) }}<x-required></x-required>
            {{ Form::text('title', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Mission Title')]) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}<x-required></x-required>
            {{ Form::date('start_date', null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}<x-required></x-required>
            {{ Form::date('end_date', null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::textarea('description', null, ['class' => 'form-control', 'required' => 'required', 'rows' => 3, 'placeholder' => __('Enter Description')]) }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('remark', __('Remark'), ['class' => 'form-label']) }}
                {{ Form::text('remark', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('Enter Remark')]) }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                {{ Form::select('status', ['Pending'=>'Pending','Approved'=>'Approved','In_Progress'=>'In Progress','Completed'=>'Completed','Canceled'=>'Canceled'], null, ['class' => 'form-control']) }}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-secondary" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn btn-primary">
</div>
{{ Form::close() }}
<script>
$(document).on('submit', '#business-mission-edit-form', function(e) {
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