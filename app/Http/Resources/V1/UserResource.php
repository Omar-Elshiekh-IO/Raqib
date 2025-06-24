<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // Basic user info
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'type' => $this->type,
            'avatar' => $this->avatar,
            'lang' => $this->lang,
            'mode' => $this->mode,
            'dark_mode' => $this->dark_mode,
            'last_login_at' => optional($this->last_login_at)?->toDateTimeString(),
            'created_at' => optional($this->created_at)?->toDateTimeString(),
            // Employee profile (if exists)
            'employee' => $this->whenLoaded('employee', function () {
                return [
                    'employee_id' => $this->employee->id,
                    'user_id' => $this->employee->user_id,
                    'phone' => $this->employee->phone,
                    'dob' => $this->employee->dob,
                    'gender' => $this->employee->gender,
                    'address' => $this->employee->address,
                    'salary_type' => $this->employee->salary_type,
                    'salary' => $this->employee->salary,
                    'biometric_emp_id' => $this->employee->biometric_emp_id,
                    'branch_id' => $this->employee->branch_id,
                    'branch_name' => $this->employee->branch->name,
                    'department_id' => $this->employee->department_id,
                    'department_name' => $this->employee->department->name,
                    'designation_id' => $this->employee->designation_id,
                    'designation_name' => $this->employee->designation->name,
                    'company_doj' => $this->employee->company_doj,
                    'is_active' => $this->employee->is_active,
                ];
            }),
            'branch_location' => $this->employee->branch ? [
            'name' => $this->employee->branch->name,
            'latitude' => $this->employee->branch->latitude,
            'longitude' => $this->employee->branch->longitude,
            'login_range' => $this->employee->branch->login_range,
        ] : null,
        ];
    }
}
