@props([
    "skill",
    "years" => false,
    "level" => false,
])

<div {!! $attributes !!}>
    <div class="mb-2 flex items-center gap-2">
        @if ($skill->icon)
            <x-icon
                :name="$skill->icon"
                class="size-6"
                @style(["color: " . $skill->color => $skill->color])
            />
        @endif

        <h3 class="text-lg font-medium">
            {{ $skill->name }}
            @if ($level && $skill->level)
                <small class="self-end text-muted-foreground">
                    {{ $skill->level->getLabel() }}
                </small>
            @endif
        </h3>

        @if ($years && $skill->years_of_experience)
            <small class="ml-auto self-end text-muted-foreground">
                {{ $skill->years_of_experience < 5 ? $skill->years_of_experience : floor($skill->years_of_experience / 5) * 5 . "+" }}
                yrs
            </small>
        @endif
    </div>

    <x-ui.progress.root>
        <x-ui.progress.indicator
            :value="$skill->rank * 100"
            :max="100"
            @style(["background-color: " . $skill->color => $skill->color])
        />
    </x-ui.progress.root>
</div>
