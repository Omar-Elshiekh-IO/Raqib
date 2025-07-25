<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\BusinessMission;
use Illuminate\Http\Request;
use App\Models\BusinessMissionApproval;
use App\Models\Employee;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

class BusinessMissionController extends Controller
{
  /**
   * @OA\Get(
   *     path="/api/v1/business-mission",
   *     summary="Get list of business missions",
   *     tags={"Business Missions"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Response(
   *         response=200,
   *         description="Successful response",
   *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/BusinessMission"))
   *     ),
   *     @OA\Response(response=403, description="Permission denied")
   * )
   */
  public function index()
  {

    if (!Auth::user() || !Auth::user()->can('view business mission')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    if (Auth::user()->type == 'company' || Auth::user()->type == 'HR') {
      $employeeIds = User::where('created_by', Auth::user()->creatorId())->pluck('id');
      $businessMissions = BusinessMission::whereIn('created_by', $employeeIds)->with('employee')->get();
      $businessMissionsBySelf = BusinessMission::where('created_by', Auth::user()->creatorId())->with('employee')->get();
      $businessMissions = $businessMissions->merge($businessMissionsBySelf);
      return response()->json($businessMissions->values());
    } else {
      $pendingApprovals = BusinessMissionApproval::where('approver_id', Auth::id())
        ->where('status', 'pending')
        ->with('businessMission.employee')
        ->get();
      $employee = Employee::where('user_id', Auth::id())->first();
      if (!$employee) {
        return response()->json(['error' => 'Employee not found.'], 404);
      }
      $businessMissions = BusinessMission::where('employee_id', $employee->id)->with('employee')->get();
      return response()->json([
        'businessMissions' => $businessMissions,
        'pendingApprovals' => $pendingApprovals
      ]);
    }
  }

  /**
   * @OA\Post(
   *     path="/api/v1/business-mission/store",
   *     summary="Create a new business mission",
   *     tags={"Business Missions"},
   *     security={{"bearerAuth":{}}},
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"employee_id", "title", "start_date", "end_date", "description"},
   *             @OA\Property(property="employee_id", type="integer"),
   *             @OA\Property(property="title", type="string"),
   *             @OA\Property(property="start_date", type="string", format="date"),
   *             @OA\Property(property="end_date", type="string", format="date"),
   *             @OA\Property(property="description", type="string"),
   *             @OA\Property(property="remark", type="string", nullable=true)
   *         )
   *     ),
   *     @OA\Response(response=201, description="Business mission created"),
   *     @OA\Response(response=403, description="Permission denied")
   * )
   */
  public function store(Request $request)
  {
    if (!Auth::user() || !Auth::user()->can('create business mission')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
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
    $employee = Employee::find($request->employee_id);
    if ($employee && $employee->manager) {
      BusinessMissionApproval::create([
        'business_mission_id' => $businessMission->id,
        'approver_id' => $employee->manager->user_id,
        'status' => 'pending',
      ]);
    }
    return response()->json($businessMission->load(['employee', 'approvals']), 201);
  }

  /**
   * @OA\Get(
   *     path="/api/v1/business-mission/{id}",
   *     summary="Get a specific business mission",
   *     tags={"Business Missions"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="Business mission ID",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\Response(response=200, description="Successful"),
   *     @OA\Response(response=404, description="Not found")
   * )
   */
  public function show(BusinessMission $businessMission)
  {
    return response()->json($businessMission->load(['employee', 'approvals']));
  }

  /**
   * @OA\Put(
   *     path="/api/v1/business-mission/{id}",
   *     summary="Update a business mission",
   *     tags={"Business Missions"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="Business mission ID",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"employee_id", "title", "start_date", "end_date", "description"},
   *             @OA\Property(property="employee_id", type="integer"),
   *             @OA\Property(property="title", type="string"),
   *             @OA\Property(property="start_date", type="string", format="date"),
   *             @OA\Property(property="end_date", type="string", format="date"),
   *             @OA\Property(property="description", type="string"),
   *             @OA\Property(property="remark", type="string", nullable=true),
   *             @OA\Property(property="status", type="string", enum={"Pending", "Approved", "In_Progress", "Completed", "Canceled"})
   *         )
   *     ),
   *     @OA\Response(response=200, description="Business mission updated"),
   *     @OA\Response(response=403, description="Permission denied")
   * )
   */
  public function update(Request $request, BusinessMission $businessMission)
  {
    if (!Auth::user() || !Auth::user()->can('edit business mission')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    if ($businessMission->created_by != Auth::user()->creatorId()) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
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
    return response()->json($businessMission->load(['employee', 'approvals']));
  }

  /**
   * @OA\Delete(
   *     path="/api/v1/business-mission/{id}",
   *     summary="Delete a business mission",
   *     tags={"Business Missions"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="Business mission ID",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\Response(response=200, description="Deleted successfully"),
   *     @OA\Response(response=403, description="Permission denied")
   * )
   */
  public function destroy(Request $request, BusinessMission $businessMission)
  {
    if (!Auth::user() || !Auth::user()->can('delete business mission')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    if ($businessMission->created_by != Auth::user()->creatorId()) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    $businessMission->delete();
    return response()->json(['message' => 'Deleted successfully']);
  }

  /**
   * @OA\Put(
   *     path="/api/v1/business-mission/{id}/approve",
   *     summary="Approve a business mission",
   *     tags={"Business Missions"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="Business mission approval ID",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             @OA\Property(property="action", type="string", enum={"approve"}, example="approve")
   *         )
   *     ),
   *     @OA\Response(response=200, description="Approval successful"),
   *     @OA\Response(response=403, description="Permission denied")
   * )
   */

  /**
   * @OA\Put(
   *     path="/api/v1/business-mission/{id}/reject",
   *     summary="Reject a business mission",
   *     tags={"Business Missions"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="Business mission approval ID",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             @OA\Property(property="action", type="string", enum={"reject"}, example="reject")
   *         )
   *     ),
   *     @OA\Response(response=200, description="Rejection successful"),
   *     @OA\Response(response=403, description="Permission denied")
   * )
   */

  public function action(Request $request, $id)
  {
    if (!Auth::user() || !Auth::user()->can('approve business mission')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    $approval = BusinessMissionApproval::findOrFail($id);
    if ($approval->approver_id != Auth::user()->id) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    $action = $request->input('action', 'approve');
    if ($action === 'approve') {
      $approval->update(['status' => 'approved']);
      $settings = Utility::settings();
      $requiredLevels = isset($settings['business_levels']) ? (int)$settings['business_levels'] : 1;
      $creatorId = $approval->businessMission->created_by;
      $countApproval = BusinessMissionApproval::where('status', 'approved')
        ->where('business_mission_id', $approval->business_mission_id)
        ->whereHas('businessMission', function ($q) use ($creatorId) {
          $q->where('created_by', $creatorId);
        })
        ->count();
      if ($countApproval >= $requiredLevels) {
        $approval->businessMission->update(['status' => 'Approved']);
        return response()->json(['message' => 'Business Mission fully approved.']);
      }
      $currentApprover = Employee::where('user_id', $approval->approver_id)->first();
      $nextManager = $currentApprover ? $currentApprover->manager : null;
      if ($nextManager) {
        BusinessMissionApproval::create([
          'business_mission_id' => $approval->business_mission_id,
          'approver_id' => $nextManager->user_id,
          'status' => 'pending',
        ]);
        return response()->json(['message' => 'Business Mission approved, next manager assigned.']);
      } else {
        $approval->businessMission->update(['status' => 'Approved']);
        return response()->json(['message' => 'Business Mission fully approved.']);
      }
    } else {
      $approval->update(['status' => 'rejected']);
      $approval->businessMission->update(['status' => 'Rejected']);
      return response()->json(['message' => 'Business Mission rejected.']);
    }
  }

  /**
   * @OA\Get(
   *     path="/api/v1/business-mission/pending-approvals",
   *     summary="Get pending business mission approvals for current user",
   *     tags={"Business Missions"},
   *     security={{"bearerAuth":{}}},
   *     @OA\Response(response=200, description="List of pending approvals"),
   *     @OA\Response(response=403, description="Permission denied")
   * )
   */
  public function pendingApprovals()
  {
    if (!Auth::user() || !Auth::user()->can('manage business mission')) {
      return response()->json(['error' => 'Permission denied.'], 403);
    }
    $pendingApprovals = BusinessMissionApproval::where('approver_id', Auth::id())
      ->where('status', 'pending')
      ->with('businessMission.employee')
      ->get();
    return response()->json($pendingApprovals);
  }
}
