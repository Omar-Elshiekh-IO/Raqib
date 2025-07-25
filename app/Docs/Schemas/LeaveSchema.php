<?php

namespace App\Docs\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *   schema="Leave",
 *   type="object",
 *   title="Leave",
 *   description="Leave request",
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="employee_id", type="integer", example=7),
 *   @OA\Property(property="leave_type_id", type="integer", example=2),
 *   @OA\Property(property="applied_on", type="string", format="date", example="2025-07-20"),
 *   @OA\Property(property="start_date", type="string", format="date", example="2025-08-01"),
 *   @OA\Property(property="end_date", type="string", format="date", example="2025-08-10"),
 *   @OA\Property(property="total_leave_days", type="integer", example=10),
 *   @OA\Property(property="leave_reason", type="string", example="Family trip"),
 *   @OA\Property(property="remark", type="string", example="Approved by team lead"),
 *   @OA\Property(property="status", type="string", example="Pending"),
 *   @OA\Property(property="with_deduction", type="boolean", example=true),
 *   @OA\Property(property="deduction_amount", type="number", format="float", example=100.0),
 *   @OA\Property(property="start_deduction_date", type="string", format="date", example="2025-08-01"),
 *   @OA\Property(property="end_deduction_date", type="string", format="date", example="2025-08-31"),
 *   @OA\Property(property="total_deduction_months", type="integer", example=1),
 *   @OA\Property(
 *     property="employee",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=7),
 *     @OA\Property(property="name", type="string", example="Omar Elsayed")
 *   ),
 *   @OA\Property(
 *     property="leaveType",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=2),
 *     @OA\Property(property="name", type="string", example="Annual Leave")
 *   ),
 * )
 */

class LeaveSchema {}