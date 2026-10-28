<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Floor extends Model
{
   
    protected $fillable = [
        'estate_id',
        'block_id',
        'name',
        'code',
        'floor_number',
        'description',
        'total_units',
        'occupied_units',
        'vacant_units',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'floor_number'   => 'integer',
        'total_units'    => 'integer',
        'occupied_units' => 'integer',
        'vacant_units'   => 'integer',
    ];

    public function estate(): BelongsTo
    {
        return $this->belongsTo(Estate::class);
    }

    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }

    public function houses(): HasMany
    {
        return $this->hasMany(House::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getOccupancyPercentageAttribute(): float
    {
        if ($this->total_units === 0) {
            return 0;
        }

        return round(($this->occupied_units / $this->total_units) * 100, 1);
    }

    public function getIsFullAttribute(): bool
    {
        return $this->occupied_units >= $this->total_units;
    }

    public function getHasVacancyAttribute(): bool
    {
        return $this->vacant_units > 0;
    }
}