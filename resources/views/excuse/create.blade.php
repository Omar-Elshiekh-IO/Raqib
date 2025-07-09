{{ Form::open(['url' => 'excuse', 'method' => 'post', 'class' => 'needs-validation', 'novalidate']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('employee_id', __('Employee'), ['class' => 'form-label']) }}<x-required></x-required>
            {{ Form::select('employee_id', $employees, null, ['class' => 'form-control select', 'required' => 'required', 'placeholder' => __('Select Employee')]) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('excuse_date', __('Excuse Date'), ['class' => 'form-label']) }}<x-required></x-required>
            {{ Form::date('excuse_date', null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('start_time', __('Start Time'), ['class' => 'form-label']) }}<x-required></x-required>
            {{ Form::time('start_time', null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('end_time', __('End Time'), ['class' => 'form-label']) }}<x-required></x-required>
            {{ Form::time('end_time', null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('reason', __('Reason'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::textarea('reason', null, ['class' => 'form-control', 'required' => 'required', 'rows' => 3, 'placeholder' => __('Enter Reason')]) }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('remark', __('Remark'), ['class' => 'form-label']) }}
                {{ Form::textarea('remark', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => __('Remark (optional)')]) }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="with_deduction" name="with_deduction">
                    <label class="form-check-label" for="with_deduction">
                        {{ __('With Deduction') }}
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-12" id="deduction_amount_group" style="display:none;">
            <div class="form-group">
                {{ Form::label('deduction_amount', __('Deduction Amount'), ['class' => 'form-label']) }}
                {{ Form::number('deduction_amount', null, ['class' => 'form-control', 'step' => '0.01', 'min' => '0', 'placeholder' => __('Enter Deduction Amount')]) }}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-secondary" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn btn-primary">
</div>
{{ Form::close() }}
<script>
$(document).on('change', '#with_deduction', function() {
    if($(this).is(':checked')) {
        $('#deduction_amount_group').show();
    } else {
        $('#deduction_amount_group').hide();
        $("input[name='deduction_amount']").val('');
    }
});
</script> 