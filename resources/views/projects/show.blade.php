<x-layouts.project-layout :project="$project">
    <div
        data-controller="sortable"
        data-sortable-handle-selector-value=".handle"
        data-sortable-url-value="{{ route('projects.boards.sort', $project) }}"
    >
        @foreach($project->boards as $board)
            @php
                $class = '';
                if($board->incomplete_tasks_count > 0) {
                    $class .= 'has-incomplete';
                }

                if($board->past_due_tasks_count > 0) {
                    $class .= 'has-past-due';
                }

                if($board->incomplete_user_tasks_count > 0) {
                    $class .= 'has-incomplete-user';
                }
            @endphp
            <div
                id="board-list-{{ $board->id }}"
                class="p-1 flex text-sm rounded-md"
                title="{{ $board->name }}"
                data-sortable-target="item"
                data-id="{{ $board->id }}"
            >
                @include('boards._count-box')
                <a href="{{ route('projects.boards.show', [$project, $board]) }}" class="link ml-2 truncate">
                    #{{ $board->id }} {{ $board->name }}
                </a>

            </div>
        @endforeach
    </div>
</x-layouts.project-layout>
