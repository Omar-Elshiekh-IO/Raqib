{{Form::open(array('url'=>'excuse/changeaction','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        <div class="col-12">
                <table class="table modal-table">
                    <tr role="row">
                        <th>{{__('Employee')}}</th>
                        <td>{{ !empty($employee->name)?$employee->name:'' }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Excuse Date')}}</th>
                        <td>{{ \Auth::user()->dateFormat($excuse->excuse_date) }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Duration')}}</th>
                        <td>{{ $excuse->duration }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Reason')}}</th>
                        <td>{{ !empty($excuse->reason)?$excuse->reason:'' }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Status')}}</th>
                        <td>{{ !empty($excuse->status)?$excuse->status:'' }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Remark')}}</th>
                        <td>{{ !empty($excuse->remark)?$excuse->remark:'' }}</td>
                    </tr>
                    <input type="hidden" value="{{ $approval->id }}" name="approval_id">
                </table>
        </div>
    </div>
</div>
@can('approve excuse')
<div class="modal-footer">
    <input type="submit" value="{{__('Approve')}}" class="btn btn-success" data-bs-dismiss="modal" name="action">
    <input type="submit" value="{{__('Reject')}}" class="btn btn-danger" name="action">
</div>
@endcan
{{Form::close()}} 