<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'location',
        'description',
        'manager_name',
        'contact_phone',
        'contact_email',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }

    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }

    public function houses()
    {
        return $this->hasManyThrough(
            House::class,
            Block::class
        );
    }
}