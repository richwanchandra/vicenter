<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'order_number',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the parent module
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'parent_id');
    }

    /**
     * Get child modules
     */
    public function children(): HasMany
    {
        return $this->hasMany(Module::class, 'parent_id')->orderBy('order_number');
    }

    /**
     * Get all descendants recursively
     */
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    /**
     * Get users with permission to this module
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_module_permissions')
            ->withPivot('can_view')
            ->withTimestamps();
    }    /**
     * Roles that have access to this module
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_module_access')
            ->withTimestamps();
    }
    /**
     * Get contents for this module
     */
    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }

    /**
     * Recursively get all child IDs
     */
    public function getAllChildIds(): array
    {
        $ids = [];
        foreach ($this->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $child->getAllChildIds());
        }
        return $ids;
    }

    /**
     * Get all ancestors (parents up to root)
     */
    public function getAncestors()
    {
        $ancestors = [];
        $current = $this;
        while ($current->parent_id) {
            $current = $current->parent;
            $ancestors[] = $current;
        }
        return $ancestors;
    }

    /**
     * Get root module
     */
    public function getRoot()
    {
        return $this->parent_id ? $this->parent->getRoot() : $this;
    }

    /**
     * Create slug from name
     */
    public static function generateSlug(string $name): string
    {
        return strtolower(str_replace(' ', '-', $name));
    }
}
