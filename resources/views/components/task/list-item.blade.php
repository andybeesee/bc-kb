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
                <div class="handle text-zinc-400 hover:text-zinc-700 cursor-move" title="Click and drag to rearrange tasks">
                    <x-icon icon="grip-vertical" class="h-4 w-4" />
                </div>
            @endif
            <div x-data="{ open: false }" class="relative mr-2">
                <div class="z-2 cursor-pointer rounded hover:bg-zinc-100 dark:hover:bg-zinc-900" @click="open = !open" type="button">
                    <x-icon icon="three-dots-vertical" class="block align-middle h-4 w-4" />
                </div>
                <div
                    @click.outside="open = false"
                    x-show="open"
                    class="p-3 mt-0.5 border border-zinc-400 absolute z-10 bg-white dark:bg-zinc-900 rounded shadow min-w-[350px] max-h-[400x]"
                    style="display: none;"
                >
                    <x-task.action-menu-items :task="$task" />
                </div>
            </div>

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

            <div class="ml-auto text=sm flex items-center space-x-3">
                @if($task->files_count > 0)
                    <a
                        href="{{ route('tasks.show', [$task, 'tab' => 'files']) }}"
                        title="Click to view {{ $task->files_count }} file{{ $task->files_count !== 1 ? 's' : '' }} in task detail"
                        type="button"
                        class="flex text-sm items-center hover:bg-zinc-100 rounded-md px-1 py-0.5 text-zinc-500"
                        wire:click.prevent="openDetail({{ $task->id }}, 'files')"
                    >
                        <x-icon icon="paperclip" class="h-5 mr-1 w-5" />
                        {{ $task->files_count }}
                    </a>
                @endif

                @if($task->comments_count > 0)
                    <a
                        href="{{ route('tasks.show', [$task, 'tab' => 'files']) }}"
                        title="Click to view {{ $task->comments_count }} comment{{ $task->comments_count !== 1 ? 's' : '' }} in task detail"
                        type="button"
                        class="flex text-sm items-center hover:bg-zinc-100 rounded-md px-1 py-0.5 text-zinc-500"
                        wire:click.prevent="openDetail({{ $task->id }}, 'comments')"
                    >
                        <x-icon icon="chat-left-text" class="h-5 mr-1  w-5" />
                        {{ $task->comments_count }}
                    </a>
                @endif


                @if($task->isComplete)
                    <div class="text-green-600 dark:text-green-400 space-x-2 text-sm ml-3 flex items-center">
                        {{ $task->completedBy->name }}
                        <x-date-change
                            prefix="Completed"
                            :date="$task->completed_date"
                            change-event="updateTaskCompletedDate"
                            remove-event="removeCompletedDate"
                            :model-id="$task->id"
                        />
                    </div>
                @else
                    <div class="text-sm">
                        {{  $task->assignedTo?->name }}
                    </div>
                    @if(!$task->isComplete)
                        <x-date-change
                            placeholder="No Due Date"
                            prefix="Due"
                            :date="$task->due_date"
                            change-event="setTaskDue"
                            remove-event="removeTaskDue"
                            :model-id="$task->id"
                        />
                    @endif
                @endif
            </div>
        </div>
    </div>

</div>
