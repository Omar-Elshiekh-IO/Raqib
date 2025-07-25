<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveApproval extends Model
{
  protected $fillable = ['leave_id', 'approver_id', 'status'];

  public function leave()
  {
    return $this->belongsTo(Leave::class);
  }

  public function approver()
  {
    return $this->belongsTo(Employee::class, 'approver_id', 'user_id');
  }
}
