<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artifact extends Model
{
    /** @use HasFactory<\Database\Factories\ArtifactFactory> */
    use HasFactory;

      protected $fillable = [
        'name',
        'description',
        'location',
        'owner',
        'image',
        'creator'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'creator');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location') ?? 'Lost';
    }

    public function ownedBy()
    {
        return $this->belongsTo(Character::class, 'owner') ?? 'Unowned';
    }
}
