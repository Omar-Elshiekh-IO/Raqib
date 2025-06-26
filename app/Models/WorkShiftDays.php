<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkShiftDays extends Model
{
  protected const DAYS = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  protected $fillable = ['work_shift_id', 'day'];

  public function workShift()
  {
    return $this->belongsTo(WorkShift::class);
  }
  public static function getDayName($index)
  {
    return self::DAYS[$index] ?? 'Invalid';
  }
}
