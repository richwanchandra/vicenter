<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // =========================================================================
    // Relationships
    // =========================================================================

    /**
     * Module visibility permissions (legacy — controls sidebar menus)
     */
    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(Module::class, 'user_module_permissions')
            ->withPivot('can_view')
            ->withTimestamps();
    }


    /**
     * Activity logs for this user
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Contents created by this user
     */
    public function createdContents(): HasMany
    {
        return $this->hasMany(Content::class, 'created_by');
    }

    /**
     * RBAC Roles assigned to this user
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles')
            ->withTimestamps();
    }

    // =========================================================================
    // System-role helpers
    // =========================================================================

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // =========================================================================
    // Legacy module-visibility helpers (unchanged behaviour)
    // =========================================================================

    public function hasModuleAccess(Module $module): bool
    {
        return $this->hasAccessToModule($module->id);
    }

    public function getAccessibleModuleIds(): array
    {
        return $this->accessibleModules()->toArray();
    }

    /**
     * Check if user has access to a specific module (via any of their roles)
     */
    public function hasAccessToModule(string|int $module): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->roles()->whereHas('modules', function ($query) use ($module) {
            if (is_numeric($module)) {
                $query->where('modules.id', $module);
            } else {
                $query->where('modules.slug', $module);
            }
        })->exists();
    }
 
    public function accessibleModules()
    {
        if ($this->isSuperAdmin()) {
            return Module::where('is_active', true)->pluck('id');
        }
 
        return Module::whereHas('roles', function ($query) {
            $query->whereHas('users', function ($q) {
                $q->where('users.id', $this->id);
            });
        })->where('is_active', true)->pluck('id');
    }
}
