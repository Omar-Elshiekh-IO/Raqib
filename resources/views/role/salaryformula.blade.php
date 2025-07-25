{{Form::model($role, array('route' => array('roles.setsalaryformula', $role->id), 'method' => 'PUT', 'class' => 'needs-validation', 'novalidate')) }}
<div class="modal-body">
  <div class="row">
    <div class="form-group col-md-12">
      {{ Form::label('salary_formula', __('Salary Formula'), ['class' => 'form-label']) }}<x-required></x-required>
      {{ FOrm::textarea('salary_formula', null, ['class' => 'form-control', 'placeholder' => __('Enter Salary Formula'), 'required' => 'required']) }}
    </div>
    <div class="allowed-variables">
      <ul class="">
        @foreach ($allowedVars as $var)
      <li class="m-10" style="cursor: pointer;">{{ __($var) }}</li>
    @endforeach
      </ul>
    </div>
  </div>
</div>
<div class="modal-footer">
  <input type="button" value="{{__('Cancel')}}" class="btn  btn-secondary" data-bs-dismiss="modal">
  <input type="submit" value="{{__('Set Salary Formula')}}" class="btn  btn-primary">
</div>

{{Form::close()}}

<script>
  const input = document.querySelector("textarea[name='salary_formula']");
  const items = document.querySelectorAll(".allowed-variables li");

  items.forEach(function (item) {
    item.style.cursor = 'pointer';
    item.addEventListener("click", function () {
      const variable = item.textContent.trim();
      input.value += (input.value ? " " : "") + variable;
      input.focus();
    });
  });
</script>
