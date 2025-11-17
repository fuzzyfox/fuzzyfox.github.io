@use('TailwindMerge\TailwindMerge')

@props([
    "as" => "div",
    "decorative" => null,
    "orientation" => "horizontal"
])

@php
    $classes = TailwindMerge::instance()->merge(
        "shrink-0 bg-border",
        $orientation === 'horizontal' ? 'h-[1px] w-full' : 'h-full w-[1px]',
        $attributes->get("class"),
    );
@endphp

@php
    $attributes->merge([
        'data-orientation' => $orientation,
        'role' => $decorative ? 'none' : 'separator',
    ]);

    if ($decorative) {
        $attributes->merge(['aira-orientation' => when($orientation === 'vertical', $orientation)]);
    }
@endphp

<{!! $as !!}
    {!! $attributes->except(["class"]) !!}
    class="{{ $classes }}"
>
{{ $slot }}
</{!! $as !!}>
