<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use App\Contracts\Ownable;

class User extends Authenticatable implements Ownable
{
    use HasFactory, Notifiable;

    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';

    /**
     * @var array
     */
    protected $attributes = [
        'is_active' => true,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'roles',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'roles' => 'array',
    ];

    /**
     * @inheritDoc
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes['roles']= json_encode([
            self::ROLE_USER
        ]);

        parent::__construct($attributes);
    }

    /**
     * Hash the password before it is
     * saved to the database.
     *
     * @param string $password
     * @return void
     */
    public function setPasswordAttribute(string $password): void
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * @param string $role
     * @return boolean
     */
    public function hasRole(string $role): bool
    {
        $roles = $this->roles;
  
        if (!is_array($roles)) {
            return false;
        }

        return in_array($role, $roles);
    }

    /**
     * @inheritDoc
     */
    public function isOwner(User $user): bool
    {
        return $this->id && $this->id === $user->id;
    }
}
