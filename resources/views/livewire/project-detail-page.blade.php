<div
    class="mx-2 md:mx-10 lg:mx-16"
    x-data="{
        updateFormOpen: false,
        openForm() {
            this.updateFormOpen = true;
            this.$dispatch('open-modal', 'proj-stat-form');
        }
    }"
>
    <div class="mb-2">
        <div class="">
            <div class="mb-2 text-3xl font-bold">{{ $project->name }}</div>
        </div>

        <div class="flex items-center space-x-3">
            <div type="button" @click="" class="flex items-center p-0.5">
                <x-icon class="mr-2 h-4 w-4 {{ \App\View\StatusColorUtils::getIconColors($project->status) }}" :icon="\App\View\StatusColorUtils::getIcon($project->status)" />
                {{ config('statuses.'.$project->status) }}
            </div>

            <x-date-change
                :model-id="$project->id"
                :date="$project->due_date"
                prefix="Due"
                placeholder="No Due Date"
                change-event="update-project-due-date"
                remove-event="remove-project-due-date"
            />

            <button class="btn btn-white btn-sm " @click="openForm" type="button">
                Update Status
            </button>
        </div>

        <div class="mt-1">
            @if($project->currentStatus)
                <div>

                    <span class="font-semibold text-xs">Status Updated {{ $project->currentStatus->created_at->format(config('app.date_display')) }}:</span>
                    {{ $project->currentStatus->status }}
                    <div class="">
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div x-show="updateFormOpen" style="display: none;">
        <div @project-updated="updateFormOpen = false" @close-project-update-form="updateFormOpen = false" @modal-close="updateFormOpen = false" @project-status-updated="updateFormOpen = false">
            <x-modal name="proj-stat-form">
                <div class="p-4">
                    <livewire:project-update-status-form :project-id="$project->id" lazy />
                </div>
            </x-modal>
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
                    <livewire:project-dashboard :project="$project" :key="$project->id.'-projdet-dashboard'"/>
                </div>
                @break
            @case('tasks')
                <div>
                    <livewire:project-task-list :project-id="$project->id" :key="$project->id.'-projdet-taskslist'"/>
                </div>

                @break
            @case('edit')
                <div>
                    <livewire:project-form :project="$project" :key="$project->id.'-projdet-editform'"/>
                </div>
                @break
            @case('files')
                <div>
                    <livewire:attached-file-list attached-type="project" :attached-id="$project->id" />
                </div>
                @break
            @case('discussions')
                <div>
                    <div>Discussions</div>
                    TODO
                </div>
                @break
        @endswitch
    </div>
</div>
