<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class House extends Model
{

    protected $fillable = [

        'estate_id',
        'block_id',
        'floor_id',
        'unit_type_id',

        'house_number',
        'house_code',
        'title',
        'slug',

        'bedrooms',
        'bathrooms',
        'balconies',
        'area',
        'description',
        'notes',

        'monthly_rent',
        'deposit',
        'service_charge',
        'rent_frequency',

        'electricity_meter',
        'water_meter',
        'gas_meter',

        'is_occupied',
        'occupied_since',
        'available_from',

        'is_available',
        'status',

        'photo',
    ];

    protected function casts(): array
    {
        return [
            'bedrooms' => 'integer',
            'bathrooms' => 'integer',
            'balconies' => 'integer',

            'area' => 'decimal:2',

            'monthly_rent' => 'decimal:2',
            'deposit' => 'decimal:2',
            'service_charge' => 'decimal:2',

            'is_occupied' => 'boolean',
            'is_available' => 'boolean',

            'occupied_since' => 'date',
            'available_from' => 'date',
        ];
    }

    public function estate(): BelongsTo
    {
        return $this->belongsTo(Estate::class);
    }

    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }

    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class);
    }

    public function unitType(): BelongsTo
    {
        return $this->belongsTo(UnitType::class);
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->house_number . ' (' . $this->house_code . ')';
    }

    public function getFormattedRentAttribute(): string
    {
        return 'KES ' . number_format((float) $this->monthly_rent, 2);
    }

    public function getFormattedDepositAttribute(): string
    {
        return 'KES ' . number_format((float) $this->deposit, 2);
    }

    public function getFormattedServiceChargeAttribute(): string
    {
        return 'KES ' . number_format((float) $this->service_charge, 2);
    }

    public function getAvailabilityAttribute(): string
    {
        return $this->is_available
            ? 'Available'
            : 'Unavailable';
    }

    public function getOccupancyStatusAttribute(): string
    {
        return $this->is_occupied
            ? 'Occupied'
            : 'Vacant';
    }

    public function getFullLocationAttribute(): string
    {
        return collect([
            $this->estate?->name,
            $this->block?->name,
            $this->floor?->name,
            $this->house_number,
        ])
            ->filter()
            ->implode(' → ');
    }

    public function isVacant(): bool
    {
        return $this->status === 'Vacant';
    }

    public function isOccupied(): bool
    {
        return $this->status === 'Occupied';
    }

    public function isReserved(): bool
    {
        return $this->status === 'Reserved';
    }

    public function isUnderMaintenance(): bool
    {
        return $this->status === 'Maintenance';
    }

    public function isUnavailable(): bool
    {
        return $this->status === 'Unavailable';
    }

    public function isAvailableForRent(): bool
    {
        return $this->is_available
            && $this->status === 'Vacant';
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query
            ->where('is_available', true)
            ->where('status', 'Vacant');
    }

    public function scopeOccupied(Builder $query): Builder
    {
        return $query->where('status', 'Occupied');
    }

    public function scopeVacant(Builder $query): Builder
    {
        return $query->where('status', 'Vacant');
    }

    public function scopeReserved(Builder $query): Builder
    {
        return $query->where('status', 'Reserved');
    }

    public function scopeMaintenance(Builder $query): Builder
    {
        return $query->where('status', 'Maintenance');
    }

    public function scopeUnavailable(Builder $query): Builder
    {
        return $query->where('status', 'Unavailable');
    }

    public function scopeForEstate(
        Builder $query,
        int $estateId
    ): Builder {
        return $query->where('estate_id', $estateId);
    }

    public function scopeForBlock(
        Builder $query,
        int $blockId
    ): Builder {
        return $query->where('block_id', $blockId);
    }

    public function scopeForFloor(
        Builder $query,
        int $floorId
    ): Builder {
        return $query->where('floor_id', $floorId);
    }

    public function scopeForUnitType(
        Builder $query,
        int $unitTypeId
    ): Builder {
        return $query->where('unit_type_id', $unitTypeId);
    }

    protected static function booted(): void
    {
        static::saving(function (House $house) {

            match ($house->status) {

                'Occupied' => [
                    $house->is_occupied = true,
                    $house->is_available = false,
                ],

                'Vacant' => [
                    $house->is_occupied = false,
                    $house->is_available = true,
                ],

                'Reserved' => [
                    $house->is_occupied = false,
                    $house->is_available = false,
                ],

                'Maintenance', 'Unavailable' => [
                    $house->is_occupied = false,
                    $house->is_available = false,
                ],

                default => null,
            };

            if (
                $house->status === 'Occupied'
                && ! $house->occupied_since
            ) {
                $house->occupied_since = now();
            }

            if ($house->status !== 'Occupied') {
                $house->occupied_since = null;
            }
        });
    }
}
