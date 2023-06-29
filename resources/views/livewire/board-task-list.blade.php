<div>
    <div class="card" data-controller="toggle" data-toggle-is-open-value="{{ $tasks->count() === 0 ? '1' : '0' }}">
        <div class="card-title flex items-center">
            Tasks
            <button
                type="button"
                class="btn btn-white btn-sm font-normal ml-auto"
                data-action="click->toggle#toggle"
                data-toggle-target="openHide"
            >
                Add task
            </button>
        </div>
        <form class="card-body" data-toggle-target="content">
            form goes here
        </form>
        <div class="list-group hover">
            @foreach($tasks as $task)
                <div class="list-group-item">
                    <div class="flex items-center">
                        <div class="mr-1.5 text-zinc-400 hover:text-zinc-700 cursor-move" title="Click and drag to rearrange tasks">
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


                        <div>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
