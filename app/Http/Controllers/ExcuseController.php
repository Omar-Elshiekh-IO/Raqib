<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Excuse;
use App\Models\ExcuseApproval;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExcuseController extends Controller
{
  public function index()
  {
    if (Auth::user()->can('view excuse')) {
      if (Auth::user()->type == 'company' || Auth::user()->type == 'HR') {
        $employeeIds = User::where('created_by',Auth::user()->creatorId())->pluck('id');
        $excuses = Excuse::whereIn('created_by', $employeeIds)->with('employee')->get();
        // $excusesBySelf = Excuse::where('created_by', Auth::user()->creatorId())->with('employee')->get();
        // $excuses = $excuses->merge($excusesBySelf);
      } else {
        // For managers, show only pending approvals for them
        $pendingApprovals = ExcuseApproval::where('approver_id', Auth::id())
          ->where('status', 'pending')
          ->with('excuse.employee')
          ->get();

        // For employees, show their own excuses
        $employee = Employee::where('user_id', Auth::user()->id)->first();
        if (!$employee) {
          return redirect()->back()->with('error', __('Employee not found.'));
        }
        $excuses = Excuse::where('employee_id', $employee->id)->with('employee')->get();

        return view('excuse.index', compact('excuses', 'pendingApprovals'));
      }
      return view('excuse.index', compact('excuses'));
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function create()
  {
    if (Auth::user()->can('create excuse')) {
      $employee_id = 0;
      if (Auth::user()->type == 'company' || Auth::user()->type == 'HR') {
        $employees = Employee::where('created_by', Auth::user()->creatorId())
          ->get()
          ->mapWithKeys(fn($employee) => [$employee->id => '#' . $employee->id . ' - ' . $employee->name])
          ->toArray();
      } else {
        $employees = Employee::where('user_id', Auth::user()->id)
          ->get()
          ->mapWithKeys(fn($employee) => [$employee->id => '#' . $employee->id . ' - ' . $employee->name])
          ->toArray();
        $employee = Auth::user()->employee;
        $employee_id = isset($employee) ? $employee->id : null;
      }
      $statuses = ['Pending' => 'Pending', 'Approved' => 'Approved', 'Rejected' => 'Rejected', 'Canceled' => 'Canceled'];
      return view('excuse.create', compact('employees', 'employee_id', 'statuses'));
    } else {
      return response()->json(['error' => __('Permission denied.')], 401);
    }
  }

  public function store(Request $request)
  {
    if (Auth::user()->can('create excuse')) {
      $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'excuse_date' => 'required|date',
        'duration' => 'required|integer|min:5',
        'reason' => 'required',
        'status' => 'in:Pending,Approved,Rejected,Canceled',
        'remark' => 'nullable|string',
        'with_deduction' => 'boolean',
        'deduction_amount' => 'nullable|numeric|min:0|required_if:with_deduction,1'
      ]);

      $excuse = Excuse::create([
        'employee_id' => $request->employee_id,
        'excuse_date' => $request->excuse_date,
        'duration' => $request->duration,
        'reason' => $request->reason,
        'status' => $request->status ?? 'Pending',
        'remark' => $request->remark ?? null,
        'created_by' => Auth::id(),
        'with_deduction' => $request->with_deduction ?? false,
        'deduction_amount' => $request->deduction_amount
      ]);

      // Get the employee who submitted the request
      $employee = Employee::find($request->employee_id);

      // Create only the first approval for the direct manager
      if ($employee && $employee->manager) {
        ExcuseApproval::create([
          'excuse_id' => $excuse->id,
          'approver_id' => $employee->manager->user_id, // Use user_id of the manager
          'status' => 'pending',
        ]);
      }

      return to_route('excuse.index')->with('success', __('Excuse created successfully.'));
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function edit(Excuse $excuse)
  {
    if (Auth::user()->can('edit excuse')) {
      if ($excuse->created_by == Auth::user()->creatorId()) {
        if (Auth::user()->type == 'company' || Auth::user()->type == 'HR') {
          $employees = Employee::where('created_by', Auth::user()->creatorId())
            ->get()
            ->mapWithKeys(fn($employee) => [$employee->id => '#' . $employee->id . ' - ' . $employee->name])
            ->toArray();
        } else {
          $employees = Employee::where('user_id', Auth::user()->id)
            ->get()
            ->mapWithKeys(fn($employee) => [$employee->id => '#' . $employee->id . ' - ' . $employee->name])
            ->toArray();
        }
        $statuses = ['Pending' => 'Pending', 'Approved' => 'Approved', 'Rejected' => 'Rejected', 'Canceled' => 'Canceled'];
        return view('excuse.edit', [
          'excuse' => $excuse,
          'employees' => $employees,
          'statuses' => $statuses
        ]);
      } else {
        return response()->json(['error' => __('Permission denied.'), 401]);
      }
    } else {
      return response()->json(['error' => __('Permission denied.'), 401]);
    }
  }

  public function update(Request $request, Excuse $excuse)
  {
    if (Auth::user()->can('edit excuse')) {
      if ($excuse->created_by == Auth::user()->creatorId()) {
        $request->validate([
          'employee_id' => 'required|exists:employees,id',
          'excuse_date' => 'required|date',
          'duration' => 'required|integer|min:5',
          'reason' => 'required',
          'status' => 'in:Pending,Approved,Rejected,Canceled',
          'remark' => 'nullable|string',
        ]);
        $excuse->update([
          'employee_id' => $request->employee_id,
          'excuse_date' => $request->excuse_date,
          'duration' => $request->duration,
          'end_time' => $request->end_time,
          'reason' => $request->reason,
          'status' => $request->status ?? 'Pending',
          'remark' => $request->remark ?? null,
        ]);
        return to_route('excuse.index')->with('success', __('Excuse successfully updated'));
      } else {
        return redirect()->back()->with('error', __('Permission denied.'));
      }
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function destroy(Excuse $excuse)
  {
    if (Auth::user()->can('delete excuse')) {
      if ($excuse->created_by == Auth::user()->creatorId()) {
        $excuse->delete();
        return to_route('excuse.index')->with('success', __('Excuse deleted successfully.'));
      } else {
        return redirect()->back()->with('error', __('Permission denied.'));
      }
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  // public function approve($approvalId)
  // {
  //   $approval = ExcuseApproval::findOrFail($approvalId);

  //   // Check if the current user is the approver
  //   if ($approval->approver_id != Auth::id()) {
  //     return redirect()->back()->with('error', __('Permission denied.'));
  //   }

  //   $approval->update(['status' => 'approved']);

  //   $settings = Utility::settings();
  //   $countApproval = ExcuseApproval::where('created_by',Auth::user()->creatorId())
  //     ->where('status','approved')
  //     ->where('excuse_id',$approval->excuse_id)
  //     ->count();

  //   if($countApproval == $settings->excuse_levels->value){
  //     $approval->excuse->update(['status' => 'Approved']);
  //     return redirect()->back()->with('success', __('Excuse approved successfully.'));
  //   }

  //   // Get the manager of the current approver
  //   $currentApprover = Employee::where('user_id', $approval->approver_id)->first();
  //   $nextManager = $currentApprover ? $currentApprover->manager : null;

  //   if ($nextManager) {
  //     ExcuseApproval::create([
  //       'excuse_id' => $approval->excuse_id,
  //       'approver_id' => $nextManager->user_id,
  //       'status' => 'pending',
  //     ]);
  //   } else {
  //     // No more managers, mark the excuse as fully approved
  //     $approval->excuse->update(['status' => 'Approved']);
  //   }

  //   return redirect()->back()->with('success', __('Excuse approved successfully.'));
  // }

  // public function reject($approvalId)
  // {
  //   $approval = ExcuseApproval::findOrFail($approvalId);

  //   // Check if the current user is the approver
  //   if ($approval->approver_id != Auth::id()) {
  //     return redirect()->back()->with('error', __('Permission denied.'));
  //   }

  //   $approval->update(['status' => 'rejected']);

  //   // Mark the excuse as rejected
  //   $approval->excuse->update(['status' => 'Rejected']);

  //   return redirect()->back()->with('success', __('Excuse rejected successfully.'));
  // }

  // Action popup method
  public function action($approvalId)
  {
    $approval = ExcuseApproval::findOrFail($approvalId);
    $excuse = $approval->excuse;
    $employee = $excuse->employee;

    return view('excuse.action', compact('employee', 'excuse', 'approval'));
  }

  // Change action method
  public function changeaction(Request $request)
  {
    $approval = ExcuseApproval::findOrFail($request->approval_id);

    // Check if the current user is the approver
    if ($approval->approver_id != Auth::id()) {
      return redirect()->back()->with('error', __('Permission denied.'));
    }

    if ($request->action == 'Approve') {
      $approval->update(['status' => 'approved']);

      $settings = Utility::settings();
      $countApproval = ExcuseApproval::where('status','approved')
        ->where('excuse_id',$approval->excuse_id)
        ->count();


      if($countApproval == $settings['excuse_levels']){
        $approval->excuse->update(['status' => 'Approved']);
        return redirect()->back()->with('success', __('Excuse approved successfully.'));
      }

      // Get the manager of the current approver
      $currentApprover = Employee::where('user_id', $approval->approver_id)->first();
      $nextManager = $currentApprover ? $currentApprover->manager : null;

      if ($nextManager) {
        ExcuseApproval::create([
          'excuse_id' => $approval->excuse_id,
          'approver_id' => $nextManager->user_id,
          'status' => 'pending',
        ]);
      } else {
        // No more managers, mark the excuse as fully approved
        $approval->excuse->update(['status' => 'Approved']);
      }

      return redirect()->route('excuse.index')->with('success', __('Excuse approved successfully.'));
    } else {
      $approval->update(['status' => 'rejected']);
      $approval->excuse->update(['status' => 'Rejected']);

      return redirect()->route('excuse.index')->with('success', __('Excuse rejected successfully.'));
    }
  }
}
