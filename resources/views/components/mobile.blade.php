@props([
    'label',
    'name',
    'value' => '',
    'required' => false,
    'placeholder' => '',
    'class' => 'form-control',
    'id' => $name, // use $name as default if id is not passed
    'divClass' => 'mb-3',
])
<div class="{{ $divClass }}">
    <div class="form-group">
        {{Form::label($name,$label,['class'=>'form-label'])}}@if($required)<x-required></x-required> @endif
        {{Form::text($name,$value,array('class'=>$class,'placeholder'=>$placeholder,'pattern' => '^\+\d{1,3}\d{9,13}$','id'=>$id,'required'=>$required))}}
        <div class=" text-xs text-danger mt-1">
            {{ __('Please use with country code. (ex. +91)') }}
        </div>
    </div>
</div>
