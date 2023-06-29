<x-layouts.board-layout :project="$project" :board="$board" title="Tasks detail">
    <div>
        {{--TODO: we want the columns full availavle height with scrolling --}}
        {{-- TODO: we need to calculate max height and do ti that way? --}}
        {{--TODO: scroll in to view, or dosomething with Turbo? --}}

        <div class="grid">
            @foreach($board->tasks as $task)
                <a class="link" href="{{ route('projects.boards.tasks.show', [$project, $board, $task]) }}">
                    {{ $task->name }}
                </a>
            @endforeach
        </div>
    </div>
</x-layouts.board-layout>
