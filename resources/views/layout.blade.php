<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>{{ config("app.name") }}</title>

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png" />
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png" />
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png" />
        <link rel="manifest" href="/favicon/site.webmanifest" />
        <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#434c5e" />
        <link rel="shortcut icon" href="/favicon/favicon.ico" />
        <meta name="msapplication-TileColor" content="#434c5e" />
        <meta name="msapplication-config" content="/favicon/browserconfig.xml" />
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
    <body class="font-sans antialiased">

        @yield("body")

    @hasSection("footer")
        @yield("footer")
    @else
        <footer class="pt-32 container pb-8">
            <section class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <a href="{{ route('home') }}">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 400 130"
                        class="mb-8 mr-auto h-7 md:mb-0"
                    >
                        <use xlink:href="{{ asset("logos/wduyck.svg") }}#svg"/>
                    </svg>
                </a>

                <div class="flex flex-col gap-4 md:flex-row md:items-center">
                    <p
                        x-data="{
                            tagline: $el.textContent,
                            taglines: [
                                'I code for people, not for machines.',
                                'Crafting code that empowers people.',
                                'Working to make the web a better place for all.',
                                'Making things, and doing stuff, since 2005.',
                                'Mozilla Alum.',
                                'Open Source Enthusiast.',
                            ],
                            init() {
                                setInterval(() => {
                                    this.tagline = this.taglines[Math.floor(Math.random() * this.taglines.length)];
                                }, 5_000);
                            },
                        }"
                        class="text-lg font-medium"
                        x-text="tagline"
                    >
                        I code for people, not for machines.
                    </p>
                </div>
            </section>

            <x-ui.separator class="mt-8 mb-14" />

            <nav class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                <div>
                    <h3 class="mb-4 font-bold">Portfolio</h3>
                    <ul class="space-y-4 text-muted-foreground">
                        <li class="font-medium hover:text-primary transition-colors">
                            <a href="{{ route('skills.index') }}">Skills</a>
                        </li>
                        <li class="font-medium hover:text-primary transition-colors">
                            <a href="{{ route('projects.index') }}">Projects</a>
                        </li>
                        <li class="font-medium hover:text-primary transition-colors">
                            <a href="https://github.com/fuzzyfox" target="_blank" rel="noopener" class="inline-flex items-center">Open Source <x-lucide-external-link class="size-4 ml-1"/></a>
                        </li>
{{--                        <li class="font-medium hover:text-primary transition-colors">--}}
{{--                            <a href="#">Testimonials</a>--}}
{{--                        </li>--}}
                    </ul>
                </div>

                <div>
                    <h3 class="mb-4 font-bold">About Me</h3>
                    <ul class="space-y-4 text-muted-foreground">
                        <li class="font-medium hover:text-primary transition-colors">
                            <a href="https://ghost.wduyck.me" rel="noopener" class="inline-flex items-center">Blog <x-lucide-external-link class="size-4 ml-1"/></a>
                        </li>
                        <li class="font-medium hover:text-primary transition-colors">
                            <a href="{{ route('cv') }}">Resumé</a>
                        </li>
{{--                        <li class="font-medium hover:text-primary transition-colors">--}}
{{--                            <a href="#">Contact</a>--}}
{{--                        </li>--}}
                    </ul>
                </div>

                <div>
{{--                    <h3 class="mb-4 font-bold">Resources</h3>--}}
{{--                    <ul class="space-y-4 text-muted-foreground">--}}
{{--                        <li class="font-medium hover:text-primary transition-colors">--}}
{{--                            <a href="#">Guides</a>--}}
{{--                        </li>--}}
{{--                        <li class="font-medium hover:text-primary transition-colors">--}}
{{--                            <a href="#" rel="noopener">Presentations</a>--}}
{{--                        </li>--}}
{{--                        <li class="font-medium hover:text-primary transition-colors">--}}
{{--                            <a href="#">Links & Tools</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
                </div>

                <div>
                    <h3 class="mb-4 font-bold">Social</h3>
                    <ul class="flex flex-wrap items-center gap-6">
                        @foreach(\App\Models\Social::orderBy('sort')->get() as $social)
                            <li
                                class="font-medium opacity-55 hover:opacity-100 shrink-0 transition-opacity"
                                @style(['color: ' . $social->color => $social->color])
                            >
                                <a href="{{  $social->url }}" rel="noopener noreferrer" target="_blank">
                                    <x-icon :name="$social->icon" class="size-6"/>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </nav>

            <x-ui.separator class="mt-14 mb-8" />

            <section class="flex items-center justify-between text-sm text-muted-foreground">
                <p class="flex items-center gap-2">
                    <a
                        href="https://creativecommons.org/licenses/by-nc-sa/4.0/"
                        rel="noopener"
                        target="_blank"
                        class="inline-flex items-center gap-1 hover:text-primary transition-colors"
                        title="Attribution-NonCommercial-ShareAlike 4.0 International"
                    >
                        <span class="sr-only">CC BY-NC-SA</span>
                        <x-forkawesome-cc-cc class="size-4" />
                        <x-forkawesome-cc-by class="size-4" />
                        <x-forkawesome-cc-nc class="size-4" />
                        <x-forkawesome-cc-sa class="size-4" />
                    </a>
                    William Duyck
                </p>

                <a
                    href="https://github.com/fuzzyfox/fuzzyfox.github.io/#readme"
                    aria-label="Site Version / View Source Code"
                    class="text-muted-foreground hover:text-primary transition-colors"
                >
                    v{{ config("app.version", "7.0.0") }}
                </a>
            </section>
        </footer>
    @endif
    </body>
</html>
