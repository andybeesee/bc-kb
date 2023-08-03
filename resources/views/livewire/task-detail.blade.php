<div>
    <div>
        <h2>{{ $task->name }}</h2>
        @if($modalMode)
            <div class="mb-3 sub-nav">
                <button type="button" class="link {{ $taskTab === 'detail' ? 'active' : '' }}" wire:click="setTab('detail')">
                    Detail
                </button>
                <button type="button" class="link {{ $taskTab === 'files' ? 'active' : '' }}" wire:click="setTab('files')">
                    {{ $task->files_count }} Files
                </button>
                <button type="button" class="link {{ $taskTab === 'comments' ? 'active' : '' }}" wire:click="setTab('comments')">
                    {{ $task->comments_count ?? 0 }}
                    Comments
                </button>
            </div>
        @endif
    </div>
    <div class="grid {{ $modalMode ? '' : 'grid-cols-2 gap-4 items-start'}}">
        <div class="grid {{ $modalMode ? '' : 'gap-4' }}">
            @if(!$modalMode || $taskTab === 'detail')
                <div class="card">
                    <div class="card-title">
                        Detail
                    </div>
                    <div class="card-body">
                        <dl class="grid divide-y divide-zinc-300">
                            <div class="px-2 py-1 grid grid-cols-4">
                                <dt>Project</dt>
                                <dd class="col-span-3">
                                    <a class="link" href="{{ route('projects.show', $task->project) }}">
                                        {{ $task->project->name }}
                                    </a>
                                </dd>
                            </div>
                            @if(!empty($task->task_group_id))
                                <div class="px-2 py-1 grid grid-cols-4">
                                    <dt>Group</dt>
                                    <dd class="col-span-3">
                                        {{ $task->group->name }}
                                    </dd>
                                </div>
                            @endif
                            <div class="px-2 py-1 grid grid-cols-4">
                                <dt>Assigned</dt>
                                <dd class="col-span-3">
                                    <div class="w-1/2">
                                        <livewire:user-selector
                                            :key="'tuser-'.$taskId.'-assigned-'.$task->assigned_to"
                                            :user="$task->assignedTo"
                                            :model-id="$task->id"
                                            change-event="changeTaskAssigned"
                                            remove-event="removeTaskAssigned"
                                        />
                                    </div>

                                </dd>
                            </div>
                            <div class="px-2 py-1 grid grid-cols-4">
                                <dt>Due Date</dt>
                                <dd class="col-span-3">
                                    <x-date-change
                                        change-event="changeTaskDueDate"
                                        remove-event="removeTaskDueDate"
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
                                        <div class="w-1/2">
                                            <livewire:user-selector
                                                :key="'tuser-'.$taskId.'-user-comp-'.$task->completed_by"
                                                :user="$task->completedBy"
                                                :model-id="$task->id"
                                                change-event="changeTaskCompletedBy"
                                                :disable-remove="true"
                                            />
                                        </div>
                                    </dd>
                                </div>
                                <div class="px-2 py-1 grid grid-cols-4 bg-emerald-50 dark:bg-emerald-800">
                                    <dt>Date Completed</dt>
                                    <dd class="col-span-3">
                                        <x-date-change
                                            :model-id="$task->id"
                                            :date="$task->completed_date"
                                            prefix="Due"
                                            title="Due Date"
                                            placeholder="Not Set"
                                            change-event="changeTaskCompletedDate"
                                            remove-event="removeTaskCompletedDate"
                                        />
                                    </dd>
                                </div>
                                <div class="px-2 py-1 grid grid-cols-4">
                                    <dt>Set Incomplete</dt>
                                    <dd class="col-span-3">
                                        <button class="btn btn-sm btn-danger" type="button" wire:click="toggleTaskComplete({{ $task->id }})">
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
        </div>

        @if(!$modalMode || $taskTab === 'files')
            <div>
                <livewire:attached-file-list attached-type="task" :attached-id="$task->id" />
            </div>
        @endif

    </div>



    @if(!$modalMode || $taskTab === 'comments')
        <div class="{{ $modalMode ? '' : 'mt-4' }}">
            <livewire:comment-list attached-type="task" :attached-id="$task->id" />
        </div>
    @endif
</div>
