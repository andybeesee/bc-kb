<x-layouts.project-layout :project="$project">
    @if($project->boards->count() === 0)
        <div class="well">
            <div class="title">There are no boards</div>
            <p>
                You should add a board.
            </p>
        </div>

    @else
        <div class="grid"
             x-init
             x-sortable="{ url: '{{ route('projects.boards.sort', $project) }}', options: { handle: '.handle' } }"
        >
            @foreach($project->boards as $board)
                <div class="p-2" data-sort-id="{{ $board->id }}">
                    <div class="flex items-center">
                        <div class="handle cursor-move">
                            <x-icon icon="grip-vertical" class="h-4 w-4" />
                        </div>
                        <a class="link mr-1.5" href="{{ route('projects.boards.show', [$project, $board]) }}">
                            {{ $board->name }}
                        </a>
                         @include('boards._count-box')
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</x-layouts.project-layout>
