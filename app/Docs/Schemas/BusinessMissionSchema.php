<?php

namespace App\Docs\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *   schema="BusinessMission",
 *   type="object",
 *   title="Business Mission",
 *   description="Details about a business mission",
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="employee_id", type="integer", example=5),
 *   @OA\Property(property="title", type="string", example="Client Meeting in Dubai"),
 *   @OA\Property(property="start_date", type="string", format="date", example="2025-07-20"),
 *   @OA\Property(property="end_date", type="string", format="date", example="2025-07-25"),
 *   @OA\Property(property="description", type="text", example="Meeting with key client to discuss project status."),
 *   @OA\Property(property="remark", type="string", nullable=true, example="Don't forget the presentation slides."),
 *   @OA\Property(property="status", type="string", enum={"Pending", "Approved", "In_Progress", "Completed", "Canceled", "Rejected"}, example="Pending"),
 *   @OA\Property(
 *     property="employee",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=12),
 *     @OA\Property(property="name", type="string", example="John Doe")
 *   ),
 *   @OA\Property(
 *     property="approvals",
 *     type="array",
 *     @OA\Items(
 *       type="object",
 *       @OA\Property(property="id", type="integer", example=1),
 *       @OA\Property(property="approver_id", type="integer", example=8),
 *       @OA\Property(property="status", type="string", example="pending")
 *     )
 *   )
 * )
 */


class BusinessMissionSchema {}