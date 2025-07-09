<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Excuse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExcuseController extends Controller
{
  public function index()
  {
    if (Auth::user()->can('manage excuse')) {
      if (Auth::user()->type == 'company' || Auth::user()->type == 'HR') {
        $excuses = Excuse::where('created_by', Auth::user()->creatorId())->with('employee')->get();
      } else {
        $employee = Employee::where('employee_id', Auth::user()->id)->first();
        if (!$employee) {
          return redirect()->back()->with('error', __('Employee not found.'));
        }
        $excuses = Excuse::where('employee_id', $employee->id)->with('employee')->get();
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
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'reason' => 'required',
        'status' => 'in:Pending,Approved,Rejected,Canceled',
        'remark' => 'nullable|string',
        'with_deduction' => 'nullable|boolean',
        'deduction_amount' => 'nullable|numeric|min:0|required_id:with_deduction,1'
      ]);
      Excuse::create([
        'employee_id' => $request->employee_id,
        'excuse_date' => $request->excuse_date,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'reason' => $request->reason,
        'status' => $request->status ?? 'Pending',
        'remark' => $request->remark ?? null,
        'created_by' => Auth::id(),
        'with_deduction' => $request->with_deduction,
        'deduction_amount' => $request->deduction_amount
      ]);
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
          'start_time' => 'required|date_format:H:i',
          'end_time' => 'required|date_format:H:i|after:start_time',
          'reason' => 'required',
          'status' => 'in:Pending,Approved,Rejected,Canceled',
          'remark' => 'nullable|string',
        ]);
        $excuse->update([
          'employee_id' => $request->employee_id,
          'excuse_date' => $request->excuse_date,
          'start_time' => $request->start_time,
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
}
