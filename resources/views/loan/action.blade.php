{{Form::open(array('url'=>'loan/changeaction','method'=>'post'))}}
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
                        <td>{{ \Auth::user()->dateFormat($loan->loan_date) }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Start Time')}}</th>
                        <td>{{ $loan->start_time }}</td>
                    </tr>
                    <tr>
                        <th>{{__('End Time')}}</th>
                        <td>{{ $loan->end_time }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Reason')}}</th>
                        <td>{{ !empty($loan->reason)?$loan->reason:'' }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Status')}}</th>
                        <td>{{ !empty($loan->status)?$loan->status:'' }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Remark')}}</th>
                        <td>{{ !empty($loan->remark)?$loan->remark:'' }}</td>
                    </tr>
                    <input type="hidden" value="{{ $approval->id }}" name="approval_id">
                </table>
        </div>
    </div>
</div>
@can('approve loan')
<div class="modal-footer">
    <input type="submit" value="{{__('Approve')}}" class="btn btn-success" data-bs-dismiss="modal" name="action">
    <input type="submit" value="{{__('Reject')}}" class="btn btn-danger" name="action">
</div>
@endcan
{{Form::close()}} 