@extends("layout")

@section("home")
    <x-ui.button
        as="a"
        variant="ghost"
        size="sm"
        href="https://github.com/fuzzyfox/fuzzyfox.github.io/#readme"
        aria-label="Site Version / View Source Code"
    >
        v{{ config("app.version", "7.0.0") }}
    </x-ui.button>
@endsection

@section("body")
    <header class="border-b p-10 md:p-20 lg:p-40">
        <h1 class="sr-only">William Duyck</h1>

        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 2000 350"
            class="hidden md:block"
        >
            <use xlink:href="{{ asset("logos/william-duyck.svg") }}#svg" />
        </svg>

        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 400 130"
            class="block md:hidden"
        >
            <use xlink:href="{{ asset("logos/wduyck.svg") }}#svg" />
        </svg>
    </header>

    <section
        class="relative border-b px-4 py-6 md:px-6 md:py-10"
        x-data="{ expanded: false }"
    >
        <div class="container">
            <h2
                class="mb-6 text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl"
            >
                Skills
            </h2>

            <div
                class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3"
                x-show="expanded"
                x-collapse.min.300px.duration.700ms
            >
                @foreach(\App\Models\Skill::promoted()->get()->sortByDesc("rank") as $skill)
                    <x-cv.skill :skill="$skill" />
                @endforeach
            </div>

            @if (\App\Models\Skill::notPromoted()->count())
                <x-ui.button
                    as="a"
                    variant="outline"
                    href="{{ route('skills.index') }}"
                    x-show="expanded"
                    class="mt-4"
                >
                    Show All Skills
                </x-ui.button>
            @endif
        </div>

        <x-ui.button
            variant="outline"
            size="sm"
            @click="expanded = true"
            x-show="!expanded"
            class="mx-auto -mb-10 flex md:-mb-14"
        >
            Show More
        </x-ui.button>
    </section>

    <section class="px-4 py-6 md:px-6 md:py-10">
        <div class="container">
            <h2
                class="mb-6 text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl"
            >
                Work Experience
            </h2>

            <div class="grid gap-6">
                @foreach(\App\Models\Position::orderBy("start_date", "desc")->get() as $position)
                    <x-cv.position :position="$position" />
                @endforeach
            </div>
        </div>
    </section>
@endsection
