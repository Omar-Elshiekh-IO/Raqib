<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Excuse extends Model
{
        protected $fillable = [
        'employee_id',
        'title',
        'date',
        'description',
        'remark',
        'created_by',
        'with_deduction',
        'deduction_amount'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
