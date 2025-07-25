<?php

namespace App\Docs\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *   schema="Excuse",
 *   type="object",
 *   title="Excuse",
 *   description="An employee excuse request",
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="employee_id", type="integer", example=10),
 *   @OA\Property(property="excuse_date", type="string", format="date", example="2025-07-20"),
 *   @OA\Property(property="duration", type="integer", example=30),
 *   @OA\Property(property="reason", type="string", example="Doctor appointment"),
 *   @OA\Property(property="status", type="string", enum={"Pending", "Approved", "Rejected", "Canceled"}, example="Pending"),
 *   @OA\Property(property="remark", type="string", nullable=true, example="Submitted late"),
 *   @OA\Property(property="with_deduction", type="boolean", example=false),
 *   @OA\Property(property="deduction_amount", type="number", format="float", nullable=true, example=0.0),
 *   @OA\Property(
 *     property="employee",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=10),
 *     @OA\Property(property="name", type="string", example="Ahmed Ali")
 *   ),
 * )
 */

class ExcuseSchema {}