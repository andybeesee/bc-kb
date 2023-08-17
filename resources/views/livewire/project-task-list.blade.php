<div x-data="{ addingGroup: false }">
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

    <div class="card">
        <div class="card-title">
            Tasks <span class="text-sm font-normal text-zinc-50 dark:text-zinc-600 ml-2">Not part of a specific checklist</span>
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

    <div class="my-3">
        <div>
            <button class="btn btn-white" x-show="!addingGroup" type="button" @click="addingGroup = true">
                Add Checklist
            </button>
        </div>
        <div class="card" x-show="addingGroup">
            <div class="card-title">
                New Checklist
            </div>
            <form action="">
                <div class="card-body">
                    group name, new tasks, or import 'template group' option...after/before option?
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Add Checklist</button>
                    <button type="button" class="btn btn-white" @click="addingGroup = false">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <div x-sortable="{ event: 'checklistSorted', idAttribute: 'data-checklist-id', options: { handle: '.handle', group: { name: 'checklists', put: 'checklists', pull: 'checklists' } } }">
        @foreach($checklists as $checklist)
            {{-- TODO: Dropdown to change color of section --}}
            <div id="group-task-list-{{ $checklist->id }}" data-checklist-id="{{ $checklist->id }}" class="mt-4 grid gap-4">
                <div class="card">
                    <div class="card-title sticky top-0 z-[4] flex items-center">
                        <div class="mr-1 cursor-move handle">
                            <x-icon icon="grip-vertical" class="h-4 w-4" />
                        </div>
                        {{ $checklist->name }}
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
