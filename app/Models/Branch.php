<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Branch extends Model
{
    protected $fillable = [
        'name','created_by', 'latitude', 'longitude','login_range'
    ];

    public function user():BelongsTo{
      return $this->belongsTo(User::class);
    }
}
