<?php

namespace App\Http\Controllers;

use App\Models\Excuse;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityController extends Controller
{
  public function index()
  {
    if (Auth::user()->can('manage security')) {
      $today = now()->toDateString();
      $employeeIds = User::where('created_by', Auth::user()->creatorId())->pluck('id');
      $leaves = Excuse::where('status', 'Approved')
        ->where('excuse_date', $today)
        ->whereIn('created_by', $employeeIds)
        ->with('employee')->get();
      $leavesBySelf = Excuse::where('created_by', Auth::user()->creatorId())
        ->where('status', 'Approved')
        ->where('excuse_date', $today)
        ->with('employee')->get();
      $leaves = $leaves->merge($leavesBySelf);
      return view('security.index', compact('leaves'));
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

public function markLeave(Request $request, $id)
  {
    if (!Auth::user()->can('manage security')) {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
    $excuse = Excuse::findOrFail($id);
    if ($excuse->actual_leave_time) {
      return redirect()->back()->with('error', __('Already marked as left.'));
    }
    $excuse->actual_leave_time = now();
    $excuse->save();
    return redirect()->back()->with('success', __('Leave time marked.'));
  }
}
