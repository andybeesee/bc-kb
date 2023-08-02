@props(['task', 'sortable' => false, 'showGroup' => false, 'showProject' => false])

<div
    id="task-{{ $task->id }}"
    data-sort-id="{{ $task->id }}"
    x-filedrop="{ eventName: 'attachTaskFiles', eventParams: [{{ $task->id }}] }"
    {{ $attributes->merge(['class' => 'hover:bg-zinc-200 dark:hover:bg-zinc-900']) }}
>
    <div>
        <div class="flex items-center">
            @if($sortable)
                <div class="handle text-zinc-400 hover:text-zinc-700 cursor-move" title="Click and drag to rearrange tasks">
                    <x-icon icon="grip-vertical" class="h-4 w-4" />
                </div>
            @endif

            <button
                wire:click="toggleTaskComplete({{$task->id}})"
                type="button"
                class="mx-2 {{ $task->isComplete ? 'rounded hover:bg-green-100 bg-green-300 text-green-800' : 'hover:bg-zinc-200' }}"
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

                
            <a
                href="{{ route('tasks.show', [$task]) }}"
                class="md:hidden rounded-md justify-center flex ml-auto min-w-[2em] p-1 items-center text-zinc-600 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white"
                title="Click to view task detail page"
            >
                <x-icon icon="arrow-right" class="h-4 w-4" />
            </a>


            {{-- TODO: :On mobile we just hide all this? --}}
            <div class="hidden md:ml-auto text-sm md:flex items-center space-x-3">
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
                    <div class="text-green-600 dark:text-green-400 text-sm ml-3 flex items-center">
                        <x-date-change
                            prefix="Completed"
                            :date="$task->completed_date"
                            change-event="changeTaskCompletedDate"
                            remove-event="removeTaskCompletedDate"
                            :model-id="$task->id"
                        />
                        by
                        <livewire:user-selector
                            :key="'task-li-comp-user-'.$task->id.'-'.$task->completed_by"
                            :user="$task->completedBy"
                            :model-id="$task->id"
                            change-event="changeTaskCompletedBy"
                            :disable-remove="true"
                        />
                    </div>
                @else
                    <div class="text-sm">
                        <livewire:user-selector
                            :key="'assign-to-li-task-'.$task->id.'-'.$task->updated_at"
                            :model-id="$task->id"
                            change-event="changeTaskAssigned"
                            remove-event="removeTaskAssigned"
                            :user="$task->assignedTo"
                            placeholder="Not Assigned"
                        />
                    </div>
                    <x-date-change
                        placeholder="No Due Date"
                        prefix="Due"
                        :date="$task->due_date"
                        change-event="changeTaskDueDate"
                        remove-event="removeTaskDueDate"
                        :model-id="$task->id"
                    />
                @endif


                <a
                    href="{{ route('tasks.show', [$task]) }}"
                    class="flex p-1 items-center text-zinc-600 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white"
                    title="Click to view task detail page"
                >
                    <x-icon icon="arrow-right" class="mr-2 h-4 w-4" />
                </a>
            </div>
        </div>
    </div>

</div>
