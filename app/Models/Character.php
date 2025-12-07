<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    /** @use HasFactory<\Database\Factories\CharacterFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location',
        'image',
        'creator'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'creator');
    }

    public function artifacts()
    {
        return $this->hasMany(Artifact::class, 'owner');
    }
    
    public function location()
    {
        return $this->belongsTo(Location::class, 'location') ?? 'Lost';
    }
}
