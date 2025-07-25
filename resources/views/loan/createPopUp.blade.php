{{Form::open(array('url' => 'loan', 'method' => 'post', 'class' => 'needs-validation', 'novalidate'))}}
<div class="modal-body">
    <div class="row">
    <div class="col-md-12">
      <div class="form-group">
      {{Form::label('employee_id', __('Employee'), ['class' => 'form-label'])}}<x-required></x-required>
      {{Form::select('employee_id', $employees, 1, array('class' => 'form-control select', 'id' => 'employee_id', 'placeholder' => __('Select Employee'), 'required' => 'required'))}}
      @can('create employee')
      <div class="text-xs mt-1">
        {{ __('Create employee here.') }} <a
        href="{{ route('employee.index') }}"><b>{{ __('Create employee') }}</b></a>
      </div>
      @endcan
      </div>
    </div>
    </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        {{Form::label('loan_option_id', __('Loan Option'), ['class' => 'form-label'])}}<x-required></x-required>
        <select name="loan_option" id="loan_option_id" class="form-control select" required>
          <option value="">{{ __('Select Loan Option') }}</option>
          @foreach($loanOptions as $loan)
        <option value="{{ $loan->id }}">{{ $loan->name }}
        </option>
      @endforeach
        </select>
        @can('create loan option')
        <div class="text-xs mt-1">
          {{ __('Create loan option here.') }} <a
            href="{{ route('loanoption.index') }}"><b>{{ __('Create loan option') }}</b></a>
        </div>
        @endcan
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        {{ Form::label('title', __('Loan Title'), ['class' => 'form-label']) }}
        {{ Form::text('title', null, ['class' => 'form-control', 'step' => '0.01', 'min' => '0', 'placeholder' => __('Enter Loan Title')]) }}
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        {{ Form::label('amount', __('Loan Amount'), ['class' => 'form-label']) }}
        {{ Form::number('amount', null, ['class' => 'form-control', 'step' => '0.01', 'min' => '0', 'placeholder' => __('Enter Loan Amount')]) }}
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        {{Form::label('reason', __('Loan Reason'), ['class' => 'form-label'])}}<x-required></x-required>
        {{Form::textarea('reason', null, array('class' => 'form-control', 'placeholder' => __('Loan Reason'), 'required' => 'required'))}}
      </div>
    </div>
  </div>
  @can('manage loan')
  <div class="row">
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
    <div class="col-md-12" id="deduction_fields" style="display:none;">
      <div class="form-group">
        {{ Form::label('deduction_amount', __('Deduction Amount'), ['class' => 'form-label']) }}
        {{ Form::number('deduction_amount', null, ['class' => 'form-control', 'step' => '0.01', 'min' => '0', 'placeholder' => __('Enter Deduction Amount')]) }}
      </div>
      <div class="form-group">
        {{ Form::label('start_deduction_date', __('Deduction Start Month'), ['class' => 'form-label']) }}
        {{ Form::month('start_deduction_date', null, ['class' => 'form-control', 'placeholder' => __('Select Start Month')]) }}
      </div>
      <div class="form-group">
        {{ Form::label('end_deduction_date', __('Deduction End Month'), ['class' => 'form-label']) }}
        {{ Form::month('end_deduction_date', null, ['class' => 'form-control', 'placeholder' => __('Select End Month')]) }}
      </div>
    </div>
  </div>
  @endcan
</div>
<div class="modal-footer">
  <input type="button" value="{{__('Cancel')}}" class="btn  btn-secondary" data-bs-dismiss="modal">
  <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}

<script>
  @if ((\Auth::user()->type != 'company' && \Auth::user()->type != 'HR') && isset($employee_id))
    var employee_id = "{{$employee_id}}";
    loanCount(employee_id, null)
  @endif
</script>

<script>
  $(document).on('change', '#with_deduction', function () {
    if ($(this).is(':checked')) {
      $('#deduction_fields').show();
      $("input[name='deduction_amount']").val($("input[name='amount']").val())
    } else {
      $('#deduction_fields').hide();
      $("input[name='deduction_amount']").val('');
      $("input[name='start_deduction_date']").val('');
      $("input[name='end_deduction_date']").val('');
    }
  });
</script>