<?php

  namespace App\Models;

  use Illuminate\Auth\Notifications\ResetPassword;
  use Illuminate\Contracts\Auth\MustVerifyEmail;
  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Foundation\Auth\User as Authenticatable;
  use Illuminate\Notifications\Notifiable;
  use Laravel\Sanctum\HasApiTokens;
  use Spatie\Permission\Traits\HasRoles;

  class User extends Authenticatable
  {
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
      'first_name',
      'last_name',
      'phone',
      'email',
      'password',
      'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */
    protected $hidden = [
      'password',
      'remember_token',
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
      'email_verified_at' => 'datetime',
    ];

    public function subscriptions ()
    {
      return $this->belongsToMany(Subscription::class, 'user_subscription', 'user_id', 'subscription_id')
        ->withPivot('start_date', 'end_date', 'is_active', 'id')
        ->withTimestamps();
    }

    // Function provide active subscription only from pivot table =user_subscription
    public function activeSubscriptions ()
    {
      return $this->belongsToMany(Subscription::class, 'user_subscription', 'user_id', 'subscription_id')
        ->withPivot('is_active', 'id')
        ->wherePivot('is_active', 1);

    }

    /**
     * Get the folders for the  user.
     */
    public function folders ()
    {
      return $this->hasMany(Folder::class);
    }

    /**
     * Get the yoflos for the  user.
     */
    public function yoflos ()
    {
      return $this->hasMany(Yoflo::class);
    }

    /**
     * Get the nodes for the  user.
     */
    public function nodes ()
    {
      return $this->hasMany(Node::class);
    }

    /**
     * Get the libraries for the  user.
     */
    public function libraries ()
    {
      return $this->hasMany(Library::class);
    }

  }
