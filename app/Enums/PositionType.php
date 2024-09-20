<?php

namespace App\Enums;

use App\Enums\Concerns\Jsonable;
use Filament\Support\Contracts\HasLabel;
use JsonSerializable;

enum PositionType implements HasLabel, JsonSerializable
{
    use Concerns\HasLabel;
    use Jsonable;

    case FullTime;
    case PartTime;
    case Contract;
    case Intern;
    case Freelance;

    const DEFAULT = self::FullTime;
}
