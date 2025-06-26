<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmploymentType extends Model
{
    protected $fillable = ['title','created_by'];

    public function employees(){
      return $this->hasMany(Employee::class);
    }
}
