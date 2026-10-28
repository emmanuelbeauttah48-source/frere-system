<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Facility extends Model
{
   
    protected $fillable = [
        'estate_id',
        'name',
        'code',
        'category',
        'description',
        'location',
        'floor',
        'block',
        'capacity',
        'is_bookable',
        'booking_fee',
        'last_maintenance',
        'next_maintenance',
        'is_available',
        'status',
        'image',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'capacity' => 'integer',
        'booking_fee' => 'decimal:2',
        'is_bookable' => 'boolean',
        'is_available' => 'boolean',
        'last_maintenance' => 'date',
        'next_maintenance' => 'date',
    ];

    public function estate(): BelongsTo
    {
        return $this->belongsTo(Estate::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}