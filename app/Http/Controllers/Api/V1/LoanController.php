<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LoanApproval;
use App\Models\Employee;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *   schema="Loan",
 *   type="object",
 *   title="Loan",
 *   description="Loan model",
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="employee_id", type="integer", example=5),
 *   @OA\Property(property="loan_option", type="integer", example=2),
 *   @OA\Property(property="title", type="string", example="Home Renovation"),
 *   @OA\Property(property="amount", type="number", format="float", example=5000),
 *   @OA\Property(property="reason", type="string", example="Need funds for kitchen remodel"),
 *   @OA\Property(property="with_deduction", type="boolean", example=true),
 *   @OA\Property(property="deduction_amount", type="number", format="float", example=250),
 *   @OA\Property(property="start_deduction_date", type="string", format="date", example="2025-08-01"),
 *   @OA\Property(property="end_deduction_date", type="string", format="date", example="2026-08-01"),
 *   @OA\Property(property="total_deduction_months", type="integer", example=12),
 *   @OA\Property(
 *     property="employee",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=5),
 *     @OA\Property(property="name", type="string", example="Omar Elsayed")
 *   ),
 *   @OA\Property(
 *     property="loanOption",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=2),
 *     @OA\Property(property="name", type="string", example="Emergency Loan")
 *   ),
 * )
 */

