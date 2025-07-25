<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExcuseApproval extends Model
{
  protected $fillable = ['excuse_id', 'approver_id', 'status'];

  public function excuse()
  {
    return $this->belongsTo(Excuse::class);
  }

  public function approver()
  {
    return $this->belongsTo(Employee::class, 'approver_id', 'user_id');
  }
}
