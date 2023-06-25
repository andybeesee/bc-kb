<x-layouts.project-layout :project="$project">

    <div>
        @foreach($project->boards as $board)
            <div
                id="board-list-{{ $board->id }}"
                class="p-1"
                title="{{ $board->name }}"
                data-sortable-target="item"
                data-id="{{ $board->id }}"
            >
                <div class="flex">
                    <div>
                        <a href="{{ route('boards.show', [$project, $board]) }}" class="link truncate">
                            #{{ $board->id }} {{ $board->name }}
                        </a>
                        @include('boards._count-box')
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-layouts.project-layout>
