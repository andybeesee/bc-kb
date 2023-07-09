<div>
    <div>
        <h2>{{ $task->name }}</h2>
        @if($modalMode)
            <div class="mb-4 sub-nav">
                <button type="button" class="link {{ $tab === 'detail' ? 'active' : '' }}" wire:click="setTab('detail')">
                    Detail
                </button>
                <button type="button" class="link {{ $tab === 'files' ? 'active' : '' }}" wire:click="setTab('files')">
                    {{ $task->files_count }} Files
                </button>
                <button type="button" class="link {{ $tab === 'discussions' ? 'active' : '' }}" wire:click="setTab('discussions')">
                    {{ $task->discussions_count ?? 0 }}
                    Discussions
                </button>
            </div>
        @endif
    </div>
    <div class="grid {{ $modalMode ? '' : 'grid-cols-2 gap-4'}}">
        @if(!$modalMode || $tab === 'detail')
            <div class="card">
                <div class="card-title">
                    Detail
                </div>
                <div class="card-body">
                    <dl class="grid divide-y divide-zinc-300">
                        <div class="px-2 py-1 grid grid-cols-4">
                            <dt>Assigned</dt>
                            <dd class="col-span-3">
                                <livewire:user-selector
                                    wire:key="task-detail-{{ $task->id }}-assigned-{{ $task->assigned_to }}"
                                    :user="$task->assignedTo"
                                    :model-id="$task->id"
                                    change-event="assigned"
                                    remove-event="removeAssigned"
                                />
                            </dd>
                        </div>
                        <div class="px-2 py-1 grid grid-cols-4">
                            <dt>Due Date</dt>
                            <dd class="col-span-3">
                                <x-date-change
                                    wire:key="task-detail-{{ $task->id }}-due-{{ $task->due_date?->getTimestamp() }}"
                                    change-event="updateDueDate"
                                    remove-event="removeDueDate"
                                    :model-id="$task->id"
                                    :date="$task->due_date"
                                    prefix="Due"
                                    title="Due Date"
                                    placeholder="Not Set"
                                />
                            </dd>
                        </div>
                        @if($task->isComplete)
                            <div class="px-2 py-1 grid grid-cols-4 bg-emerald-50 dark:bg-emerald-800">
                                <dt>Completed by</dt>
                                <dd class="col-span-3">
                                    <livewire:user-selector
                                        wire:key="task-detail-{{ $task->id }}-{{ $task->completed_by }}"
                                        :user="$task->completedBy"
                                        :model-id="$task->id"
                                        change-event="changeCompleted"
                                        :disable-remove="true"
                                    />
                                </dd>
                            </div>
                            <div class="px-2 py-1 grid grid-cols-4 bg-emerald-50 dark:bg-emerald-800">
                                <dt>Date Completed</dt>
                                <dd class="col-span-3">
                                    <x-date-change :model-id="$task->id" :date="$task->completed_date" prefix="Due" title="Due Date" placeholder="Not Set" />
                                </dd>
                            </div>
                            <div class="px-2 py-1 grid grid-cols-4">
                                <dt>Set Incomplete</dt>
                                <dd class="col-span-3">
                                    <button class="btn btn-sm btn-danrt" type="button" wire:click="toggleTaskComplete({{ $task->id }})">
                                        Mark Incomplete
                                    </button>
                                </dd>
                            </div>
                        @else
                            <div class="px-2 py-1 grid grid-cols-4">
                                <dt>Incomplete</dt>
                                <dd class="col-span-3">
                                    <button class="btn btn-sm btn-success" type="button" wire:click="toggleTaskComplete({{ $task->id }})">
                                        Mark Complete
                                    </button>
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>
        @endif

        @if(!$modalMode || $tab === 'files')
            <div>
                FILES
            </div>

        @endif

        @if(!$modalMode || $tab === 'discussions')
            <div>
                Discussions
            </div>
        @endif
    </div>
</div>
