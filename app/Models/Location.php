<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /** @use HasFactory<\Database\Factories\LocationFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'creator'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'creator');
    }

    public function characters()
    {
        return $this->hasMany(Character::class, 'location');
    }

    public function artifacts()
    {
        return $this->hasMany(Artifact::class, 'location');
    }
}
