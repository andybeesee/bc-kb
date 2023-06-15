<x-app-layout title="Project Detail">
    <div class="container">
        <h1>{{ $project->name }}</h1>

        <div>
            <h2>Boards</h2>
            <div class="row">
                <div class="col-span-12 project-board-menu">
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
                        <a
                            href="#"
                            id="board-list-{{ $board->id }}"
                            class="p-1  flex text-sm rounded-md hover:bg-zinc-300"
                            data-active-class="active"
                            title="{{ $board->name }}"
                        >

                            <span class="grid grid-cols-3 items-center text-xs gap-0 max-w-[70px] min-w-[70px]">
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
                            <span class="link ml-2 truncate">
                                {{ $board->name }}
                            </span>

                        </a>
                    @endforeach
                </div>
                <div class="col-span-9">
                    BOARD DETAIL GOES HERE
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
