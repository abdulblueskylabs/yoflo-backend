<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
  /**
   * The attributes that are mass assignable.
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'max_node_quantity',
    'max_share_quantity',
    'max_storage_quantity',
    'cost',
    'is_active'
  ];

  public function users()
  {
    return $this->belongsToMany(User::class, 'user_subscription', 'subscription_id', 'user_id')->withPivot('start','end','is_active')->withTimestamps();
  }
}
