<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'employee_id',
        'loan_option',
        'title',
        'amount',
        'start_date',
        'end_date',
        'reason',
        'created_by',
        'with_deduction',
        'deduction_amount',
        'start_deduction_date',
        'end_deduction_date',
        'total_deduction_months',
    ];

    public function employee()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id');
    }
    // public function employee()
    // {
    //     return $this->belongsTo('App\Models\Employee', 'id', 'employee_id');
    // }

    public function loanOption()
    {
        return $this->hasOne('App\Models\LoanOption', 'id', 'loan_option');
    }
    public static $Loantypes=[
        'fixed'=>'Fixed',
        'percentage'=> 'Percentage',
    ];
}
