<?php

namespace App\Models;

use App\Enums\PositionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'company',
        'description',

        'type',

        'locality',
        'region',

        'start_date',
        'end_date',
    ];

    protected function casts(): array
    {
        return [
            'type' => PositionType::class,
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class);
    }
}
