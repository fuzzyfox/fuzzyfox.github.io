<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'url',

        'locality',
        'region',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /** @return HasMany<Position, static> */
    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }

    /** @return HasMany<Project, static> */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
