@props([
    "value" => 0,
    "max" => null,
    "state" => "indeterminate",
])

@php
    $percentage = 100 - $value;
@endphp

@php
    $classes = \TailwindMerge\TailwindMerge::instance()->merge(
        "h-full w-full flex-1 bg-primary transition-all rounded-full",
        $attributes->get("class"),
    );
@endphp

<div
    {!! $attributes->except(["class", "style"]) !!}
    class="{{ $classes }}"
    @style(["transform: translateX(-$percentage%)", $attributes->get("style")])
    data-state="{{ $state }}"
    data-value="{{ $value }}"
    data-max="{{ $max }}"
></div>
