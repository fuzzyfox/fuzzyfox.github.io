@props([
    "value" => 0,
    "max" => null,
])

@php
    $state = is_null($value) ? "indeterminate" : ($value === $max ? "complete" : "loading");
@endphp

@php
    $classes = \TailwindMerge\TailwindMerge::instance()->merge(
        "relative h-4 w-full overflow-hidden rounded-full bg-secondary",
        $attributes->get("class"),
    );
@endphp

<div
    {!! $attributes->except(["class"]) !!}
    class="{{ $classes }}"
    aria-valuemax="{{ $max }}"
    aria-valuemin="0"
    aria-valuenow="{{ $value }}"
    aria-valuetext="{{ $max ? round(($value / $max) * 100) : null }}"
    role="progressbar"
    data-state="{{ $state }}"
    data-value="{{ $value }}"
    data-max="{{ $max }}"
>
    {{ $slot }}
</div>
