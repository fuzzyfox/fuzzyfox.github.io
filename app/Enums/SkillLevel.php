<?php

namespace App\Enums;

use App\Enums\Concerns\Jsonable;
use Filament\Support\Contracts\HasLabel;
use JsonSerializable;

enum SkillLevel implements HasLabel, JsonSerializable
{
    use Concerns\HasLabel;
    use Jsonable;

    case Beginner;
    case Intermediate;
    case Advanced;
    case Expert;

    const DEFAULT = self::Beginner;
}
