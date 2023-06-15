<x-app-layout title="Project Detail">
    <div class="container">
        <h1>{{ $project->name }}</h1>

        <div>
            <h2>Boards</h2>
            <div>
                @foreach($project->boards as $board)
                    <div id="board-list-{{ $board->id }}" class="flex items-center p-1">
                        {{-- We could make it expandable... or open an off-canvas, or we can focus on deep-linking /projects/board/tasks --}}
                        <x-icon icon="caret-right" class="h-3 w-3 mr-1" />
                        <a class="link" href="#">{{ $board->name }}</a>
                        <div class="text-xs ml-4 flex items-center space-x-3">
                            <span title="Incomplete">{{ $board->incomplete_tasks_count }}</span>
                            @if($board->past_due_tasks_count > 0)
                                <span title="Past Due Tasks" class="text-danger">{{ $board->past_due_tasks_count }}</span>
                            @endif
                            @if($board->incomplete_user_tasks_count > 0)
                                <span title="Your Incomplete tasks" class="text-primary">{{ $board->incomplete_user_tasks_count }}</span>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>
