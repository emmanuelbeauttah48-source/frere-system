<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnitType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',

        'bedrooms',
        'bathrooms',
        'size',
        'size_unit',

        'base_price',
        'price_period',

        'is_active',

        'floor_plan',
        'amenities',
    ];

    protected function casts(): array
    {
        return [
            'bedrooms' => 'integer',
            'bathrooms' => 'integer',
            'size' => 'decimal:2',
            'base_price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function houses(): HasMany
    {
        return $this->hasMany(House::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('is_active', false);
    }

    public function scopeForPeriod(
        Builder $query,
        string $period
    ): Builder {
        return $query->where('price_period', $period);
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->base_price === null) {
            return 'Not Set';
        }

        return 'KES ' . number_format(
            (float) $this->base_price,
            2
        );
    }

    public function getPricePeriodLabelAttribute(): string
    {
        return match ($this->price_period) {
            'daily' => 'Per Day',
            'weekly' => 'Per Week',
            'monthly' => 'Per Month',
            'yearly' => 'Per Year',
            'one_time' => 'One Time',
            default => ucfirst($this->price_period ?? 'N/A'),
        };
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->code
            ? "{$this->name} ({$this->code})"
            : $this->name;
    }

    public function getBedroomLabelAttribute(): string
    {
        return match ($this->bedrooms) {
            0 => 'Studio',
            1 => '1 Bedroom',
            default => "{$this->bedrooms} Bedrooms",
        };
    }

    public function getBathroomLabelAttribute(): string
    {
        return match ($this->bathrooms) {
            0 => 'No Bathroom',
            1 => '1 Bathroom',
            default => "{$this->bathrooms} Bathrooms",
        };
    }

    public function getFormattedSizeAttribute(): ?string
    {
        if ($this->size === null) {
            return null;
        }

        return number_format(
            (float) $this->size,
            2
        ) . ' ' . $this->size_unit;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function hasPrice(): bool
    {
        return $this->base_price !== null;
    }

    public function getHouseCountAttribute(): int
    {
        return $this->houses()->count();
    }
}

