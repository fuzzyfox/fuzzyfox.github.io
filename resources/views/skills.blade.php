@use('App\Models\Skill')

@extends("layout")

@section("body")
    <main class="container py-16 flex flex-col gap-16">
        <div class="grid grid-cols-1 gap-16 sm:grid-cols-2 lg:grid-cols-3">
            @foreach(Skill::with("children")->withCount("children")->whereNull("parent_id")->whereHas("children")->get()->sortByDesc(["rank", "children_count"]) as $skill)
                <div class="col-span-full">
                    <x-cv.skill
                        :id="$skill->slug"
                        :x-ref="$skill->slug"
                        :skill="$skill"
                        :years="true"
                        :level="true"
                        :link="true"
                    />

                    <div
                        class="grid grid-cols-1 gap-6 rounded-b-lg -mt-2 p-6 pt-8 sm:grid-cols-2 lg:grid-cols-3 bg-secondary"
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
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach(Skill::whereNull("parent_id")->whereDoesntHave("children")->get()->sortByDesc("rank") as $skill)
                <x-cv.skill
                    :skill="$skill"
                    :years="true"
                    :level="true"
                    :link="true"
                />
            @endforeach
        </div>
    </main>
@endsection
