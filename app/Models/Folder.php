<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;
  use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

  class Folder extends Model
  {
    use HasFactory;
    use HasRecursiveRelationships;
  /**
   * The attributes that are mass assignable.
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
  ];

  public function getParentKeyName ()
  {
    return 'parent_id';
  }

  public function getLocalKeyName ()
  {
    return 'id';
  }

    /**
     * Get the folder that owns the user.
     */
    public function user()
    {
      return $this->belongsTo(User::class);
    }
}


