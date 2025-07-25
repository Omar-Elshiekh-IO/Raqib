{{Form::open(array('url'=>'leave/changeaction','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        <div class="col-12">
                <table class="table modal-table">
                    <tr role="row">
                        <th>{{__('Employee')}}</th>
                        <td>{{ !empty($employee->name)?$employee->name:'' }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Leave Type ')}}</th>
                        <td>{{ !empty($leavetype->title)?$leavetype->title:'' }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Appplied On')}}</th>
                        <td>{{\Auth::user()->dateFormat( $leave->applied_on) }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Start Date')}}</th>
                        <td>{{ \Auth::user()->dateFormat($leave->start_date) }}</td>
                    </tr>
                    <tr>
                        <th>{{__('End Date')}}</th>
                        <td>{{ \Auth::user()->dateFormat($leave->end_date) }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Leave Reason')}}</th>
                        <td>{{ !empty($leave->leave_reason)?$leave->leave_reason:'' }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Status')}}</th>
                        <td>{{ !empty($leave->status)?$leave->status:'' }}</td>
                    </tr>
                    @if(isset($approval))
                        <input type="hidden" value="{{ $approval->id }}" name="approval_id">
                    @else
                        <input type="hidden" value="{{ $leave->id }}" name="leave_id">
                    @endif
                </table>
        </div>
    </div>
</div>
@can('manage leave')
<div class="modal-footer">
    <input type="submit" value="{{__('Approve')}}" class="btn btn-success" data-bs-dismiss="modal" name="action">
    <input type="submit" value="{{__('Reject')}}" class="btn btn-danger" name="action">
</div>
@endcan
{{Form::close()}}
