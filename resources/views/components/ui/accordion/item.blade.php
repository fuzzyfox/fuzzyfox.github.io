@props([
    "as" => "div",
])

@php
    $classes = \TailwindMerge\TailwindMerge::instance()->merge(
        "border-b",
        $attributes->get("class"),
    );
@endphp

<{!! $as !!}
    {!! $attributes->except(["class"]) !!}
    class="{{ $classes }}"
    x-data="{ id: $id('accordion') }"
    x-bind:data-state="activeAccordion == id ? 'open' : 'closed'"
>
    {{ $slot }}
</{!! $as !!}>
