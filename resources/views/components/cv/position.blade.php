@props([
    "as" => 'div',
    "position",
    "noDescription" => false,
])

@php
    $classes = \TailwindMerge\TailwindMerge::instance()->merge(
        "flex flex-col gap-4 md:gap-3 print:gap-3",
        $attributes->get("class"),
    );
@endphp

<{!! $as !!}
    {!! $attributes->except('class') !!}
    class="{{ $classes }}"
>
    <div class="flex gap-4 items-center md:items-start print:items-start relative">
        @if ($position->company->logo)
            <img
                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($position->company->logo) }}"
                alt="{{ $position->company }} logo"
                class="block size-14 text-xs rounded bg-secondary sm:float-left"
            >
        @endif

        <div class="md:flex print:flex items-baseline gap-2">
            <h3 class="text-lg font-medium flex items-center lg:leading-tight">
                @if (!$position->company->logo)
                    <div class="h-2 w-2 rounded-full bg-primary block"></div>
                @endif
                {{ $position->title }}
            </h3>

            <div class="text-sm text-muted-foreground flex flex-wrap items-baseline lg:leading-tight">
                <span>{{ $position->company->name }}</span>
                <span class="border-l mx-[0.5ch] w-0 h-4 self-center"></span>
                <span class="whitespace-nowrap">
                    {{ $position->start_date->format("M Y") }}
                    @if ($position->end_date)
                        - {{ $position->end_date->format("M Y") }}
                    @else
                        - Present
                    @endif
                </span>
            </div>
        </div>
    </div>

    @if ($position->skills->isNotEmpty())
        <div class="flex flex-wrap gap-2 md:-mt-9 md:ml-[4.5rem] md:z-10">
            @foreach ($position->skills->sortByDesc("rank")->take(9) as $skill)
                <x-ui.badge variant="secondary">
                    {{ $skill->name }}
                </x-ui.badge>
            @endforeach

            @if ($position->skills->count() > 9)
                <x-ui.badge :as="$as === 'a' ? 'div' : 'a'" :href="route('positions.show', ['position' => $position->getRouteKey()])" variant="outline" class="text-muted-foreground hover:bg-secondary hover:border-transparent hover:text-primary transition-colors">
                    +{{ $position->skills->count() - 9 }} more
                </x-ui.badge>
            @endif
        </div>
    @endif

    @if (! $noDescription && $position->description)
        <p class="text-muted-foreground">
            {!! \Illuminate\Support\Str::inlineMarkdown($position->description) !!}
        </p>
    @endif
</{!! $as !!}>
