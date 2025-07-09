<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmploymentType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmploymentTypeController extends Controller
{
  public function index()
  {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if ($user->can('manage employment type')) {
      $types = EmploymentType::where('created_by', '=', $user->creatorId())->get();
      return view('employment_type.index', compact('types'));
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function create()
  {
    return view('employment_type.create');
  }

  public function store(Request $request)
  {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if ($user->can('create employment type')) {
      $validator = Validator::make($request->all(), [
        'title' => 'required',
      ]);
      if ($validator->fails()) {
        $messages = $validator->getMessageBag();
        return redirect()->back()->with('error', $messages->first());
      }
      $type = new EmploymentType();
      $type->title = $request->title;
      $type->created_by = $user->creatorId();
      $type->save();
      return redirect()->back()->with('success', __('Employment type successfully created.'));
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function show(EmploymentType $employmentType)
  {
    //
  }

  public function edit(EmploymentType $employmentType)
  {
    return view('employment_type.edit', compact('employmentType'));
  }

  public function update(Request $request, EmploymentType $employmentType)
  {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if ($user->can('edit employment type')) {
      $validator = Validator::make($request->all(), [
        'title' => 'required',
      ]);
      if ($validator->fails()) {
        $messages = $validator->getMessageBag();
        return redirect()->back()->with('error', $messages->first());
      }
      $employmentType->title = $request->title;
      $employmentType->save();
      return redirect()->back()->with('success', __('Employment type successfully updated.'));
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function destroy(EmploymentType $employmentType)
  {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if ($user->can('delete employment type')) {
      if ($employmentType->created_by == $user->creatorId()) {
        $employmentType->delete();
        return redirect()->back()->with('success', __('Employment type successfully deleted.'));
      } else {
        return redirect()->back()->with('error', __('Permission denied.'));
      }
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }
}
