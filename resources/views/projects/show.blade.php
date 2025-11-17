@use('App\Models\Position')
@use('Illuminate\Support\Facades\Storage')
@use('Illuminate\Support\Str')

@php /** @var $project Position */ @endphp

@extends('layout')

@section('body')
    <main>
        <header class="min-h-[33.333svh] border-b flex" @style([
            'background-image: url('.Storage::disk('public')->url($project->header_image).');' => $project->header_image,
            'background-position: center;' => $project->header_image,
            'background-size: cover;' => $project->header_image,
            'background-color: '.$project->header_color.';' => $project->header_color,
        ])>
            <div class="container self-end">
                <div class="md:max-w-[66.666%] md:w-fit pt-3 px-4 -ml-4 -mb-0.5 leading-none border border-b-0 bg-background rounded-t-xl">
                    <h1 class="scroll-m-20 text-4xl font-extrabold tracking-tight lg:text-5xl">
                        {{ $project->name }}
                    </h1>
                    @if($project->url)
                        <a href="{{ $project->url }}" class="text-muted-foreground hover:text-primary transition-colors">
                            {{ Str::after($project->url, '://') }}
                        </a>
                    @endif
                </div>
            </div>
        </header>

        <section class="container prose-base py-8">
            {!! Str::markdown($project->description) !!}
        </section>

        <section class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 container mx-auto py-12">
            <h2 class="scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight first:mt-0 col-span-full">
                Skills
            </h2>
            @foreach($project->skills->sortByDesc(['rank']) as $skill)
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
