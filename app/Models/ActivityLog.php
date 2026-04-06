<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'action',
        'module_id',
        'description',
        'ip_address',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get the user this activity belongs to
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the module this activity relates to
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Log an activity
     */
    public static function log(User $user, string $action, ?Module $module = null, ?string $description = null): self
    {
        return self::create([
            'user_id' => $user->id,
            'action' => $action,
            'module_id' => $module?->id,
            'description' => $description,
            'ip_address' => request()->ip(),
        ]);
    }
}
