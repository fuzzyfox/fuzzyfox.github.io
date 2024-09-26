@props([
    "position",
])

<div class="clear-both">
    @if ($position->logo)
        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($position->logo) }}" alt="{{ $position->company }} logo" class="block size-14 text-xs float-left rounded bg-secondary mr-4 mb-4 sm:mb-2">
    @endif

    <div class="flex flex-wrap items-end gap-2">
        <h3 class="text-lg font-medium flex items-center gap-2">
            @if (!$position->logo) <div class="h-2 w-2 rounded-full bg-primary block"></div> @endif
            {{ $position->title }}
        </h3>
        <div class="text-sm text-muted-foreground">
            {{ $position->company }} |
            {{ $position->start_date->format("M Y") }}
            @if ($position->end_date)
                - {{ $position->end_date->format("M Y") }}
            @else
                - Present
            @endif
        </div>
    </div>

    @if ($position->skills->isNotEmpty())
        <div class="flex flex-wrap gap-2 mt-4 sm:mt-2">
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
        <p class="text-muted-foreground mt-2">
            {!! \Illuminate\Support\Str::inlineMarkdown($position->description) !!}
        </p>
    @endif
</div>
