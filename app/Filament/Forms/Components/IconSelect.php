<?php

namespace App\Filament\Forms\Components;

use App\Models\Icon;
use Filament\Forms\Components\Select;

class IconSelect extends Select
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->searchable()
            ->getSearchResultsUsing(fn (string $search): array => Icon::query()
                ->where('id', 'like', "%{$search}%")
                ->get()
                ->mapWithKeys(fn (Icon $icon) => [
                    $icon->id => svg($icon->id, attributes: ['style' => 'height: 1.4em; width: 1.4em; margin-right: 1ch; display: inline-block;'])->toHtml().' '.$icon->id,
                ])
                ->toArray())
            ->getOptionLabelUsing(function ($value): ?string {
                $icon = Icon::find($value);

                if (! $icon) {
                    return null;
                }

                return svg($icon->id, attributes: ['style' => 'height: 1.4em; width: 1.4em; margin-right: 1ch; display: inline-block;'])->toHtml().' '.$icon->id;
            })
            ->allowHtml()
            ->native(false);
    }
}
