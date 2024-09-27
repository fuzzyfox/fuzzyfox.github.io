@php
/** @var $positon \App\Models\Position */
@endphp

@extends('layout')

@section('body')
    <main>
        <section class="sm:py-24 border-b" @style([
            'background-image: url('.\Illuminate\Support\Facades\Storage::disk('public')->url($position->header_image).');' => $position->header_image,
            'background-position: center;' => $position->header_image,
            'background-size: cover;' => $position->header_image,
            'background-color: '.$position->header_color.';' => $position->header_color,
        ])>
            <div class="sm:container">
                <x-cv.position :position="$position" class="p-8 bg-background/75 sm:rounded-lg" />
            </div>
        </section>

        <section class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 container mx-auto py-12">
            @foreach($position->skills->sortByDesc(['rank']) as $skill)
                <x-cv.skill
                    :id="$skill->slug"
                    :x-ref="$skill->slug"
                    :skill="$skill"
                    :years="true"
                    :level="true"
                    :link="true"
                />
            @endforeach
        </section>
    </main>
@endsection
