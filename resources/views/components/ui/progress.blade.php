@props([
    "value" => 0,
    "max" => null,
])

@php
    $state = is_null($value) ? "indeterminate" : ($value === $max ? "complete" : "loading");
@endphp

<x-ui.progress.root :max="$max">
    <x-ui.progress.indicator :value="$value" :max="$max" :state="$state" />
</x-ui.progress.root>
