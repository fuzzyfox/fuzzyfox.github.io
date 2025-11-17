@use('App\Models\Position')
@use('App\Models\Project')
@use('Illuminate\Support\Facades\Storage')
@use('Illuminate\Support\Str')

@php /** @var $project Position */ @endphp

@extends('layout')

@section('body')
    <main>
        @foreach(Project::with(['skills'])->latest()->get() as $project)
            <section class="py-8 md:*:even:flex-row-reverse">
                <div class="container flex flex-col gap-12 md:flex-row items-center">
                    <img
                        src="{{Storage::disk('public')->url($project->feature_image)}}"
                        alt="Feature image"
                        class="flex-none object-center object-cover rounded-md max-h-64 bg-secondary w-full md:w-1/4 md:h-96 md:max-h-96 border"
                        @style(['background-color: ' . $project->header_color => $project->header_color])
                    >

                    <div class="grow">
                        <h2 class="text-balance text-3xl font-medium md:text-5xl">
                            {{ $project->name }}
                        </h2>

                        <div class="mt-1 text-muted-foreground md:mt-6 prose-base">
                            {!! Str::markdown($project->summary ?: Str::words($project->description, 40)) !!}
                        </div>

                        <x-ui.button as="a" variant="outline"
                                     :href="route('projects.show', ['project' => $project])" class="mt-6">
                            Learn more
                            <x-lucide-chevron-right class="ml-2 size-4"/>
                        </x-ui.button>

                        <ul class="mt-10 flex-wrap items-center gap-6 flex gap-y-3">
                            @foreach($project->skills as $skill)
                                <li class="flex items-center gap-2 m-0">
                                    @if ($skill->icon)
                                        <x-icon :name="$skill->icon"
                                                class="size-4" @style(['color: ' . $skill->color => $skill->color]) />
                                    @endif
                                    {{ $skill->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </section>
        @endforeach
    </main>
@endsection
