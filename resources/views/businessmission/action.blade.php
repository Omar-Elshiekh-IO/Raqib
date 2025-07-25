{{Form::open(array('url'=>'business-mission/changeaction','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        <div class="col-12">
                <table class="table modal-table">
                    <tr role="row">
                        <th>{{__('Employee')}}</th>
                        <td>{{ !empty($employee->name)?$employee->name:'' }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Mission Title')}}</th>
                        <td>{{ !empty($businessMission->title)?$businessMission->title:'' }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Start Date')}}</th>
                        <td>{{ \Auth::user()->dateFormat($businessMission->start_date) }}</td>
                    </tr>
                    <tr>
                        <th>{{__('End Date')}}</th>
                        <td>{{ \Auth::user()->dateFormat($businessMission->end_date) }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Description')}}</th>
                        <td>{{ !empty($businessMission->description)?$businessMission->description:'' }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Status')}}</th>
                        <td>{{ !empty($businessMission->status)?$businessMission->status:'' }}</td>
                    </tr>
                    <tr>
                        <th>{{__('Remark')}}</th>
                        <td>{{ !empty($businessMission->remark)?$businessMission->remark:'' }}</td>
                    </tr>
                    <input type="hidden" value="{{ $approval->id }}" name="approval_id">
                </table>
        </div>
    </div>
</div>
@if(\Auth::user()->type == 'company' || \Auth::user()->type == 'HR' || \Auth::user()->type == 'Employee')
<div class="modal-footer">
    <input type="submit" value="{{__('Approve')}}" class="btn btn-success" data-bs-dismiss="modal" name="action">
    <input type="submit" value="{{__('Reject')}}" class="btn btn-danger" name="action">
</div>
@endif
{{Form::close()}} 