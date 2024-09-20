<?php

namespace App\Enums\Concerns;

use BackedEnum;

trait Jsonable
{
    public function jsonSerialize(): int|string
    {
        if ($this instanceof BackedEnum) {
            return $this->value;
        }

        return $this->name;
    }
}
