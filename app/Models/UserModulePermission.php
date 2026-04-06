<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserModulePermission extends Model
{
    use HasFactory;

    protected $table = 'user_module_permissions';

    protected $fillable = [
        'user_id',
        'module_id',
        'can_view',
    ];

    protected $casts = [
        'can_view' => 'boolean',
    ];

    /**
     * Get the user this permission belongs to
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the module this permission relates to
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Grant permission to user for module and parent modules
     */
    public static function grantPermission(User $user, Module $module): self
    {
        // First, grant permission to this module
        $permission = self::firstOrCreate(
            ['user_id' => $user->id, 'module_id' => $module->id],
            ['can_view' => true]
        );

        // Then, grant permission to all parent modules
        foreach ($module->getAncestors() as $parent) {
            self::firstOrCreate(
                ['user_id' => $user->id, 'module_id' => $parent->id],
                ['can_view' => true]
            );
        }

        return $permission;
    }

    /**
     * Revoke permission from user for module and its children
     */
    public static function revokePermission(User $user, Module $module): void
    {
        // Revoke from this module
        self::where('user_id', $user->id)
            ->where('module_id', $module->id)
            ->delete();

        // Revoke from all child modules
        $childIds = $module->getAllChildIds();
        if (!empty($childIds)) {
            self::where('user_id', $user->id)
                ->whereIn('module_id', $childIds)
                ->delete();
        }

        // Check if parent modules still have other children with permissions
        $ancestors = $module->getAncestors();
        foreach ($ancestors as $parent) {
            $hasOtherChildren = $parent->children()
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('users.id', $user->id);
                })
                ->exists();

            if (!$hasOtherChildren) {
                self::where('user_id', $user->id)
                    ->where('module_id', $parent->id)
                    ->delete();
            }
        }
    }
}
