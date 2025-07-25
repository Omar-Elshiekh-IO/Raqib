<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Excuse;
use App\Models\ExcuseApproval;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;


class ExcuseController extends Controller
{
  /**
   * @OA\Get(
   *     path="/api/v1/excuse",
   *     summary="Get a list of excuses",
   *     tags={"Excuses"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Response(
   *         response=200,
   *         description="List of excuses",
   *         @OA\JsonContent(
   *             oneOf={
   *                 @OA\Schema(type="array", @OA\Items(ref="#/components/schemas/Excuse")),
   *                 @OA\Schema(
   *                     type="object",
   *                     @OA\Property(property="excuses", type="array", @OA\Items(ref="#/components/schemas/Excuse")),
   *                 )
   *             }
   *         )
   *     ),
   *     @OA\Response(response=403, description="Permission denied")
   * )
   */
  public function index()
  {
    if (!Auth::user() || !Auth::user()->can('view excuse')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    if (Auth::user()->type == 'company' || Auth::user()->type == 'HR') {
      $employeeIds = User::where('created_by', Auth::user()->creatorId())->pluck('id');
      $excuses = Excuse::whereIn('created_by', $employeeIds)->with('employee')->get();
      // $excusesBySelf = Excuse::where('created_by', Auth::user()->creatorId())->with('employee')->get();
      // $excuses = $excuses->merge($excusesBySelf);
      return response()->json($excuses->values());
    } else {
      // For managers, show only pending approvals for them
      $pendingApprovals = ExcuseApproval::where('approver_id', Auth::id())
        ->where('status', 'pending')
        ->with('excuse.employee')
        ->get();
      // For employees, show their own excuses
      $employee = Employee::where('user_id', Auth::id())->first();
      if (!$employee) {
        return response()->json(['error' => 'Employee not found.'], 404);
      }
      $excuses = Excuse::where('employee_id', $employee->id)->with('employee')->get();
      return response()->json([
        'excuses' => $excuses,
        'pendingApprovals' => $pendingApprovals
      ]);
    }
  }

  /**
   * @OA\Post(
   *     path="/api/v1/excuse/store",
   *     summary="Create a new excuse",
   *     tags={"Excuses"},
   *     security={{"bearerAuth":{}}},
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"employee_id", "excuse_date", "duration", "reason"},
   *             @OA\Property(property="employee_id", type="integer"),
   *             @OA\Property(property="excuse_date", type="string", format="date"),
   *             @OA\Property(property="duration", type="integer", minimum=5),
   *             @OA\Property(property="reason", type="string"),
   *             @OA\Property(property="status", type="string", enum={"Pending", "Approved", "Rejected", "Canceled"}),
   *             @OA\Property(property="remark", type="string", nullable=true),
   *             @OA\Property(property="with_deduction", type="boolean"),
   *             @OA\Property(property="deduction_amount", type="number", format="float", nullable=true)
   *         )
   *     ),
   *     @OA\Response(response=201, description="Excuse created"),
   *     @OA\Response(response=403, description="Permission denied")
   * )
   */
  public function store(Request $request)
  {
    if (!Auth::user() || !Auth::user()->can('create excuse')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
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
    $employee = Employee::find($request->employee_id);
    if ($employee && $employee->manager) {
      ExcuseApproval::create([
        'excuse_id' => $excuse->id,
        'approver_id' => $employee->manager->user_id,
        'status' => 'pending',
      ]);
    }
    return response()->json($excuse->load(['employee', 'approvals']), 201);
  }

  /**
   * @OA\Get(
   *     path="/api/v1/excuse/{id}",
   *     summary="Get a specific excuse",
   *     tags={"Excuses"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="Excuse ID",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\Response(response=200, description="Excuse data"),
   *     @OA\Response(response=404, description="Not found")
   * )
   */
  public function show(Excuse $excuse)
  {
    return response()->json($excuse->load(['employee', 'approvals']));
  }

  /**
   * @OA\Put(
   *     path="/api/v1/excuse/{id}",
   *     summary="Update an existing excuse",
   *     tags={"Excuses"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="Excuse ID",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"employee_id", "excuse_date", "duration", "reason"},
   *             @OA\Property(property="employee_id", type="integer"),
   *             @OA\Property(property="excuse_date", type="string", format="date"),
   *             @OA\Property(property="duration", type="integer", minimum=5),
   *             @OA\Property(property="reason", type="string"),
   *             @OA\Property(property="status", type="string", enum={"Pending", "Approved", "Rejected", "Canceled"}),
   *             @OA\Property(property="remark", type="string", nullable=true)
   *         )
   *     ),
   *     @OA\Response(response=200, description="Excuse updated"),
   *     @OA\Response(response=403, description="Permission denied")
   * )
   */
  public function update(Request $request, Excuse $excuse)
  {
    if (!Auth::user() || !Auth::user()->can('edit excuse')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    if ($excuse->created_by != Auth::user()->creatorId()) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
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
    return response()->json($excuse->load(['employee', 'approvals']));
  }

  /**
   * @OA\Delete(
   *     path="/api/v1/excuse/{id}",
   *     summary="Delete an excuse",
   *     tags={"Excuses"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="Excuse ID",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\Response(response=200, description="Deleted successfully"),
   *     @OA\Response(response=403, description="Permission denied")
   * )
   */
  public function destroy(Request $request, Excuse $excuse)
  {
    if (!Auth::user() || !Auth::user()->can('delete excuse')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    if ($excuse->created_by != Auth::user()->creatorId()) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    $excuse->delete();
    return response()->json(['message' => 'Deleted successfully']);
  }

  /**
   * @OA\Put(
   *     path="/api/v1/excuse/{id}/approve",
   *     summary="Approve an excuse request",
   *     tags={"Excuses"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="Approval ID",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"action"},
   *             @OA\Property(property="action", type="string", enum={"approve"}, example="approve")
   *         )
   *     ),
   *     @OA\Response(response=200, description="Excuse approved"),
   *     @OA\Response(response=403, description="Permission denied")
   * )
   */

  /**
   * @OA\Put(
   *     path="/api/v1/excuse/{id}/reject",
   *     summary="Reject an excuse request",
   *     tags={"Excuses"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="Approval ID",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"action"},
   *             @OA\Property(property="action", type="string", enum={"reject"}, example="reject")
   *         )
   *     ),
   *     @OA\Response(response=200, description="Excuse rejected"),
   *     @OA\Response(response=403, description="Permission denied")
   * )
   */

  public function action(Request $request, $id)
  {
    if (!Auth::user() || !Auth::user()->can('approve excuse')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    $approval = ExcuseApproval::findOrFail($id);
    if ($approval->approver_id != Auth::id()) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    $action = $request->input('action', 'approve');
    if ($action === 'approve') {
      $approval->update(['status' => 'approved']);
      $settings = Utility::settings();
      $countApproval = ExcuseApproval::where('status', 'approved')
        ->where('excuse_id', $approval->excuse_id)
        ->count();
      if ($countApproval == $settings['excuse_levels']) {
        $approval->excuse->update(['status' => 'Approved']);
        return response()->json(['message' => 'Excuse fully approved.']);
      }
      $currentApprover = Employee::where('user_id', $approval->approver_id)->first();
      $nextManager = $currentApprover ? $currentApprover->manager : null;
      if ($nextManager) {
        ExcuseApproval::create([
          'excuse_id' => $approval->excuse_id,
          'approver_id' => $nextManager->user_id,
          'status' => 'pending',
        ]);
        return response()->json(['message' => 'Excuse approved, next manager assigned.']);
      } else {
        $approval->excuse->update(['status' => 'Approved']);
        return response()->json(['message' => 'Excuse fully approved.']);
      }
    } else {
      $approval->update(['status' => 'rejected']);
      $approval->excuse->update(['status' => 'Rejected']);
      return response()->json(['message' => 'Excuse rejected.']);
    }
  }

  /**
   * @OA\Get(
   *     path="/api/v1/excuse/pending-approvals",
   *     summary="Get pending excuse approvals for current user",
   *     tags={"Excuses"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Response(
   *         response=200,
   *         description="List of pending approvals",
   *     ),
   *     @OA\Response(response=403, description="Permission denied")
   * )
   */
  public function pendingApprovals()
  {
    if (!Auth::user() || !Auth::user()->can('manage excuse')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    $pendingApprovals = ExcuseApproval::where('approver_id', Auth::id())
      ->where('status', 'pending')
      ->with('excuse.employee')
      ->get();
    return response()->json($pendingApprovals);
  }
}
