<x-layouts.project-layout :project="$project">
    all projects

    <div
        data-controller="sortable"
        data-sortable-handle-selector-value=".handle"
        data-sortable-url-value="{{ route('projects.boards.sort', $project) }}"
        class="grid divide-y"
    >
        @foreach($project->boards as $board)
            <div class="flex py-1">
                <x-icon icon="grip-vertical" class="handle h-5 mt-1.5 w-5 mr-1 cursor-move text-zinc-400 hover:text-zinc-600 dark:text-zinc-400 dark:hover:text-zinc-100" />
                <div>
                    <a class="link" href="{{ route('boards.show', $board) }}">
                        {{ $board->name }}
                    </a>
                    <br>
                    @include('boards._count-box')
                </div>
            </div>

        @endforeach
    </div>


</x-layouts.project-layout>
