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
    'user_id',
    'parent_folder_id'
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
     * Get the users that owns the folder.
     */
    public function user()
    {
      return $this->belongsTo(User::class);
    }
    /**
     * Get the yoflos for the  folder.
     */
    public function yoflos ()
    {
      return $this->hasMany(Yoflo::class);
    }

}


