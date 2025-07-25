<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;
use App\Models\LeaveApproval;
use App\Models\Employee;
use App\Models\User;
use App\Models\LeaveType;
use App\Models\Utility;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;


class LeaveController extends Controller
{
  /**
 * @OA\Get(
 *     path="/api/v1/leave",
 *     summary="List leaves",
 *     tags={"Leaves"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Successful response",
 *         @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                     type="array",
 *                     @OA\Items(ref="#/components/schemas/Leave")
 *                 ),
 *                 @OA\Schema(
 *                     type="object",
 *                     @OA\Property(property="leaves", type="array", @OA\Items(ref="#/components/schemas/Leave")),
 *                 )
 *             }
 *         )
 *     ),
 *     @OA\Response(response=403, description="Permission denied")
 * )
 */
  public function index()
  {
    if (!Auth::user() || !Auth::user()->can('view leave')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    if (Auth::user()->type == 'company' || Auth::user()->type == 'HR') {
      $leaves = Leave::where('created_by', '=', Auth::user()->creatorId())->with(['leaveType', 'employees'])->get();
      return response()->json($leaves);
    } else {
      $pendingApprovals = LeaveApproval::where('approver_id', Auth::user()->id)
        ->where('status', 'pending')
        ->with('leave.employee')
        ->get();
      $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
      if (!$employee) {
        return response()->json(['error' => 'Employee not found.'], 404);
      }
      $leaves = Leave::where('employee_id', '=', $employee->id)->with(['leaveType', 'employees'])->get();
      return response()->json([
        'leaves' => $leaves,
        'pendingApprovals' => $pendingApprovals
      ]);
    }
  }

  /**
 * @OA\Post(
 *     path="/api/v1/leave/store",
 *     summary="Create a new leave request",
 *     tags={"Leaves"},
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"leave_type_id","start_date","end_date","leave_reason","remark"},
 *             @OA\Property(property="leave_type_id", type="integer"),
 *             @OA\Property(property="start_date", type="string", format="date"),
 *             @OA\Property(property="end_date", type="string", format="date"),
 *             @OA\Property(property="leave_reason", type="string"),
 *             @OA\Property(property="remark", type="string"),
 *             @OA\Property(property="with_deduction", type="boolean"),
 *             @OA\Property(property="deduction_amount", type="number", format="float"),
 *             @OA\Property(property="start_deduction_date", type="string", format="date", nullable=true),
 *             @OA\Property(property="end_deduction_date", type="string", format="date", nullable=true)
 *         )
 *     ),
 *     @OA\Response(response=201, description="Leave created"),
 *     @OA\Response(response=403, description="Permission denied"),
 *     @OA\Response(response=422, description="Validation error")
 * )
 */
  public function store(Request $request)
  {
    if (!Auth::user() || !Auth::user()->can('create leave')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    $request->validate([
      'leave_type_id' => 'required|exists:leave_types,id',
      'start_date' => 'required|date',
      'end_date' => 'required|date|after_or_equal:start_date',
      'leave_reason' => 'required',
      'remark' => 'required',
      'with_deduction' => 'nullable|boolean',
      'deduction_amount' => 'nullable|numeric|min:0|required_if:with_deduction,1',
      'start_deduction_date' => 'nullable|date',
      'end_deduction_date' => 'nullable|date|after_or_equal:start_deduction_date',
    ]);
    $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
    $leave_type = LeaveType::find($request->leave_type_id);
    $startDate = new \DateTime($request->start_date);
    $endDate = new \DateTime($request->end_date);
    $endDate->add(new \DateInterval('P1D'));
    $total_leave_days = !empty($startDate->diff($endDate)) ? $startDate->diff($endDate)->days : 0;
    if ($leave_type->days < $total_leave_days) {
      return response()->json(['error' => 'Leave days exceed allowed for this type.'], 422);
    }
    $leave = new Leave();
    if (Auth::user()->type == 'company' || Auth::user()->type == 'HR') {
      $leave->employee_id = $request->employee_id;
    } else {
      $leave->employee_id = $employee->id;
    }
    $leave->leave_type_id = $request->leave_type_id;
    $leave->applied_on = date('Y-m-d');
    $leave->start_date = $request->start_date;
    $leave->end_date = $request->end_date;
    $leave->total_leave_days = $total_leave_days;
    $leave->leave_reason = $request->leave_reason;
    $leave->remark = $request->remark;
    $leave->status = 'Pending';
    $leave->created_by = Auth::user()->creatorId();
    $leave->with_deduction = $request->with_deduction ? 1 : 0;
    $leave->deduction_amount = $request->with_deduction ? $request->deduction_amount : null;
    $leave->start_deduction_date = $request->with_deduction ? $request->start_deduction_date . '-01' : null;
    $leave->end_deduction_date = $request->with_deduction ? $request->end_deduction_date . '-01' : null;
    if ($request->with_deduction && $request->start_deduction_date && $request->end_deduction_date) {
      $start = new \DateTime($request->start_deduction_date);
      $end = new \DateTime($request->end_deduction_date);
      $months = (($end->format('Y') - $start->format('Y')) * 12) + ($end->format('m') - $start->format('m')) + 1;
      $leave->total_deduction_months = $months;
    } else {
      $leave->total_deduction_months = null;
    }
    $leave->save();
    $requestEmployee = Employee::find($leave->employee_id);
    if ($requestEmployee && $requestEmployee->manager) {
      LeaveApproval::create([
        'leave_id' => $leave->id,
        'approver_id' => $requestEmployee->manager->user_id,
        'status' => 'pending',
      ]);
    }
    return response()->json($leave->load(['employee', 'leaveType', 'approvals']), 201);
  }

  /**
 * @OA\Get(
 *     path="/api/v1/leave/{id}",
 *     summary="Get a specific leave",
 *     tags={"Leaves"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Leave ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Leave returned", @OA\JsonContent(ref="#/components/schemas/Leave")),
 *     @OA\Response(response=404, description="Not found")
 * )
 */
  public function show(Leave $leave)
  {
    return response()->json($leave->load(['employee', 'leaveType', 'approvals']));
  }

  /**
 * @OA\Put(
 *     path="/api/v1/leave/{id}",
 *     summary="Update a leave",
 *     tags={"Leaves"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Leave ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"leave_type_id","start_date","end_date","leave_reason","remark"},
 *             @OA\Property(property="leave_type_id", type="integer"),
 *             @OA\Property(property="start_date", type="string", format="date"),
 *             @OA\Property(property="end_date", type="string", format="date"),
 *             @OA\Property(property="leave_reason", type="string"),
 *             @OA\Property(property="remark", type="string"),
 *             @OA\Property(property="with_deduction", type="boolean"),
 *             @OA\Property(property="deduction_amount", type="number", format="float"),
 *             @OA\Property(property="start_deduction_date", type="string", format="date", nullable=true),
 *             @OA\Property(property="end_deduction_date", type="string", format="date", nullable=true)
 *         )
 *     ),
 *     @OA\Response(response=200, description="Leave updated", @OA\JsonContent(ref="#/components/schemas/Leave")),
 *     @OA\Response(response=403, description="Permission denied"),
 *     @OA\Response(response=422, description="Validation error")
 * )
 */
  public function update(Request $request, Leave $leave)
  {
    if (!Auth::user() || !Auth::user()->can('edit leave')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    if ($leave->created_by != Auth::user()->creatorId()) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    $request->validate([
      'leave_type_id' => 'required|exists:leave_types,id',
      'start_date' => 'required|date',
      'end_date' => 'required|date|after_or_equal:start_date',
      'leave_reason' => 'required',
      'remark' => 'required',
      'with_deduction' => 'nullable|boolean',
      'deduction_amount' => 'nullable|numeric|min:0|required_if:with_deduction,1',
      'start_deduction_date' => 'nullable|date',
      'end_deduction_date' => 'nullable|date|after_or_equal:start_deduction_date',
    ]);
    $leave_type = LeaveType::find($request->leave_type_id);
    $startDate = new \DateTime($request->start_date);
    $endDate = new \DateTime($request->end_date);
    $endDate->add(new \DateInterval('P1D'));
    $total_leave_days = !empty($startDate->diff($endDate)) ? $startDate->diff($endDate)->days : 0;
    if ($leave_type->days < $total_leave_days) {
      return response()->json(['error' => 'Leave days exceed allowed for this type.'], 422);
    }
    $leave->employee_id = $request->employee_id;
    $leave->leave_type_id = $request->leave_type_id;
    $leave->start_date = $request->start_date;
    $leave->end_date = $request->end_date;
    $leave->total_leave_days = $total_leave_days;
    $leave->leave_reason = $request->leave_reason;
    $leave->remark = $request->remark;
    $leave->with_deduction = $request->with_deduction ? 1 : 0;
    $leave->deduction_amount = $request->with_deduction ? $request->deduction_amount : null;
    $leave->start_deduction_date = $request->with_deduction ? $request->start_deduction_date . '-01' : null;
    $leave->end_deduction_date = $request->with_deduction ? $request->end_deduction_date . '-01' : null;
    if ($request->with_deduction && $request->start_deduction_date && $request->end_deduction_date) {
      $start = new \DateTime($request->start_deduction_date);
      $end = new \DateTime($request->end_deduction_date);
      $months = (($end->format('Y') - $start->format('Y')) * 12) + ($end->format('m') - $start->format('m')) + 1;
      $leave->total_deduction_months = $months;
    } else {
      $leave->total_deduction_months = null;
    }
    $leave->save();
    return response()->json($leave->load(['employee', 'leaveType', 'approvals']));
  }

  /**
 * @OA\Delete(
 *     path="/api/v1/leave/{id}",
 *     summary="Delete a leave",
 *     tags={"Leaves"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Leave ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Deleted successfully"),
 *     @OA\Response(response=403, description="Permission denied")
 * )
 */
  public function destroy(Request $request, Leave $leave)
  {
    if (!Auth::user() || !Auth::user()->can('delete leave')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    if ($leave->created_by != Auth::user()->creatorId()) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    $leave->delete();
    return response()->json(['message' => 'Deleted successfully']);
  }

/**
 * @OA\Put(
 *     path="/api/v1/leave/{id}/approve",
 *     summary="Approve a leave request",
 *     tags={"Leaves"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Leave approval ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="action", type="string", enum={"approve"}, example="approve")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Leave approved or next approver assigned"),
 *     @OA\Response(response=403, description="Permission denied")
 * )
 */

/**
 * @OA\Put(
 *     path="/api/v1/leave/{id}/reject",
 *     summary="Reject a leave request",
 *     tags={"Leaves"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Leave approval ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="action", type="string", enum={"reject"}, example="reject")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Leave rejected"),
 *     @OA\Response(response=403, description="Permission denied")
 * )
 */

  public function action(Request $request, $id)
  {
    if (!Auth::user() || !Auth::user()->can('approve leave')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    $approval = LeaveApproval::findOrFail($id);
    if ($approval->approver_id != Auth::user()->id) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    $action = $request->input('action', 'approve');
    if ($action === 'approve') {
      $approval->update(['status' => 'approved']);
      $settings = Utility::settings();
      $countApproval = LeaveApproval::where('status','approved')
          ->where('leave_id',$approval->leave_id)
          ->count();
      if ($countApproval == $settings['leave_levels']) {
        $approval->leave->update(['status' => 'Approved']);
        return response()->json(['message' => 'Leave fully approved.']);
      }
      $currentApprover = Employee::where('user_id', $approval->approver_id)->first();
      $nextManager = $currentApprover ? $currentApprover->manager : null;
      if ($nextManager) {
        LeaveApproval::create([
          'leave_id' => $approval->leave_id,
          'approver_id' => $nextManager->user_id,
          'status' => 'pending',
        ]);
        return response()->json(['message' => 'Leave approved, next manager assigned.']);
      } else {
        $approval->leave->update(['status' => 'Approved']);
        return response()->json(['message' => 'Leave fully approved.']);
      }
    } else {
      $approval->update(['status' => 'rejected']);
      $approval->leave->update(['status' => 'Rejected']);
      return response()->json(['message' => 'Leave rejected.']);
    }
  }

  /**
 * @OA\Get(
 *     path="/api/v1/leave/pending-approvals",
 *     summary="Get pending leave approvals for current user",
 *     tags={"Leaves"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(response=403, description="Permission denied")
 * )
 */
  public function pendingApprovals()
  {
    if (!Auth::user() || !Auth::user()->can('manage leave')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    $pendingApprovals = LeaveApproval::where('approver_id', Auth::id())
      ->where('status', 'pending')
      ->with('leave.employee')
      ->get();
    return response()->json($pendingApprovals);
  }
}
