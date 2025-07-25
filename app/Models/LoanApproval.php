<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanApproval extends Model
{
  protected $fillable = ['loan_id', 'approver_id', 'status'];

  public function loan()
  {
    return $this->belongsTo(Loan::class);
  }

  public function approver()
  {
    return $this->belongsTo(Employee::class, 'approver_id', 'user_id');
  }
}
