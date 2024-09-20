@props([
    "position",
])

<div class="grid gap-2">
    <div class="flex flex-wrap items-end gap-2">
        <h3 class="text-lg font-medium flex items-center gap-2">
            <div class="h-2 w-2 rounded-full bg-primary block"></div>
            {{ $position->title }}
        </h3>
        <div class="text-sm text-muted-foreground">
            {{ $position->company }} |
            {{ $position->start_date->format("M Y") }}@if ($position->end_date)- {{ $position->end_date->format("M Y") }}
            @endif
        </div>
    </div>

    @if ($position->skills->isNotEmpty())
        <div class="flex flex-wrap gap-2">
            @foreach ($position->skills->sortByDesc("rank")->take(9) as $skill)
                <x-ui.badge variant="secondary">
                    {{ $skill->name }}
                </x-ui.badge>
            @endforeach

            @if ($position->skills->count() > 9)
                <x-ui.badge variant="outline" class="text-muted-foreground">
                    +{{ $position->skills->count() - 9 }} more
                </x-ui.badge>
            @endif
        </div>
    @endif

    @if ($position->description)
        <p class="text-muted-foreground">
            {!! \Illuminate\Support\Str::inlineMarkdown($position->description) !!}
        </p>
    @endif
</div>
