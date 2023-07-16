@props(['task'])

<div class="grid divide-y divide-zinc-100">
    <a
        href="{{ route('tasks.show', [$task]) }}" w
        wire:click.prevent="openDetail({{ $task->id }})"
        class="flex p-1 items-center link"
        title="Click to view task detail in a popup"
    >
        <x-icon icon="box-arrow-up-right" class="mr-2 h-4 w-4" />
        View Detail
    </a>
    @if($task->isComplete)
        <div class="p-1 bg-green-100 flex items-center">
            <span class="mr-1">Completed by</span>
            <livewire:user-selector
                wire:key="task-detail-{{ $task->id }}-{{ $task->completed_by }}"
                :user="$task->completedBy"
                :model-id="$task->id"
                change-event="changeCompleted"
                :disable-remove="true"
            />
        </div>
        <div class="p-1 bg-green-100 flex items-center">
            <span class="mr-1">Completed on</span>
            <x-date-change
                wire:key="task-detail-{{ $task->id }}-completed-{{ $task->completed_date?->getTimestamp() }}"
                :model-id="$task->id"
                :date="$task->completed_date"
                prefix="Due"
                title="Due Date"
                placeholder="Not Set"
                change-event="completeDateChange"
                :removable="false"
            />
        </div>
    @endif
        <div class="flex space-x-2 p-1 items-center">
            Assigned
            <livewire:user-selector
                wire:key="assign-to-task-{{ $task->id }}-{{ $task->updated_at }}"
                :model-id="$task->id"
                change-event="assigned"
                remove-event="removeAssigned"
                :user="$task->assignedTo"
            />
        </div>
        <x-date-change
            class="{{ $task->isLate ? 'text-red-600' : '' }} p-1"
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
</div>
