<?php

namespace App\Http\Controllers;

use App\Models\BusinessMission;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessMissionController extends Controller
{
  public function index()
  {

    if (Auth::user()->can('manage business mission')) {
      if (Auth::user()->type == 'company' || Auth::user()->type == 'HR') {
        $businessMissions = BusinessMission::where('created_by', Auth::user()->creatorId())->with('employee')->get();
      } else {
        $employee = Employee::where('employee_id', Auth::user()->id)->first();
        if (!$employee) {
          return redirect()->back()->with('error', __('Employee not found.'));
        }
        $businessMissions = BusinessMission::where('employee_id', $employee->id)->with('employee')->get();
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

      BusinessMission::create([
        'employee_id' => $request->employee_id,
        'title' => $request->title,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'description' => $request->description,
        'remark' => $request->remark ?? null,
        'created_by' => Auth::id(),
      ]);

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
}
