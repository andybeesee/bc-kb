<x-app-layout title="Project Detail">
    <div class="container">
        <h1>{{ $project->name }}</h1>

        <div>
            <div class="mb-5">
                <h2>{{ $project->boards->count() }} Boards</h2>
                <a class="link" href="#">Add a Board</a>
            </div>


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
                        <span class="grid grid-cols-4 items-center text-xs gap-0 max-w-[75px] min-w-[75px]">
                            <x-icon icon="grip-vertical" class="handle h-4 w-4 mr-1 cursor-move text-zinc-400 hover:text-zinc-600 dark:text-zinc-400 dark:hover:text-zinc-100" />
                            <span title="All Incomplete tasks" class="border text-center truncate {{ $board->incomplete_tasks_count > 0 ? 'bg-zinc-600 text-white' : '' }}">
                                {{ $board->incomplete_tasks_count }}

                            </span>
                            <span title="Past Due Tasks" class="border text-center truncate {{ $board->past_due_tasks_count > 0 ? 'bg-red-600 text-white' : '' }}">
                                {{ $board->past_due_tasks_count }}
                            </span>
                            <span title="Your incomplete tasks" class="border text-center truncate {{ $board->incomplete_user_tasks_count > 0 ? 'bg-blue-600 text-white' : '' }}">
                                {{ $board->incomplete_user_tasks_count }}
                            </span>
                        </span>
                        <a href="#" class="link ml-2 truncate">
                            #{{ $board->id }} {{ $board->name }}
                        </a>

                    </div>
                @endforeach
            </div>

        </div>

    </div>
</x-app-layout>
