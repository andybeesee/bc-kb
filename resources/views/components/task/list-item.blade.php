@props(['task', 'sortable' => false, 'showGroup' => false, 'showProject' => false])

<div
    id="task-{{ $task->id }}"
    data-sort-id="{{ $task->id }}"
    x-filedrop="{ eventParams: [{{ $task->id }}] }"
    {{ $attributes->merge() }}
    class="flex items-start"
>
    <div>
        <div class="flex items-center">
            @if($sortable)
                <div class="handle mr-1.5 text-zinc-400 hover:text-zinc-700 cursor-move" title="Click and drag to rearrange tasks">
                    <x-icon icon="grip-vertical" class="h-4 w-4" />
                </div>
            @endif
            <button
                wire:click="toggleTaskComplete({{$task->id}})"
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

            <div class="cursor-pointer" wire:click="toggleTaskComplete({{$task->id}})" title="Click to toggle complete/incomplete">
                {{ $task->name }}
            </div>

            <div class="ml-auto flex items-center space-x-4">
                @if($task->isComplete)
                    <div class="text-green-600 dark:text-green-400 text-sm ml-3">
                        {{ $task->completedBy->name }} {{ $task->completed_date->format(config('app.date_display')) }}
                    </div>
                @else
                    <livewire:user-selector
                        wire:key="assign-to-task-{{ $task->id }}-{{ $task->updated_at }}"
                        :model-id="$task->id"
                        change-event="assigned"
                        remove-event="removeAssigned"
                        :user="$task->assignedTo"
                    />
                @endif
            </div>
        </div>
    </div>

    <div class="flex text-sm space-x-3 mt-1.5 ml-1 items-center">
        <a
            href="{{ route('tasks.show', [$task]) }}" w
            wire:click.prevent="openDetail({{ $task->id }})"
            class="btn btn-white ml-4 btn-xs"
            title="Click to view task detail in a popup"
        >
            View Detail
        </a>

        @if(!$task->isComplete)
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
        @endif

        <div class="ml-auto flex items-center space-x-3">
            @if($task->files_count > 0)
                <a
                    href="{{ route('tasks.show', [$task, 'tab' => 'files']) }}"
                    title="Click to view files in task detail"
                    type="button"
                    class="flex items-center hover:bg-zinc-100 rounded-md px-1 py-0.5 text-zinc-500"
                    wire:click.prevent="openDetail({{ $task->id }}, 'files')"
                >
                    <x-icon icon="paperclip" class="h-5 mr-1  w-5" />
                    {{ $task->files_count }} File{{ $task->files_count !== 1 ? 's' : '' }}
                </a>
            @endif

            @if($task->comments_count > 0)
                <a
                    href="{{ route('tasks.show', [$task, 'tab' => 'files']) }}"
                    title="Click to view comments in task detail"
                    type="button"
                    class="flex items-center hover:bg-zinc-100 rounded-md px-1 py-0.5 text-zinc-500"
                    wire:click.prevent="openDetail({{ $task->id }}, 'comments')"
                >
                    <x-icon icon="chat-left-text" class="h-5 mr-1.5  w-5" />
                    {{ $task->comments_count }} Comment{{ $task->comments_count !== 1 ? 's' : '' }}
                </a>
            @endif
        </div>
    </div>

</div>
