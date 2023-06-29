<x-layouts.project-layout :project="$project" title="Baord detail">
    <div class="items-start grid grid-cols-4 gap-4 overflow-x-hidden">
        {{--TODO: we want the columns full availavle height with scrolling --}}
        {{-- TODO: we need to calculate max height and do ti that way? --}}
        {{--TODO: scroll in to view, or dosomething with Turbo? --}}
        <div class="full-body-scroll-column">
            <div class="mb-2">
                <input type="text" class="form-control w-full form-control-sm" placeholder="Search Boards on this Project" />
            </div>
            <div
                class="grid"
                hx-boost="true"
                data-controller="sortable"
                data-sortable-url-value="{{ route('projects.boards.sort', $project) }}"
            >
                @foreach($project->boards as $projectBoard)
                    {{--TODO: On click updated the url --}}
                    <a
                        href="{{ route('projects.boards.show', [$project->id, $projectBoard->id]) }}"
                        hx-get="{{ route('projects.boards.show', [$project->id, $projectBoard->id]) }}"
                        hx-target="#board-detail"
                        hx-swap="outerHTML"
                        hx-select="#board-detail"
                        hx-push-url="true"
                        title="{{ $projectBoard->name }}"
                        data-active-class="bg-purple-300 hover:bg-purple-400 dark:hover:bg-purple-900 dark:bg-purple-700"
                        data-inactive-class="hover:bg-zinc-200 dark:hover:bg-zinc-600"
                        data-sortable-target="item"
                        data-id="{{$projectBoard->id}}"
                        class="{{ $loop->last ? '' : 'mb-1' }} p-1 rounded-md truncate"
                        {{ $projectBoard->id === $board->id ? 'data-scroll-into-view=1' : '' }}
                    >
                        <span class="flex items-center">
                            <span>{{ $projectBoard->name }}</span>
                        </span>
                        @include('boards._count-box', ['board' => $projectBoard])
                    </a>
                @endforeach
            </div>
        </div>
        <div class="col-span-3 full-body-scroll-column h-full" id="board-detail">
            <div class="well w-full">
                <div class="text-lg border-b font-semibold mb-3">{{ $board->name }}</div>
                <div class="">
                    comments, files, tasks on board all that jazz goes here in a scrolling way
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
