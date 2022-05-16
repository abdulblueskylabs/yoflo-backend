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
   * Get the yoflos that owns the folder.
   */
  public function folder()
  {
    return $this->belongsTo(Folder::class);
  }


  /**
   * Get the yoflos that owns the user.
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }


}
