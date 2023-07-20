<div>
    <div class="mb-2">
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
    <div class=" mb-4">
        <div class="grid grid-cols-4 divide-x dark:divide-zinc-900 mx-auto max-w-[40vw]">
            <button wire:click="$set('tab', 'tasks')" type="button" class="rounded-l-md p-1 {{ $tab === 'tasks' ? 'bg-blue-900 hover:bg-blue-800' : 'bg-zinc-500 hover:bg-zinc-700' }}">
                Tasks
            </button>
            <button wire:click="$set('tab', 'edit')" type="button" class="p-1 {{ $tab === 'edit' ? 'bg-blue-900 hover:bg-blue-800' : 'bg-zinc-500 hover:bg-zinc-700' }}">
                Edit
            </button>
            <button wire:click="$set('tab', 'files')" type="button" class="p-1 {{ $tab === 'files' ? 'bg-blue-900 hover:bg-blue-800' : 'bg-zinc-500 hover:bg-zinc-700' }}">
                Files
            </button>
            <button wire:click="$set('tab', 'discussions')" type="button" class="rounded-r-md p-1 {{ $tab === 'discussions' ? 'bg-blue-900 hover:bg-blue-800' : 'bg-zinc-500 hover:bg-zinc-700' }}">
                Discussions
            </button>
        </div>
    </div>
    <div>
        @switch($tab)
            @case('tasks')
                <livewire:project-task-list :project-id="$projectId" />
                @break
            @case('edit')
                <div>Edit</div>
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
