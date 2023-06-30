<div>
    <div
        x-data="{ addFormOpen: false }"
        class="card"
    >
        <div class="card-title flex items-center">
            Tasks
            <button
                type="button"
                class="btn btn-white btn-sm font-normal ml-auto"
                @click="addFormOpen = true"
                x-show="!addFormOpen"
            >
                Add task
            </button>
        </div>
        <form class="card-body" x-show="addFormOpen" style="display: none;">
            form goes here
            <button
                type="button"
                class="btn btn-white btn-sm font-normal ml-auto"
                @click="addFormOpen = false"
            >
                Add task
            </button>
        </form>
        <div class="list-group hover" x-sortable="{ options: { handle: '.handle' }, url: '{{ route('projects.boards.tasks.sort', [$board->project_id, $board]) }}' }">
            @foreach($tasks as $task)
                <div class="list-group-item" data-sort-id="{{ $task->id }}">
                    <div class="flex items-center">
                        <div class="handle mr-1.5 text-zinc-400 hover:text-zinc-700 cursor-move" title="Click and drag to rearrange tasks">
                            <x-icon icon="grip-vertical" class="h-4 w-4" />
                        </div>
                        <button
                            wire:click="toggleTask({{$task->id}})"
                            type="button"
                            class="mr-2 {{ $task->isComplete ? 'hover:bg-green-100 bg-green-300 text-green-800' : 'hover:bg-zinc-200' }}"
                        >
                            @if($task->isComplete)
                                <x-icon icon="check-square" class="h-4 w-4" />
                            @else
                                <x-icon icon="square" class="h-4 w-4" />
                            @endif
                        </button>

                        <span class="cursor-pointer" wire:click="toggleTask({{$task->id}})">
                            {{ $task->name }}
                        </span>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
