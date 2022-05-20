<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NodeType extends Model
{
    use HasFactory;
  /**
   * The attributes that are mass assignable.
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
  ];

  /**
   * Get the Node that owns the Nodes type.
   */
  public function node()
  {
    return $this->belongsTo(Node::class);
  }
}
