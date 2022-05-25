<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;

  class Node extends Model
  {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
      'title',
      'description',
      'coordinates',
      'yoflo_id',
      'user_id',
      'node_type_id',
    ];

    /**
     * Get the yoflo that owns the node.
     */
    public function yoflo ()
    {
      return $this->belongsTo(Yoflo::class);
    }

    /**
     * Get the user that owns the node.
     */
    public function user ()
    {
      return $this->belongsTo(User::class);
    }

    /**
     * Get the Nodetypes that owns the Node.
     */
    public function nodetype()
    {
      return $this->belongsTo(NodeType::class);
    }
    /**
     * Get the library for the Node.
     */
    public function files ()
    {
      return $this->hasMany(File::class);
    }

  }
