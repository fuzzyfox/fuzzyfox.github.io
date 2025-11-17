<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'url',
        'company_id',
        'description',
        'feature_image',
        'header_image',
        'header_color',
        'start_date',
        'end_date',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    /** @return BelongsTo<Company, static> */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /** @return BelongsToMany<Skill, static> */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class);
    }
}
