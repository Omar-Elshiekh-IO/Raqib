
    {{Form::model($workShift,array('route' => array('work-shift.update', $workShift->id), 'method' => 'PUT', 'class'=>'needs-validation', 'novalidate')) }}
    <div class="modal-body">

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('title',__('Title'),['class'=>'form-label'])}}
                {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter work shift title')))}}
            </div>
            <div class="form-group">
                {{Form::label('from',__('From'),['class'=>'form-label'])}}
                {{Form::time('from',null,array('class'=>'form-control','placeholder'=>__('Enter work shift start time')))}}
            </div>
            <div class="form-group">
                {{Form::label('to',__('To'),['class'=>'form-label'])}}
                {{Form::time('to',null,array('class'=>'form-control','placeholder'=>__('Enter work shift end time')))}}
            </div>
            <div class="form-group">
              <div class="form-group">
    {{ Form::label('days[]', 'Work Days', ['class' => 'form-label fw-bold mb-2']) }}

    <div class="row g-2">
        <div class="col-auto">
            <div class="form-check">
                {{ Form::checkbox('days[]', 0, null, ['id' => 'day_0', 'class' => 'form-check-input']) }}
                {{ Form::label('day_0', 'Sunday', ['class' => 'form-check-label']) }}
            </div>
        </div>
        <div class="col-auto">
            <div class="form-check">
                {{ Form::checkbox('days[]', 1, null, ['id' => 'day_1', 'class' => 'form-check-input']) }}
                {{ Form::label('day_1', 'Monday', ['class' => 'form-check-label']) }}
            </div>
        </div>
        <div class="col-auto">
            <div class="form-check">
                {{ Form::checkbox('days[]', 2, null, ['id' => 'day_2', 'class' => 'form-check-input']) }}
                {{ Form::label('day_2', 'Tuesday', ['class' => 'form-check-label']) }}
            </div>
        </div>
        <div class="col-auto">
            <div class="form-check">
                {{ Form::checkbox('days[]', 3, null, ['id' => 'day_3', 'class' => 'form-check-input']) }}
                {{ Form::label('day_3', 'Wednesday', ['class' => 'form-check-label']) }}
            </div>
        </div>
        <div class="col-auto">
            <div class="form-check">
                {{ Form::checkbox('days[]', 4, null, ['id' => 'day_4', 'class' => 'form-check-input']) }}
                {{ Form::label('day_4', 'Thursday', ['class' => 'form-check-label']) }}
            </div>
        </div>
        <div class="col-auto">
            <div class="form-check">
                {{ Form::checkbox('days[]', 5, null, ['id' => 'day_5', 'class' => 'form-check-input']) }}
                {{ Form::label('day_5', 'Friday', ['class' => 'form-check-label']) }}
            </div>
        </div>
        <div class="col-auto">
            <div class="form-check">
                {{ Form::checkbox('days[]', 6, null, ['id' => 'day_6', 'class' => 'form-check-input']) }}
                {{ Form::label('day_6', 'Saturday', ['class' => 'form-check-label']) }}
            </div>
        </div>
    </div>
</div>


          </div>

        </div>

    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-secondary" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn btn-primary">
</div>
    {{Form::close()}}

