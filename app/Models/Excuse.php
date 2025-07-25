<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Excuse extends Model
{
        protected $fillable = [
          'employee_id',
          'excuse_date',
          'duration',
          'actual_leave_time',
          'reason',
          'status',
          'remark',
          'created_by',
          'with_deduction',
          'deduction_amount',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function approvals(){
      return $this->hasMany(ExcuseApproval::class);
    }
}
