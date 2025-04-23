<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'password',
        'gender',
        'profile_pic',
        'profile_id',
        'is_admin',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'updated_at',
        'created_at',
        'role_id',
        'profile_id'
    ];
    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', '_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Get the default 'user' role from the roles collection
            $defaultRole = Role::where('name', 'User')->first();
            
            if ($defaultRole) {
                $user->role_id = $defaultRole->_id;
            }
        });
    }

    /**
     * Always append the role relationship when serializing
     */
    protected $with = ['role'];

    public $timestamps = true;
}