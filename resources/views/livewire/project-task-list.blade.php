<div x-data="{ addingGroup: @entangle('addingGroup').live, addingTask: @entangle('addingTask').live }">
    {{-- TODO: we still get the odd livewire state error when sorting items - but I don't know why --}}
    {{-- This div has to be outside the if/else --}}
    <div @modal-close="$wire.closeDetail()">
        @if(!empty($showDetailTask))
            <x-modal max-width="big" :show="true" name="task-detail-window">
                <div class="p-4">
                    <livewire:task-detail :key="'livewire-task-detail-window-'.$showDetailTask" :modal-mode="true" :task-id="$showDetailTask" :starting-tab="$startingTab" />
                </div>
            </x-modal>
        @endif
    </div>

    <div
        @cancel="$wire.set('addingGroup', false)"
        @modal-close="$wire.set('addingGroup', false)"
        class="my-3"
    >
        <div>
            <button class="btn btn-white" type="button" @click="addingGroup = true">
                Add/Import Checklist(s)
            </button>
        </div>
        @if($addingGroup)
            <x-modal name="cl-modal">
                <livewire:project-new-checklist-form :project-id="$projectId" />
            </x-modal>
        @endif
    </div>


    <div @modal-close="addingTask = false" @cancel="addingTask = false">
        @if($addingTask)
            <x-modal name="add-task-modal">
                <livewire:new-task-form
                    :project-id="$projectId"
                    :checklist-id="$addingTaskToChecklist"
                    :show-project-select="false"
                    :show-checklist-select="true"
                />
            </x-modal>
        @endif
    </div>


    <div class="card">
        <div class="card-title flex items-center">
            Tasks <span class="text-sm font-normal text-zinc-400 dark:text-zinc-600 ml-2">Not part of a specific checklist</span>

            <button wire:click="openAddTask(null)" class="ml-auto btn btn-sm btn-white" type="button">Add Task(s)</button>
        </div>
        <div
            data-group-id="" class="divide-y divide-zinc-300 dark:divide-zinc-700" x-sortable="{ options: { handle: '.handle', group: { name: 'tasks', put: 'tasks', pull: 'tasks' } } }">
            @foreach($tasks as $task)
                @php
                    $taskBgClass = '';
                    if($task->is_complete) {
                        $taskBgClass = ''; // bg-green-100 dark:bg-green-900 dark:hover:bg-green-800';
                    } elseif($task->assigned_to === auth()->user()->id) {
                        $taskBgClass = 'bg-blue-100 dark:bg-blue-900 dark:hover:bg-blue-800';
                    }

                @endphp
                <x-task.list-item class="py-2 px-1 {{ $taskBgClass }}" :task="$task" :sortable="true" :key="'ungrouped-'.$task->id" />
            @endforeach
        </div>
    </div>

    <div x-sortable="{ event: 'checklistSorted', idAttribute: 'data-checklist-id', options: { handle: '.handle', group: { name: 'checklists', put: 'checklists', pull: 'checklists' } } }">
        @foreach($checklists as $checklist)
            {{-- TODO: make this a livewire component that lazy loads... --}}
            {{-- TODO: Dropdown to change color of section --}}
            <div id="group-task-list-{{ $checklist->id }}" data-checklist-id="{{ $checklist->id }}" class="mt-4 grid gap-4">
                <div class="card">
                    <div class="card-title sticky top-0 z-[4] flex items-center">
                        <div class="mr-1 cursor-move handle">
                            <x-icon icon="grip-vertical" class="h-4 w-4" />
                        </div>
                        {{ $checklist->name }}

                        <button wire:click="openAddTask({{ $checklist->id }})" class="ml-auto btn btn-sm btn-white" type="button">Add Task(s)</button>
                    </div>

                    <div
                        class="sortable-chosen-hide divide-y divide-zinc-300 dark:divide-zinc-700"
                        x-sortable="{ options: { handle: '.handle',  group: { name: 'tasks', put: 'tasks', pull: 'tasks' } } }"
                    >
                        @foreach($checklist->tasks as $task)
                            <x-task.list-item
                                class="py-2 px-1"
                                :task="$task"
                                :sortable="true"
                            />
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
