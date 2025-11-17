<?php

namespace App\Enums;

use App\Enums\Concerns\Jsonable;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use JsonSerializable;

enum PositionType implements HasColor, HasIcon, HasLabel, JsonSerializable
{
    use Concerns\HasLabel;
    use Jsonable;

    case FullTime;
    case PartTime;
    case Contract;
    case Intern;
    case Freelance;

    const DEFAULT = self::FullTime;

    public function getColor(): string|array|null
    {
        $colors = array_values(Color::all());

        $nameHash = crc32($this->name);
        $colorIndex = abs($nameHash) % count($colors);

        return $colors[$colorIndex];
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::FullTime => 'lucide-briefcase',
            self::PartTime => 'lucide-bell-electric',
            self::Contract => 'lucide-signature',
            self::Intern => 'lucide-graduation-cap',
            self::Freelance => 'lucide-coffee',
        };
    }
}
