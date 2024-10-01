<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>{{ config("app.name") }}</title>

        <!-- Favicon -->
        <link
            rel="apple-touch-icon"
            sizes="180x180"
            href="/favicon/apple-touch-icon.png"
        />
        <link
            rel="icon"
            type="image/png"
            sizes="32x32"
            href="/favicon/favicon-32x32.png"
        />
        <link
            rel="icon"
            type="image/png"
            sizes="16x16"
            href="/favicon/favicon-16x16.png"
        />
        <link rel="manifest" href="/favicon/site.webmanifest" />
        <link
            rel="mask-icon"
            href="/favicon/safari-pinned-tab.svg"
            color="#434c5e"
        />
        <link rel="shortcut icon" href="/favicon/favicon.ico" />
        <meta name="msapplication-TileColor" content="#434c5e" />
        <meta
            name="msapplication-config"
            content="/favicon/browserconfig.xml"
        />
        <meta name="theme-color" content="#ffffff" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
            rel="stylesheet"
        />

        <!-- Styles -->
        @vite("resources/css/app.css")

        <!-- Scripts -->
        @vite("resources/js/app.js")
    </head>
    <body class="p-8 font-sans antialiased">
        <header class="container flex items-end gap-x-8 border-b pb-6">
            <div>
                <h1
                    class="scroll-m-20 text-4xl font-extrabold tracking-tight lg:text-5xl"
                >
                    <div class="max-h-24 max-w-[300px] print:max-w-[180px]">
                        {!! \Illuminate\Support\Facades\File::get(base_path("public/logos/william-duyck.svg")) !!}
                    </div>
                </h1>
                <p class="text-xl print:text-base print:text-nowrap text-muted-foreground">
                    Turning complex challenges into elegant software solutions.
                </p>
            </div>

            <div class="text-muted-foreground text-sm columns-3">
                @foreach(\App\Models\Social::orderBy("sort")->get() as $social)
                    <a href="{{ $social->url }}" rel="noopener" target="_blank" class="flex items-center hover:text-accent-foreground mb-2">
                        <x-icon
                            :name="$social->icon"
                            class="size-4 mr-2 text-primary flex-shrink-0"
                            @style(["color: " . $social->color => $social->color])
                        />
                        {{ \Illuminate\Support\Str::after($social->url, '://') }}
                    </a>
                @endforeach
            </div>
        </header>

        <section class="container py-8 print:py-3 border-b">
            {{-- TODO: Store in sqlite for editing using filament? --}}
            <p>
                An experienced full-stack software engineer and consultant with a passion for solving complex challenges
                that create real-world impact. With a broad-spectrum understanding of technical problems across various
                domains, I guide projects from ideation to implementation, empowering cross-functional teams to navigate
                technical challenges and enhance collaboration. I specialize in creating scalable solutions that improve
                user and developer experience with streamline processes. I thrive in dynamic projects that offer variety
                and innovation, especially those with a public benefit, such as my work on web literacy with the
                Mozilla Foundation.
            </p>
        </section>

        <section class="container py-8 print:py-5 border-b">
            <div class="grid gap-6">
                @foreach(\App\Models\Position::orderBy("start_date", "desc")->get() as $idx => $position)
                    <x-cv.position :position="$position" :no-description="$idx > 3" />
                @endforeach
            </div>
        </section>

        <section class="container grid grid-cols-1 gap-6 print:gap-3 sm:grid-cols-2 lg:grid-cols-3 print:grid-cols-3 py-8 print:py-5 border-b">
            @foreach(\App\Models\Skill::promoted()->get()->sortByDesc("rank") as $skill)
                <x-cv.skill :skill="$skill" level years track-class="print:h-3"/>
            @endforeach
        </section>

        <section class="container py-8 print:py-5">
            {{-- TODO: Convert into model (Education) --}}
            <header class="flex items-center gap-4">
                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url("positions/logos/01J8PY8J7EZYS98F74HH0HXQQ0.svg") }}" alt="University of Kent logo" class="block size-14 text-xs rounded bg-secondary">

                <div>
                    <h3 class="text-lg font-medium">
                        University Of Kent
                        <small class="text-muted-foreground">First Class Hon. BSc</small>
                    </h3>

                    <div class="text-sm text-muted-foreground">
                        Computer Science w/ Year in Industry | 2011 - 2015
                    </div>
                </div>
            </header>

            <p class="text-muted-foreground mt-4 print:mt-2">
                Completed a comprehensive Computer Science program, with a focus on software engineering, algorithms,
                and databases. Gained practical experience during a year-long industry placement at the Mozilla Foundation,
                applying skills to real-world challenges and web literacy projects. Developed strong technical,
                problem-solving, teamwork, and project management abilities.
            </p>
        </section>
    </body>
</html>
