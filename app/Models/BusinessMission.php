<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessMission extends Model
{
  protected $fillable = [
    'employee_id',
    'title',
    'start_date',
    'end_date',
    'description',
    'remark',
    'created_by',
    'status'
  ];

  public function employee()
  {
    return $this->belongsTo(Employee::class);
  }
}
