{{Form::open(array('url'=>'branch','method'=>'post', 'class'=>'needs-validation', 'novalidate'))}}
<div class="modal-body">

    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {{Form::label('name',__('Name'),['class'=>'form-label'])}}<x-required></x-required>
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Branch Name'),'required'=> 'required'))}}
                @error('name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                {{Form::label('longitude',__('Longitude'),['class'=>'form-label'])}}<x-required></x-required>
                {{Form::text('longitude',null,array('class'=>'form-control','placeholder'=>__('Enter Longitude'),'required'=> 'required'))}}
                @error('longitude')
                <span class="invalid-longitude" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                {{Form::label('latitude',__('Latitude'),['class'=>'form-label'])}}<x-required></x-required>
                {{Form::text('latitude',null,array('class'=>'form-control','placeholder'=>__('Enter Latitude'),'required'=> 'required'))}}
                @error('latitude')
                <span class="invalid-latitude" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                {{Form::label('login_range',__('Login Range'),['class'=>'form-label'])}}<x-required></x-required>
                {{Form::text('login_range',null,array('class'=>'form-control','placeholder'=>__('Enter Login Range In Meters'),'required'=> 'required'))}}
                @error('login_range')
                <span class="invalid-login_range" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-secondary" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
    {{Form::close()}}

