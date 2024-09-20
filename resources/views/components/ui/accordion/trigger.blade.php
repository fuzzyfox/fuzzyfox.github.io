@props([
    "as" => "button",
])

@php
    $classes = \TailwindMerge\TailwindMerge::instance()->merge(
        "flex flex-1 items-center justify-between py-4 font-medium transition-all hover:underline [&[data-state=open]>svg]:rotate-180",
        $attributes->get("class"),
    );
@endphp

<x-ui.accordion.header>
    <{!! $as !!}
        {!! $attributes->except(["class"]) !!}
        @click="setActiveAccordion(id)"
        class="{{ $classes }}"
        x-bind:data-state="activeAccordion == id ? 'open' : 'closed'"
    >
        {{ $slot }}
        <x-lucide-chevron-down
            class="size-4 shrink-0 transition-transform duration-200"
        />
    </{!! $as !!}>
</x-ui.accordion.header>
