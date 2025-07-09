<?php

namespace App\Http\Controllers;

use App\Models\Utility;
use Illuminate\Http\Request;
use App\Models\WorkShift;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\WorkShiftDays;
use Illuminate\Support\Facades\DB;

class WorkShiftController extends Controller
{
  public function index()
  {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if ($user->can('manage work shift')) {
    $shifts = WorkShift::with('workShiftDays')
    ->where('created_by', $user->creatorId())
    ->get();
    $setting = Utility::settings();
      return view('work_shift.index', compact(['shifts','setting']));
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function create()
  {
    return view('work_shift.create');
  }

  public function store(Request $request)
  {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if ($user->can('create work shift')) {
      $validator = Validator::make($request->all(), [
        'title' => 'required|string',
        'days' => 'required|array|min:1',
        'from' => 'required|date_format:H:i',
        'to' => 'required|date_format:H:i',
      ]);
      if ($validator->fails()) {
        $messages = $validator->getMessageBag();
        return redirect()->back()->with('error', $messages->first());
      }
      DB::transaction(function () use ($request, $user) {
        $workShift = new WorkShift();
        $workShift->title = $request->title;
        $workShift->created_by = $user->creatorId();
        $workShift->from = $request->from;
        $workShift->to = $request->to;
        $workShift->save();
        // Save days as related records
        foreach ($request->days as $day) {
          WorkShiftDays::create([
            'work_shift_id' => $workShift->id,
            'day' => $day,
          ]);
        }
      });
      return redirect()->back()->with('success', __('Work shift successfully created.'));
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function show(WorkShift $workShift)
  {
    // Show single WorkShift
  }

  public function edit(WorkShift $workShift)
  {
    return view('work_shift.edit', compact('workShift'));
  }

  public function update(Request $request, WorkShift $workShift)
  {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if ($user->can('edit work shift')) {
      $validator = Validator::make($request->all(), [
        'title' => 'string',
      ]);
      if ($validator->fails()) {
        $messages = $validator->getMessageBag();
        return redirect()->back()->with('error', $messages->first());
      }
      DB::transaction(function () use ($request, $workShift) {
        $workShift->title = $request->title;
        $workShift->from = $request->from;
        $workShift->to = $request->to;
        $workShift->save();
        // Sync days: delete old, insert new
        if($request->days){
        $workShift->workShiftDays()->delete();
          foreach ($request->days as $day) {
            WorkShiftDays::create([
              'work_shift_id' => $workShift->id,
              'day' => $day,
            ]);
          }
        }
      });
      return redirect()->back()->with('success', __('Work shift successfully updated.'));
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function destroy(WorkShift $workShift)
  {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if ($user->can('delete work shift')) {
      if ($workShift->created_by == $user->creatorId()) {
        $workShift->delete();
        return redirect()->back()->with('success', __('Work shift successfully deleted.'));
      } else {
        return redirect()->back()->with('error', __('Permission denied.'));
      }
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }
}
