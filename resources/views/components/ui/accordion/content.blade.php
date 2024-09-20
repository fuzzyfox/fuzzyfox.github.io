@props([
    "as" => "div",
])

@php
    $classes = \TailwindMerge\TailwindMerge::instance()->merge(
        "pb-4",
        $attributes->get("class"),
    );
@endphp

<{!! $as !!}
    {!! $attributes->except(["class"]) !!}
    class="overflow-hidden text-sm"
    x-show="activeAccordion == id"
    x-bind:data-state="activeAccordion == id ? 'open' : 'closed'"
    x-collapse
    x-cloak
>
    <div class="{{ $classes }}">{{ $slot }}</div>
</{!! $as !!}>