class LoanController extends Controller
{
  /**
   * @OA\Get(
   *     path="/api/v1/loan",
   *     summary="List all loans or current user's loans with pending approvals",
   *     tags={"Loans"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Response(
   *         response=200,
   *         description="Successful response",
   *         @OA\JsonContent(
   *             oneOf={
   *                 @OA\Schema(
   *                     type="array",
   *                     @OA\Items(ref="#/components/schemas/Loan")
   *                 ),
   *                 @OA\Schema(
   *                     type="object",
   *                     @OA\Property(property="loans", type="array", @OA\Items(ref="#/components/schemas/Loan")),
   *                 )
   *             }
   *         )
   *     ),
   *     @OA\Response(response=403, description="Permission denied")
   * )
   */
  public function index()
  {
    if (!Auth::user() || !Auth::user()->can('view loan')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    if (Auth::user()->type == 'company' || Auth::user()->type == 'HR') {
      $employeeIds = User::where('created_by', Auth::user()->creatorId())->pluck('id');
      $loans = Loan::whereIn('created_by', $employeeIds)->with(['employee', 'loanOption'])->get();
      return response()->json($loans->values());
    } else {
      $pendingApprovals = LoanApproval::where('approver_id', Auth::user()->id)
        ->where('status', 'pending')
        ->with('loan.employee', 'loan.loanOption')
        ->get();
      $employee = Employee::where('user_id', Auth::user()->id)->first();
      if (!$employee) {
        return response()->json(['error' => 'Employee not found.'], 404);
      }
      $loans = Loan::where('employee_id', $employee->id)->with(['employee', 'loanOption'])->get();
      return response()->json([
        'loans' => $loans,
        'pendingApprovals' => $pendingApprovals
      ]);
    }
  }

  /**
   * @OA\Post(
   *     path="/api/v1/loan/store",
   *     summary="Create a new loan",
   *     tags={"Loans"},
   *     security={{"bearerAuth":{}}},
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"employee_id", "loan_option", "title", "amount", "reason"},
   *             @OA\Property(property="employee_id", type="integer"),
   *             @OA\Property(property="loan_option", type="integer"),
   *             @OA\Property(property="title", type="string"),
   *             @OA\Property(property="amount", type="number", format="float"),
   *             @OA\Property(property="reason", type="string"),
   *             @OA\Property(property="with_deduction", type="boolean"),
   *             @OA\Property(property="deduction_amount", type="number", format="float", nullable=true),
   *             @OA\Property(property="start_deduction_date", type="string", format="date", nullable=true),
   *             @OA\Property(property="end_deduction_date", type="string", format="date", nullable=true)
   *         )
   *     ),
   *     @OA\Response(response=201, description="Loan created"),
   *     @OA\Response(response=403, description="Permission denied"),
   *     @OA\Response(response=422, description="Validation error")
   * )
   */
  public function store(Request $request)
  {
    if (!Auth::user() || !Auth::user()->can('create loan')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    $request->validate([
      'employee_id' => 'required|exists:employees,id',
      'loan_option' => 'required|exists:loan_options,id',
      'title' => 'required|string',
      'amount' => 'required|numeric',
      'reason' => 'required',
      'with_deduction' => 'nullable|boolean',
      'deduction_amount' => 'nullable|numeric|min:0|required_if:with_deduction,1',
      'start_deduction_date' => 'nullable|date',
      'end_deduction_date' => 'nullable|date|after_or_equal:start_deduction_date',
    ]);
    $loan = new Loan();
    $loan->employee_id = $request->employee_id;
    $loan->loan_option = $request->loan_option;
    $loan->title = $request->title;
    $loan->amount = $request->amount;
    $loan->with_deduction = $request->with_deduction ? 1 : 0;
    $loan->deduction_amount = $request->with_deduction ? $request->deduction_amount : null;
    $loan->start_deduction_date = $request->with_deduction ? $request->start_deduction_date . '-01' : null;
    $loan->end_deduction_date = $request->with_deduction ? $request->end_deduction_date . '-01' : null;
    if ($request->with_deduction && $request->start_deduction_date && $request->end_deduction_date) {
      $start = new \DateTime($request->start_deduction_date);
      $end = new \DateTime($request->end_deduction_date);
      $months = (($end->format('Y') - $start->format('Y')) * 12) + ($end->format('m') - $start->format('m')) + 1;
      $loan->total_deduction_months = $months;
    } else {
      $loan->total_deduction_months = null;
    }
    $loan->reason = $request->reason;
    $loan->created_by = Auth::user()->creatorId();
    $loan->save();
    $approvalType = \DB::table('settings')->where('name', 'loan_levels')->where('created_by', Auth::user()->creatorId())->value('value');
    if ($approvalType && str_contains($approvalType, '_')) {
      $employeeId = explode('_', $approvalType)[0];
      $employee = Employee::find($employeeId);
      $approverId = $employee?->user_id;
      if ($approverId) {
        LoanApproval::create([
          'loan_id' => $loan->id,
          'approver_id' => $approverId,
          'status' => 'pending',
        ]);
      }
    } else {
      $employee = Employee::find($request->employee_id);
      if ($employee && $employee->manager) {
        LoanApproval::create([
          'loan_id' => $loan->id,
          'approver_id' => $employee->manager->user_id,
          'status' => 'pending',
        ]);
      }
    }
    return response()->json($loan->load(['employee', 'loanOption', 'approvals']), 201);
  }

  /**
   * @OA\Get(
   *     path="/api/v1/loan/{id}",
   *     summary="Get a specific loan",
   *     tags={"Loans"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="Loan ID",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\Response(response=200, description="Loan found", @OA\JsonContent(ref="#/components/schemas/Loan")),
   *     @OA\Response(response=404, description="Not found")
   * )
   */
  public function show(Loan $loan)
  {
    return response()->json($loan->load(['employee', 'loanOption', 'approvals']));
  }

  /**
   * @OA\Put(
   *     path="/api/v1/loan/{id}",
   *     summary="Update a loan",
   *     tags={"Loans"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="Loan ID",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"loan_option", "title", "amount", "reason"},
   *             @OA\Property(property="loan_option", type="integer"),
   *             @OA\Property(property="title", type="string"),
   *             @OA\Property(property="amount", type="number", format="float"),
   *             @OA\Property(property="reason", type="string")
   *         )
   *     ),
   *     @OA\Response(response=200, description="Loan updated"),
   *     @OA\Response(response=403, description="Permission denied"),
   *     @OA\Response(response=422, description="Validation error")
   * )
   */
  public function update(Request $request, Loan $loan)
  {
    if (!Auth::user() || !Auth::user()->can('edit loan')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    if ($loan->created_by != Auth::user()->creatorId()) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    $request->validate([
      'loan_option' => 'required|exists:loan_options,id',
      'title' => 'required|string',
      'amount' => 'required|numeric',
      'reason' => 'required',
    ]);
    $loan->loan_option = $request->loan_option;
    $loan->title = $request->title;
    $loan->amount = $request->amount;
    $loan->reason = $request->reason;
    $loan->save();
    return response()->json($loan->load(['employee', 'loanOption', 'approvals']));
  }

  /**
   * @OA\Delete(
   *     path="/api/v1/loan/{id}",
   *     summary="Delete a loan",
   *     tags={"Loans"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="Loan ID",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\Response(response=200, description="Loan deleted"),
   *     @OA\Response(response=403, description="Permission denied")
   * )
   */
  public function destroy(Request $request, Loan $loan)
  {
    if (!Auth::user() || !Auth::user()->can('delete loan')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    if ($loan->created_by != Auth::user()->creatorId()) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    $loan->delete();
    return response()->json(['message' => 'Deleted successfully']);
  }

  /**
   * @OA\Put(
   *     path="/api/v1/loan/{id}/approve",
   *     summary="Approve a loan",
   *     tags={"Loans"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="Loan approval ID",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"action"},
   *             @OA\Property(property="action", type="string", enum={"approve"})
   *         )
   *     ),
   *     @OA\Response(response=200, description="Loan approved"),
   *     @OA\Response(response=403, description="Permission denied")
   * )
   */

  /**
   * @OA\Put(
   *     path="/api/v1/loan/{id}/reject",
   *     summary="Reject a loan",
   *     tags={"Loans"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="Loan approval ID",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"action"},
   *             @OA\Property(property="action", type="string", enum={"reject"})
   *         )
   *     ),
   *     @OA\Response(response=200, description="Loan rejected"),
   *     @OA\Response(response=403, description="Permission denied")
   * )
   */
  public function action(Request $request, $id)
  {
    if (!Auth::user() || !Auth::user()->can('approve loan')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    $approval = LoanApproval::findOrFail($id);
    if ($approval->approver_id != Auth::user()->id) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    $action = $request->input('action', 'approve');
    if ($action === 'approve') {
      $approval->update(['status' => 'approved']);
      $approvalType = \DB::table('settings')->where('name', 'loan_levels')->where('created_by', $approval->loan->created_by)->value('value');
      if ($approvalType && str_contains($approvalType, '_')) {
        $approval->loan->update(['status' => 'Approved']);
        return response()->json(['message' => 'Loan fully approved.']);
      }
      $settings = Utility::settings();
      $countApproval = LoanApproval::where('status', 'approved')
        ->where('loan_id', $approval->loan_id)
        ->count();
      if ($countApproval == $settings['loan_levels']) {
        $approval->loan->update(['status' => 'Approved']);
        return response()->json(['message' => 'Loan fully approved.']);
      }
      $currentApprover = Employee::where('user_id', $approval->approver_id)->first();
      $nextManager = $currentApprover ? $currentApprover->manager : null;
      if ($nextManager) {
        LoanApproval::create([
          'loan_id' => $approval->loan_id,
          'approver_id' => $nextManager->user_id,
          'status' => 'pending',
        ]);
        return response()->json(['message' => 'Loan approved, next manager assigned.']);
      } else {
        $approval->loan->update(['status' => 'Approved']);
        return response()->json(['message' => 'Loan fully approved.']);
      }
    } else {
      $approval->update(['status' => 'rejected']);
      $approval->loan->update(['status' => 'Rejected']);
      return response()->json(['message' => 'Loan rejected.']);
    }
  }

  /**
 * @OA\Get(
 *     path="/api/v1/loan/pending-approvals",
 *     summary="Get pending loan approvals for current user",
 *     tags={"Loans"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(response=403, description="Permission denied")
 * )
 */
  public function pendingApprovals()
  {
    if (!Auth::user() || !Auth::user()->can('manage loan')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    $pendingApprovals = LoanApproval::where('approver_id', Auth::id())
      ->where('status', 'pending')
      ->with('loan.employee', 'loan.loanOption')
      ->get();
    return response()->json($pendingApprovals);
  }
}
