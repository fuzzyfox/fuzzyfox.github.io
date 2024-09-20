@props([
    "as" => "div",
])

@php
    $classes = \TailwindMerge\TailwindMerge::instance()->merge(
        "flex",
        $attributes->get("class"),
    );
@endphp

<{!! $as !!}
    {!! $attributes->except(["class"]) !!}
    class="{{ $classes }}"
    x-bind:data-state="activeAccordion == id ? 'open' : 'closed'"
>
    {{ $slot }}
</{!! $as !!}>
