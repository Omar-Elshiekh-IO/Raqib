<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessMissionApproval extends Model
{
  protected $fillable = ['business_mission_id', 'approver_id', 'status'];

  public function businessMission()
  {
    return $this->belongsTo(BusinessMission::class);
  }

  public function approver()
  {
    return $this->belongsTo(Employee::class, 'approver_id', 'user_id');
  }
}
