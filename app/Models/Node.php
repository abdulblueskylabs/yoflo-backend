<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    use HasFactory;


  /**
   * Get the yoflo that owns the node.
   */
  public function yoflo()
  {
    return $this->belongsTo(Yoflo::class);
  }

  /**
   * Get the user that owns the node.
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Get the NodeType associated with the Node.
   */
  public function nodetype()
  {
    return $this->hasOne(NodeType::class);
  }

  /**
   * Get the library for the Node.
   */
  public function libraries()
  {
    return $this->hasMany(Library::class);
  }

}
