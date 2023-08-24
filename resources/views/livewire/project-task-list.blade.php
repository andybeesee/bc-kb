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


    <div class="grid grid-cols-7 gap-6 items-start">
        <div class="col-span-2 ">
            <div
                class="flex flex-col divide-y dark:divide-zinc-700 divide-zinc-200"
                x-sortable="{ event: 'checklistSorted', idAttribute: 'data-checklist-id', options: { handle: '.handle', group: { name: 'checklists', put: 'checklists', pull: 'checklists' } } }"
            >
                <div
                    id="group-task-list-ungrouped"
                    class="p-1 cursor-pointer  {{ empty($openedChecklist) ? 'bg-blue-100 dark:bg-blue-700' : 'hover:bg-zinc-100 dark:hover:bg-zinc-900' }}"
                    title="Ungrouped"
                    wire:click="$set('openedChecklist', null)"
                >
                    <div class="flex items-center truncate">
                        Ungrouped
                    </div>
                    <div class="text-sm">
                        x tasks, 5 late
                    </div>

                </div>
                @foreach($checklists as $checklist)
                    {{-- TODO: make this a livewire component that lazy loads... --}}
                    {{-- TODO: Dropdown to change color of section --}}
                    <div
                        id="group-task-list-{{ $checklist->id }}"
                        data-checklist-id="{{ $checklist->id }}"
                        class="p-1 cursor-pointer  {{ $checklist->id === $openedChecklist ? 'bg-blue-100 dark:bg-blue-700' : 'hover:bg-zinc-100 dark:hover:bg-zinc-900' }}"
                        title="{{  $checklist->name }}"
                        wire:click="$set('openedChecklist', {{ $checklist->id }})"
                    >
                        <div class="flex items-center truncate">
                            <div class="mr-1 cursor-move handle">
                                <x-icon icon="grip-vertical" class="h-4 w-4" />
                            </div>

                            {{ $checklist->name }}
                        </div>
                        <div class="ml-5 text-sm">
                            x tasks, 5 late
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-span-5">
            <div class="card">
                <div class="flex items-center card-title justify-between">
                    {{ $this->openChecklistDetail ? $this->openChecklistDetail->name : 'Ungrouped Tasks' }}
                    <button wire:click="openAddTask({{ $openedChecklist }})" class="ml-auto btn btn-sm btn-white" type="button">Add Task(s)</button>
                </div>
                <div
                    class="sortable-chosen-hide divide-y divide-zinc-300 dark:divide-zinc-700"
                    x-sortable="{ options: { handle: '.handle',  group: { name: 'tasks', put: 'tasks', pull: 'tasks' } } }"
                >
                    {{ $openedChecklist }}
                    @foreach($this->tasksToShow as $task)
                        <x-task.list-item
                            class="py-2 px-1"
                            :task="$task"
                            :sortable="true"
                        />
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
