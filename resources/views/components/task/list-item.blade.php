@props(['task', 'sortable' => false, 'showGroup' => false, 'showProject' => false])

<div
    id="task-{{ $task->id }}"
    data-sort-id="{{ $task->id }}"
    x-filedrop="{ eventParams: [{{ $task->id }}] }"
    {{ $attributes->merge() }}
>
    <div class="flex items-center">
        @if($sortable)
            <div class="handle mr-1.5 text-zinc-400 hover:text-zinc-700 cursor-move" title="Click and drag to rearrange tasks">
                <x-icon icon="grip-vertical" class="h-4 w-4" />
            </div>
        @endif
        <button
            wire:click="toggleTask({{$task->id}})"
            type="button"
            class="mr-2 {{ $task->isComplete ? 'rounded hover:bg-green-100 bg-green-300 text-green-800' : 'hover:bg-zinc-200' }}"
            title="{{ $task->isComplete ? 'Completed by '.$task->completedBy->name.' on '.$task->completed_date->format(config('app.date_display')) : 'Click to Mark Complete' }}"
        >
            @if($task->isComplete)
                <x-icon icon="check-square" class="h-4 w-4" />
            @else
                <x-icon icon="square" class="h-4 w-4" />
            @endif
        </button>

        <div class="cursor-pointer" wire:click="toggleTask({{$task->id}})" title="Click to toggle complete/incomplete">
            {{ $task->name }}
        </div>

        <div class="ml-auto space-x-4 flex items-center text-sm">
            @if($task->files_count > 0)
                <div class="flex items-center">
                    <x-icon icon="paperclip" class="h-5 mr-1  w-5" />
                    {{ $task->files_count }} File{{ $task->files_count !== 1 ? 's' : '' }}
                </div>
            @endif

            @if($task->isComplete)
                <div class="text-green-600 dark:text-green-400 text-sm ml-3">
                    {{ $task->completedBy->name }} {{ $task->completed_date->format(config('app.date_display')) }}
                </div>
            @else
                <x-date-change
                    class="{{ $task->isLate ? 'text-red-600' : '' }}"
                    suffix="{{ $task->isLate ? '(Late)' : '' }}"
                    wire:key="task-{{ $task->id }}-due-date-{{ $task->due_date?->getTimestamp() }}"
                    title="Due Date"
                    prefix="Due"
                    :date="$task->due_date"
                    :model-id="$task->id"
                    placeholder="No Due Date"
                    changeEvent="setTaskDue"
                    removeEvent="removeTaskDue"
                />
                <livewire:assign-to-selector
                    wire:key="assing-to-task-{{ $task->id }}-{{ $task->updated_at }}"
                    :model-id="$task->id"
                    :assigned-to="$task->assignedTo"
                />
            @endif

        </div>
    </div>

</div>
