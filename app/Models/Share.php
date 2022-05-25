<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;
  /**
   * Get the shares that owns the yoflo.
   */
  public function share()
  {
    return $this->belongsTo(Share::class);
  }
}
