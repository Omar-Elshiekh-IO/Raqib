{{ Form::model($bankAccount, array('route' => array('bank-account.update', $bankAccount->id), 'method' => 'PUT', 'class'=>'needs-validation', 'novalidate')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('chart_account_id', __('Account'),['class'=>'form-label']) }}<x-required></x-required>
            <select name="chart_account_id" class="form-control" required="required">
                @foreach ($chartAccounts as $key => $chartAccount)
                    <option value="{{ $key }}" class="subAccount" {{ $key == $bankAccount->chart_account_id ? 'selected' : ''}}>{{ $chartAccount }}</option>
                    @foreach ($subAccounts as $subAccount)
                        @if ($key == $subAccount['account'])
                            <option value="{{ $subAccount['id'] }}" class="ms-5" {{ $subAccount['id'] == $bankAccount->chart_account_id ? 'selected' : ''}}> &nbsp; &nbsp;&nbsp; {{ $subAccount['code_name'] }}</option>
                        @endif
                    @endforeach
                @endforeach
            </select>
            <div class="text-xs mt-1">
                {{ __('Create account here.') }} <a href="{{ route('chart-of-account.index') }}"><b>{{ __('Create account') }}</b></a>
            </div>
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('holder_name', __('Bank Holder Name'),['class'=>'form-label']) }}<x-required></x-required>
            {{ Form::text('holder_name',null, array('class' => 'form-control','required'=>'required', 'placeholder'=>__('Enter Bank Holder Name'))) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('bank_name', __('Bank Name'),['class'=>'form-label']) }}<x-required></x-required>
            {{ Form::text('bank_name',null, array('class' => 'form-control','required'=>'required', 'placeholder' => __('Enter Bank Name'))) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('account_number', __('Account Number'),['class'=>'form-label']) }}<x-required></x-required>
            {{ Form::text('account_number',null, array('class' => 'form-control','required'=>'required', 'placeholder' => __('Enter Account Number'))) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('opening_balance', __('Opening Balance'),['class'=>'form-label']) }}
            {{ Form::number('opening_balance',null, array('class' => 'form-control','step'=>'0.01', 'placeholder'=>__('Enter Opening Balance'))) }}
        </div>
        <div class="col-md-6">
            <x-mobile label="{{__('Contact Number')}}" name="contact_number" value="{{old('contact_number')}}" placeholder="Enter Contact Number"></x-mobile>
        </div>
        <div class="form-group  col-md-12 mb-0">
            {{ Form::label('bank_address', __('Bank Address'),['class'=>'form-label']) }}
            {{ Form::textarea('bank_address',null, array('class' => 'form-control','rows'=>3, 'placeholder' => __('Enter Bank Address'))) }}
        </div>
        @if(!$customFields->isEmpty())
                    @include('customFields.formBuilder')
        @endif

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-secondary" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}
