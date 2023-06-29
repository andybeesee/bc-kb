<x-app-layout title="Team">
    <div class="container">
        <h1>{{ $team->name }}</h1>
        <div class="sub-nav mb-5">
            <a class="link" href="{{ route('admin.teams.edit', $team) }}">Edit</a>
        </div>

        <div class="flex flex-col md:flex-row items-start md:space-x-4 md:w-2/3">
            <div class="mb-4 sm:mb-0 flex-grow">
                @if($newMemberOptions->count() > 0)
                    @include('admin.teams.members._create')
                @endif
            </div>

            <div class="flex-grow card">
                <div class="card-title">Current Members</div>
                <div class="divide-y divide-zinc-300 flex-grow">
                    @foreach($team->members->sortBy('name') as $member)
                        @include('admin.teams.members._show')
                    @endforeach
                </div>
            </div>

        </div>


    </div>
</x-app-layout>
