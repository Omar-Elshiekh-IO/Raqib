<?php

namespace App\Http\Controllers;

use App\Models\BusinessMission;
use App\Models\BusinessMissionApproval;
use App\Models\Employee;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BusinessMissionController extends Controller
{
  public function index()
  {
    if (Auth::user()->can('view business mission')) {
      if (Auth::user()->type == 'company' || Auth::user()->type == 'HR') {
        $employeeIds = User::where('created_by',Auth::user()->creatorId())->pluck('id');
        $businessMissions = BusinessMission::whereIn('created_by', $employeeIds)->with('employee')->get();
        $businessMissionsBySelf = BusinessMission::where('created_by', Auth::user()->creatorId())->with('employee')->get();
        $businessMissions = $businessMissions->merge($businessMissionsBySelf);
      } else {
        // For managers, show only pending approvals for them
        $pendingApprovals = BusinessMissionApproval::where('approver_id', Auth::id())
          ->where('status', 'pending')
          ->with('businessMission.employee')
          ->get();

        // For employees, show their own business missions
        $employee = Employee::where('user_id', Auth::user()->id)->first();
        if (!$employee) {
          return redirect()->back()->with('error', __('Employee not found.'));
        }
        $businessMissions = BusinessMission::where('employee_id', $employee->id)->with('employee')->get();

        return view('businessmission.index', compact('businessMissions', 'pendingApprovals'));
      }

      return view('businessmission.index', compact('businessMissions'));
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function show() {}

  public function create()
  {
    if (Auth::user()->can('create business mission')) {
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
      return view('businessmission.create', compact('employees', 'employee_id'));
    } else {
      return response()->json(['error' => __('Permission denied.')], 401);
    }
  }

  public function store(Request $request)
  {
    if (Auth::user()->can('create business mission')) {
      $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'title' => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'description' => 'required',
        'remark' => 'nullable|max:255'
      ]);

      $businessMission = BusinessMission::create([
        'employee_id' => $request->employee_id,
        'title' => $request->title,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'description' => $request->description,
        'remark' => $request->remark ?? null,
        'created_by' => Auth::id(),
      ]);

      // Get the employee who submitted the request
      $employee = Employee::find($request->employee_id);

      // Create only the first approval for the direct manager
      if ($employee && $employee->manager) {
        BusinessMissionApproval::create([
          'business_mission_id' => $businessMission->id,
          'approver_id' => $employee->manager->user_id, // Use user_id of the manager
          'status' => 'pending',
        ]);
      }

      return to_route('business-mission.index')->with('success', __('Business Mission created successfully.'));
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function edit(BusinessMission $businessMission)
  {
    if (Auth::user()->can('edit business mission')) {
      if ($businessMission->created_by == Auth::user()->creatorId()) {
        // Get employees list for the select dropdown, similar to create()
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
        return view('businessmission.edit', [
          'businessMission' => $businessMission,
          'employees' => $employees
        ]);
      } else {
        return response()->json(['error' => __('Permission denied.'), 401]);
      }
    } else {
      return response()->json(['error' => __('Permission denied.'), 401]);
    }
  }

  public function update(Request $request, BusinessMission $businessMission)
  {
    if (Auth::user()->can('edit business mission')) {
      if ($businessMission->created_by == Auth::user()->creatorId()) {
        $request->validate([
          'employee_id' => 'required|exists:employees,id',
          'title' => 'required|string|max:255',
          'start_date' => 'required|date',
          'end_date' => 'required|date|after_or_equal:start_date',
          'description' => 'required',
          'remark' => 'nullable|max:255',
          'status' => 'in:Pending,Approved,In_Progress,Completed,Canceled'
        ]);

        $businessMission->update([
          'employee_id' => $request->employee_id,
          'title' => $request->title,
          'start_date' => $request->start_date,
          'end_date' => $request->end_date,
          'description' => $request->description,
          'remark' => $request->remark ?? null,
          'status' => $request->status,
        ]);

        return to_route('business-mission.index')->with('success', __('Business mission successfully updated'));
      } else {
        return redirect()->back()->with('error', __('Permission denied.'));
      }
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function destroy(BusinessMission $businessMission)
  {
    if (Auth::user()->can('delete business mission')) {
      if ($businessMission->created_by == Auth::user()->creatorId()) {
        $businessMission->delete();
        return to_route('business-mission.index')->with('success', __('Business Mission deleted successfully.'));
      } else {
        return redirect()->back()->with('error', __('Permission denied.'));
      }
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  // public function approve($approvalId)
  // {
  //   $approval = BusinessMissionApproval::findOrFail($approvalId);

  //   // Check if the current user is the approver
  //   if ($approval->approver_id != Auth::id()) {
  //     return redirect()->back()->with('error', __('Permission denied.'));
  //   }

  //   $approval->update(['status' => 'approved']);

  //   // Get the manager of the current approver
  //   $currentApprover = Employee::where('user_id', $approval->approver_id)->first();
  //   $nextManager = $currentApprover ? $currentApprover->manager : null;

  //   if ($nextManager) {
  //     // Create approval for the next manager
  //     BusinessMissionApproval::create([
  //       'business_mission_id' => $approval->business_mission_id,
  //       'approver_id' => $nextManager->user_id,
  //       'status' => 'pending',
  //     ]);
  //   } else {
  //     // No more managers, mark the business mission as fully approved
  //     $approval->businessMission->update(['status' => 'Approved']);
  //   }

  //   return redirect()->back()->with('success', __('Business Mission approved successfully.'));
  // }

  // public function reject($approvalId)
  // {
  //   $approval = BusinessMissionApproval::findOrFail($approvalId);

  //   // Check if the current user is the approver
  //   if ($approval->approver_id != Auth::id()) {
  //     return redirect()->back()->with('error', __('Permission denied.'));
  //   }

  //   $approval->update(['status' => 'rejected']);

  //   // Mark the business mission as rejected
  //   $approval->businessMission->update(['status' => 'Rejected']);

  //   return redirect()->back()->with('success', __('Business Mission rejected successfully.'));
  // }

  public function action($approvalId)
  {
    $approval = BusinessMissionApproval::findOrFail($approvalId);
    $businessMission = $approval->businessMission;
    $employee = $businessMission->employee;

    return view('businessmission.action', compact('employee', 'businessMission', 'approval'));
  }

  public function changeaction(Request $request)
  {
    $approval = BusinessMissionApproval::findOrFail($request->approval_id);

    // Check if the current user is the approver
    if ($approval->approver_id != Auth::id()) {
      return redirect()->back()->with('error', __('Permission denied.'));
    }

    if ($request->action == 'Approve') {
      $approval->update(['status' => 'approved']);

      $settings = Utility::settings();
      $countApproval = BusinessMissionApproval::where('status','approved')
        ->where('business_mission_id',$approval->business_mission_id)
        ->count();


      if($countApproval == $settings['business_mission_levels']){
        $approval->business_mission->update(['status' => 'Approved']);
        return redirect()->back()->with('success', __('Business Mission approved successfully.'));
      }

      // Get the manager of the current approver
      $currentApprover = Employee::where('user_id', $approval->approver_id)->first();
      $nextManager = $currentApprover ? $currentApprover->manager : null;

      if ($nextManager) {
        // Create approval for the next manager
        BusinessMissionApproval::create([
          'business_mission_id' => $approval->business_mission_id,
          'approver_id' => $nextManager->user_id,
          'status' => 'pending',
        ]);
      } else {
        // No more managers, mark the business mission as fully approved
        $approval->businessMission->update(['status' => 'Approved']);
      }

      return redirect()->route('business-mission.index')->with('success', __('Business Mission approved successfully.'));
    } else {
      $approval->update(['status' => 'rejected']);
      $approval->businessMission->update(['status' => 'Rejected']);

      return redirect()->route('business-mission.index')->with('success', __('Business Mission rejected successfully.'));
    }
  }
}
