<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'tenant_code',

        'national_id',
        'date_of_birth',
        'gender',

        'phone',
        'alternative_phone',
        'email',

        'profile_photo',

        'address',

        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',

        'occupation',
        'employer',

        'status',

        'move_in_date',
        'move_out_date',

        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'move_in_date' => 'date',
            'move_out_date' => 'date',
        ];
    }

    public function getFullNameAttribute(): string
    {
        return trim(
            $this->first_name . ' ' .
            ($this->middle_name ? $this->middle_name . ' ' : '') .
            $this->last_name
        );
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->full_name . ' (' . $this->tenant_code . ')';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isFormer(): bool
    {
        return $this->status === 'former';
    }

    public function isBlacklisted(): bool
    {
        return $this->status === 'blacklisted';
    }

    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth?->age;
    }

    public function getProfilePhotoUrlAttribute(): ?string
    {
        if (!$this->profile_photo) {
            return null;
        }

        return asset('storage/' . $this->profile_photo);
    }
}