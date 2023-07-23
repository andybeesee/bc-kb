<div class="mx-2 md:mx-10 lg:mx-16">
    <div class="mb-2">
        <div class="flex justify-center">
            <div class="mb-2 text-center text-3xl font-bold">{{ $project->name }}</div>
        </div>

        <div class="flex justify-center items-center space-x-3">
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

    <div class="mb-4">
        <div class="button-tabs">
            <button wire:click="$set('tab', 'dashboard')" type="button" class="{{ $tab === 'dashboard' ? 'active' : '' }}">
                Dashboard
            </button>
            <button wire:click="$set('tab', 'tasks')" type="button" class="{{ $tab === 'tasks' ? 'active' : '' }}">
                Tasks
            </button>
            <button wire:click="$set('tab', 'edit')" type="button" class="{{ $tab === 'edit' ? 'active' : '' }}">
                Edit
            </button>
            <button wire:click="$set('tab', 'files')" type="button" class="{{ $tab === 'files' ? 'active' : '' }}">
                Files
            </button>
            <button wire:click="$set('tab', 'discussions')" type="button" class="{{ $tab === 'discussions' ? 'active' : '' }}">
                Discussions
            </button>
        </div>
    </div>
    <div>
        @switch($tab)
            @case('dashboard')
                <div>
                    <livewire:project-dashboard :project="$project" />
                </div>
                @break
            @case('tasks')
                <livewire:project-task-list :project-id="$project->id" />
                @break
            @case('edit')
                <div>
                    <livewire:project-form :project="$project" />
                </div>
                @break
            @case('files')
                <div>Files</div>
                @break
            @case('discussions')
                <div>Discussions</div>
                @break
        @endswitch
    </div>
</div>
