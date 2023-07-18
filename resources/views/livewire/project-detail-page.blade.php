<div>
    <div class="mb-6">
        <div class="flex items-center">
            <div class="mb-2 text-3xl font-bold font-serif">{{ $project->name }}</div>

            <button class="text-zinc-500 hover:text-zinc-800 ml-auto" type="button" wire:click="$emitUp('projectDetailClosed')">
                <x-icon icon="x-circle-fill" class="h-5 w-5" />
            </button>



        </div>

        <div class="flex items-center space-x-3">
            <livewire:project-status-button :project="$project" />

            <x-date-change
                :date="$project->due_date"
                prefix="Due"
                placeholder="No Due Date"
                change-event="setProjectDueDate"
                remove-event="removeProjectDueDate"
            />
        </div>
    </div>
    <div>
        <livewire:project-task-list :project-id="$projectId" />
    </div>
</div>
