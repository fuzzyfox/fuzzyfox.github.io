@props([
    "as" => "div",
])

@php
    $classes = \TailwindMerge\TailwindMerge::instance()->merge(
        "",
        $attributes->get("class"),
    );
@endphp

<{!! $as !!}
    {!! $attributes->except(["class"]) !!}
    class="{{ $classes }}"
    x-data="{
        activeAccordion: '',
        setActiveAccordion(id) {
            this.activeAccordion = this.activeAccordion == id ? '' : id
        },
    }"
>
    {{ $slot }}
</{!! $as !!}>
