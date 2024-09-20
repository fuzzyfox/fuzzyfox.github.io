<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>{{ config("app.name") }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
            rel="stylesheet"
        />

        <!-- Styles -->
        @vite("resources/css/app.css")

        @vite("resources/js/app.js")
    </head>
    <body class="font-sans antialiased">
        <aside class="flex justify-between border-b p-2 text-sm">
            <div class="flex items-center gap-2">
                @hasSection("home")
                    @yield("home")
                @else
                    <a href="/" aria-label="Home" class="block h-6 w-24">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 400 130"
                            class="block"
                        >
                            <use
                                xlink:href="{{ asset("logos/wduyck.svg") }}#svg"
                            />
                        </svg>

                        <span class="sr-only">William Duyck</span>
                    </a>
                @endif
            </div>

            <nav class="flex items-center">
                @foreach(\App\Models\Social::orderBy("sort")->orderBy("id")->get() as $social)
                    <x-ui.button
                        as="a"
                        size="icon"
                        variant="ghost"
                        href="{{ $social->url }}"
                        class="flex items-center"
                        aria-label="{{ $social->platform }}"
                    >
                        <x-icon
                            :name="$social->icon"
                            class="size-4"
                            @style(["color: " . $social->color => $social->color])
                        />
                    </x-ui.button>
                @endforeach
            </nav>
        </aside>

        @yield("body")
    </body>
</html>