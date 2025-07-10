<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkShift extends Model
{
    public function workShiftDays():HasMany{
      return $this->hasMany(WorkShiftDays::class);
    }

    public function employees(){
      return $this->belongsToMany(Employee::class);
    }
}
