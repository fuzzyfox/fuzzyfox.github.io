<?php

namespace App\Models;

use App\Enums\SkillLevel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'is_promoted',
        'description',
        'start_year',
        'years_of_experience',
        'level',
        'icon',
        'color',
        'sort',
    ];

    protected function casts(): array
    {
        return [
            'is_promoted' => 'boolean',
            'level' => SkillLevel::class,
        ];
    }

    /**
     * @return BelongsTo<static, static>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return HasMany<static, static>
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * @return BelongsToMany<Position, static>
     */
    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class);
    }

    /**
     * @return Attribute<Collection<static>>
     */
    public function ancestors(): Attribute
    {
        return Attribute::get(function () {
            return $this->children
                ->loadMissing('children')
                ->flatMap(fn (Skill $child) => [$child, ...$child->ancestors])
                ->map(fn (Skill $child) => $child->unsetRelation('children'));
        });
    }

    public function rank(): Attribute
    {
        return Attribute::get(function () {
            $maxYearsExperience = now()->year - config('cv.min_year', 2005);

            $experienceScore = $this->years_of_experience ? min(($this->years_of_experience / ($maxYearsExperience)) * 0.25, 1) : 0;
            $levelScore = match ($this->level) {
                \App\Enums\SkillLevel::Beginner => 0.25,
                \App\Enums\SkillLevel::Intermediate => 0.40,
                \App\Enums\SkillLevel::Advanced => 0.60,
                \App\Enums\SkillLevel::Expert => 0.75,
                default => 0,
            };

            // Sum up the normalized scores
            $totalScore = $experienceScore + $levelScore;

            return min($totalScore, 1);  // Ensure the score does not exceed 1
        });
    }

    public function scopePromoted(Builder $builder, bool $promoted = true): Builder
    {
        return $builder->where('is_promoted', $promoted);
    }

    public function scopeNotPromoted(Builder $builder): Builder
    {
        return $this->scopePromoted($builder, false);
    }
}
