<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yoflo extends Model
{
    use HasFactory;
  /**
   * The attributes that are mass assignable.
   * @var array<int, string>
   */
  protected $fillable = [
    'title',
    'description',
    'folder_id',
    'user_id'
  ];

  /**
   * Get the folder that owns the yoflo.
   */
  public function folder()
  {
    return $this->belongsTo(Folder::class);
  }


  /**
   * Get the users that owns the yoflo.
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Get the nodes for the  yoflo.
   */
  public function nodes ()
  {
    return $this->hasMany(Node::class);
  }
  /**
   * Get the shares for the  yoflo.
   */
  public function shares ()
  {
    return $this->hasMany(Share::class);
  }
}
