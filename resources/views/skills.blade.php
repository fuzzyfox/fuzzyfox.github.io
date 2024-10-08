@extends("layout")

@section("body")
    <main class="container py-6">
        <h1
            class="mb-6 scroll-m-20 text-4xl font-extrabold tracking-tight lg:text-5xl"
        >
            Skills
        </h1>

        <section class="mb-10">
            <h2
                class="mb-4 scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight first:mt-0"
            >
                Key Skills
            </h2>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach(\App\Models\Skill::promoted()->get()->sortByDesc("rank") as $skill)
                    <x-cv.skill
                        as="a"
                        :skill="$skill"
                        :years="true"
                        :level="true"
                        :href="when(! $skill->parent_id, '#'.$skill->slug)"
                        :link="(bool) $skill->parent_id"
                    />
                @endforeach
            </div>
        </section>

        <section>
            <h2
                class="mb-4 scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight first:mt-0"
            >
                Additional Skills
            </h2>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach(\App\Models\Skill::with("children")->withCount("children")->whereNull("parent_id")->whereHas("children")->get()->sortByDesc(["rank", "children_count"]) as $skill)
                    <x-cv.skill
                        :id="$skill->slug"
                        :x-ref="$skill->slug"
                        :skill="$skill"
                        :years="true"
                        :level="true"
                        :link="true"
                        class="col-span-full"
                    />

                    <div
                        class="col-span-full -mt-8 grid grid-cols-1 gap-6 rounded-b-lg p-6 pt-8 sm:grid-cols-2 lg:grid-cols-3 bg-secondary"
                    >
                        @foreach($skill->descendants->sortByDesc("rank") as $child)
                            <x-cv.skill
                                :skill="$child"
                                :years="true"
                                :level="true"
                                :link="true"
                                track-class="bg-background"
                            />
                        @endforeach
                    </div>
                @endforeach

                @foreach(\App\Models\Skill::whereNull("parent_id")->whereDoesntHave("children")->get()->sortByDesc("rank") as $skill)
                    <x-cv.skill
                        :skill="$skill"
                        :years="true"
                        :level="true"
                        :link="true"
                    />
                @endforeach
            </div>
        </section>
    </main>
@endsection
