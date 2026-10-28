<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Block extends Model
{
    use HasFactory;

    protected $fillable = [
        'estate_id',
        'name',
        'code',
        'description',
        'total_floors',
        'total_units',
        'status',
        'created_by',
        'updated_by',
    ];

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }

    public function floors()
    {
        return $this->hasMany(Floor::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}