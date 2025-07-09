{{Form::model($leave,array('route' => array('leave.update', $leave->id), 'method' => 'PUT', 'class'=>'needs-validation', 'novalidate')) }}
<div class="modal-body">
    {{-- start for ai module--}}
    @php
        $plan= \App\Models\Utility::getChatGPTSettings();
    @endphp
    @if($plan->chatgpt == 1)
    <div class="text-end">
        <a href="#" data-size="md" class="btn  btn-primary btn-icon btn-sm" data-ajax-popup-over="true" data-url="{{ route('generate',['leave']) }}"
           data-bs-placement="top" data-title="{{ __('Generate content with AI') }}">
            <i class="fas fa-robot"></i> <span>{{__('Generate with AI')}}</span>
        </a>
    </div>
    @endif
    {{-- end for ai module--}}

    @if(\Auth::user()->type =='company' || \Auth::user()->type =='HR')
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('employee_id',__('Employee') ,['class'=>'form-label'])}}<x-required></x-required>
                {{Form::select('employee_id',$employees,null,array('class'=>'form-control select','placeholder'=>__('Select Employee'), 'required' => 'required'))}}
                <div class="text-xs mt-1">
                    {{ __('Create employee here.') }} <a href="{{ route('employee.index') }}"><b>{{ __('Create employee') }}</b></a>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('leave_type_id',__('Leave Type'),['class'=>'form-label'])}}<x-required></x-required>
                {{Form::select('leave_type_id',$leavetypes,null,array('class'=>'form-control select','placeholder'=>__('Select Leave Type'),'required' =>'required'))}}
                <div class="text-xs mt-1">
                    {{ __('Create leave type here.') }} <a href="{{ route('leavetype.index') }}"><b>{{ __('Create leave type') }}</b></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('start_date',__('Start Date'),['class'=>'form-label'])}}<x-required></x-required>
                {{Form::date('start_date',null,array('class'=>'form-control','required' =>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('end_date',__('End Date'),['class'=>'form-label'])}}<x-required></x-required>
                {{Form::date('end_date',null,array('class'=>'form-control','required' =>'required'))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('leave_reason',__('Leave Reason'),['class'=>'form-label'])}}<x-required></x-required>
                {{Form::textarea('leave_reason',null,array('class'=>'form-control','placeholder'=>__('Leave Reason'),'required' =>'required'))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-end">
            <a href="#" data-size="md" class="btn btn-primary btn-icon btn-sm text-right" data-ajax-popup-over="true" id="grammarCheck" data-url="{{ route('grammar',['grammar']) }}"
               data-bs-placement="top" data-title="{{ __('Grammar check with AI') }}">
                <i class="ti ti-rotate"></i> <span>{{__('Grammar check with AI')}}</span>
            </a>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('remark',__('Remark'),['class'=>'form-label'])}}<x-required></x-required>
                {{Form::textarea('remark',null,array('class'=>'form-control grammer_textarea','placeholder'=>__('Leave Remark'),'required' =>'required'))}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="with_deduction" name="with_deduction" {{ old('with_deduction', $leave->with_deduction ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="with_deduction">
                            {{ __('With Deduction') }}
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="deduction_fields" style="display:none;">
                <div class="form-group">
                    {{ Form::label('deduction_amount', __('Deduction Amount'), ['class' => 'form-label']) }}
                    {{ Form::number('deduction_amount', old('deduction_amount', $leave->deduction_amount ?? null), ['class' => 'form-control', 'step' => '0.01', 'min' => '0', 'placeholder' => __('Enter Deduction Amount')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label('start_deduction_date', __('Deduction Start Month'), ['class' => 'form-label']) }}
                    {{ Form::month('start_deduction_date', old('start_deduction_date', $leave->start_deduction_date ?? null), ['class' => 'form-control', 'placeholder' => __('Select Start Month')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label('end_deduction_date', __('Deduction End Month'), ['class' => 'form-label']) }}
                    {{ Form::month('end_deduction_date', old('end_deduction_date', $leave->end_deduction_date ?? null), ['class' => 'form-control', 'placeholder' => __('Select End Month')]) }}
                </div>
            </div>
        </div>
    </div>
    @role('Company')
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('status',__('Status'))}}
                <select name="status" id="" class="form-control select2">
                    <option value="">{{__('Select Status')}}</option>
                    <option value="pending" @if($leave->status=='Pending') selected="" @endif>{{__('Pending')}}</option>
                    <option value="approval" @if($leave->status=='Approval') selected="" @endif>{{__('Approval')}}</option>
                    <option value="reject" @if($leave->status=='Reject') selected="" @endif>{{__('Reject')}}</option>
                </select>
            </div>
        </div>
    </div>
    @endrole

</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-secondary" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>
    {{Form::close()}}

<script>
    var employee_id = "{{$employee_id}}";
    var leave_type_id = "{{isset($leave) ? $leave->leave_type_id : null}}";
    leaveCount(employee_id, leave_type_id)
</script>

<script>
$(document).ready(function() {
    function toggleDeductionFields() {
        if($('#with_deduction').is(':checked')) {
            $('#deduction_fields').show();
        } else {
            $('#deduction_fields').hide();
            $("input[name='deduction_amount']").val('');
            $("input[name='start_deduction_date']").val('');
            $("input[name='end_deduction_date']").val('');
        }
    }
    toggleDeductionFields();
    $(document).on('change', '#with_deduction', toggleDeductionFields);
});
</script>
