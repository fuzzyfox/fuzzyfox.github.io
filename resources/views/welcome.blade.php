@use('App\Models\Position')
@use('App\Models\Skill')
@use('Illuminate\Support\Str')

@extends("layout")

@section("body")
    <header class="relative overflow-hidden h-64 sm:h-96 sm:min-h-[50svh]">
        <h1 class="sr-only">William Duyck</h1>

        <div
            class="sm:absolute left-0 z-20 h-full w-3/5 bg-[linear-gradient(to_right,hsl(var(--background))_75%,transparent_100%)] sm:flex sm:flex-col sm:pl-8 md:pl-16 justify-center"
        ></div>

        <div
            class="sm:absolute bottom-0 z-20 h-16 w-full bg-[linear-gradient(to_top,hsl(var(--background))_25%,transparent_100%)] sm:flex sm:flex-col sm:pl-8 md:pl-16 justify-center"
        ></div>

        <div
            class="z-10 opacity-10 sm:opacity-100 flex flex-col gap-8 md:gap-10 -translate-x-1/2 left-1/2 bottom-1/2 translate-y-1/2 absolute animate-in duration-1000 transition-all"
            x-init="Array.from($el.children).sort(() => Math.random() - 0.5).forEach(item => $el.appendChild(item))">
            @foreach(($skills = Skill::whereNotNull(['icon'])->get()->sortByDesc('rank')->take(99))->shuffle()->chunk(ceil($skills->count() / 5)) as $line)
                <div
                    class="flex gap-8 md:gap-x-16 odd:-translate-x-4 even:translate-x-4 md:odd:-translate-x-8 md:even:translate-x-8 transition-all duration-1000"
                    x-init="Array.from($el.children).sort(() => Math.random() - 0.5).forEach(item => $el.appendChild(item))">
                    @foreach($line as $skill)
                        <div
                            @class([
                                "size-8 sm:size-16 transition-all duration-1000 shrink-0 rounded md:rounded-md shadow-lg",
                                'text-white' => $skill->color,
                                'bg-background' => ! $skill->color
                            ])
                            @style(["background-color: " . $skill->color => $skill->color])
                        >
                            <div class="size-full bg-muted/20 p-2 flex items-center justify-center">
                                <x-icon :name="$skill->icon" class="max-w-full max-h-full"/>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div
            class="container absolute inset-0 z-30 sm:relative h-full flex flex-col items-center sm:items-start justify-center">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 2000 350"
                class="hidden md:block z-20 w-2/5"
            >
                <use xlink:href="{{ asset("logos/william-duyck.svg") }}#svg"/>
            </svg>

            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 400 130"
                class="block md:hidden z-20 w-1/2"
            >
                <use xlink:href="{{ asset("logos/wduyck.svg") }}#svg"/>
            </svg>
            <h2 class="text-lg tracking-wide hidden sm:block sm:pl-4 md:pl-0 font-light text-pretty w-1/2">
                Empowering the web, one line of code at a time.
            </h2>
        </div>
    </header>

    {{-- Skills --}}
    <section class="container pt-16 pb-32">
        <h2
            class="scroll-m-20 pb-2 text-3xl font-semibold tracking-tight transition-colors first:mt-0"
        >
            Skills
        </h2>


        <p class="text-lg sm:text-xl text-muted-foreground mb-6">
            Over the years, I have acquired and honed a diverse variety of skills. Each skill represents a milestone
            in my journey of continuous learning and professional growth. Here's a small selection of what I'm
            able to bring to the table.
        </p>

        <div
            class="grid grid-cols-1 gap-3 sm:gap-6 sm:grid-cols-2 lg:grid-cols-3 print:grid-cols-3"
            x-show="expanded"
            x-collapse.min.300px.duration.700ms
        >
            @foreach(Skill::promoted()->get()->sortByDesc("rank") as $skill)
                <x-cv.skill :skill="$skill" track-class="h-2"/>
            @endforeach

            @if (Skill::notPromoted()->count())
                <div class="flex items-end justify-end">
                    <small class="text-muted-foreground">Full list at <a
                            href="{{ config('app.url').route('skills.index', absolute: false) }}"
                            class="text-primary hover:text-current transition-colors">{{ Str::after(config('app.url').route('skills.index', absolute: false), '://') }}</a></small>
                </div>
            @endif
        </div>
    </section>

    {{-- Values & Principles --}}
    <section class="container grid gap-8 lg:grid-cols-3 py-32">
        <h2 class="row-span-2 text-3xl font-semibold lg:text-5xl">
            Values and Principles
        </h2>
        <div>
            <h3 class="mb-2 text-xl font-medium">Impact-Driven Innovation</h3>
            <p class="text-muted-foreground">
                I believe in creating solutions that not only solve technical
                challenges but also make a real-world difference for people
                and businesses.
            </p>
        </div>
        <div>
            <h3 class="mb-2 text-xl font-medium">Collaboration and Empowerment</h3>
            <p class="text-muted-foreground">
                By fostering teamwork and enabling others, I ensure that every
                project benefits from diverse perspectives and skills, leading
                to better outcomes.
            </p>
        </div>
        <div>
            <h3 class="mb-2 text-xl font-medium">Continuous Improvement</h3>
            <p class="text-muted-foreground">
                Stagnation is the enemy of progress. I am committed to evolving
                processes and myself, constantly striving to improve code quality,
                team dynamics, and user experiences.
            </p>
        </div>
        <div>
            <h3 class="mb-2 text-xl font-medium">Integrity and Accountability</h3>
            <p class="text-muted-foreground">
                I hold myself to high ethical standards in both personal and
                professional life, taking responsibility for delivering on
                promises and being transparent in my work.
        </div>
    </section>

    {{-- Experience --}}
    <section class="container py-32">
        <h2
            class="scroll-m-20 pb-2 text-3xl font-semibold tracking-tight transition-colors first:mt-0 mb-6"
        >
            Work Experience
        </h2>

        <div class="grid gap-8">
            @foreach(Position::orderBy("start_date", "desc")->get() as $idx => $position)
                <x-cv.position
                    as="a"
                    href="{{ route('positions.show', ['position' => $position]) }}"
                    :position="$position"
                    :no-description="$idx >= 3"
                    @class(['mb-8' => $idx < 3])
                />
            @endforeach
        </div>
    </section>
@endsection
