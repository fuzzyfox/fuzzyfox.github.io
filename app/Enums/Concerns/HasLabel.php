<?php

namespace App\Enums\Concerns;

use BackedEnum;
use Illuminate\Support\Str;

trait HasLabel
{
    public function getLabel(): ?string
    {
        $label = ($this instanceof BackedEnum) ? $this->value : $this->name;

        return Str::of($label)->snake(' ')->apa()->toString();
    }
}
