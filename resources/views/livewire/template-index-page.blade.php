<div class="mx-4 md:mx-10 lg:mx-12">
    <div class="button-tabs mb-4">
        <button wire:click="$set('tab', 'project-templates')" type="button" class="{{ $tab === 'project-templates' ? 'active' : '' }}">
            Project Templates
        </button>
        <button wire:click="$set('tab', 'task-group-templates')" type="button" class="{{ $tab === 'task-group-templates' ? 'active' : '' }}">
            Task Group Templates
        </button>
        <button wire:click="$set('tab', 'create')" type="button" class="{{ $tab === 'create' ? 'active' : '' }}">
            New Template
        </button>
    </div>

    @if($tab === 'create')
        <div>
            <div class="grid gap-4">
                <x-form.select wire:model.live="newType" :options="['project' => 'Project', 'task_group' => 'Task Group']" name="type" label="Type" />

                @if($newType === 'project')
                    <livewire:template.project-form :save-redirect="true" />
                @else
                    <livewire:template.task-group-form :save-redirect="true" />
                @endif
            </div>
        </div>
    @endif

    @if($tab === 'project-templates')
        <div>
            <livewire:project-template-index-list />
        </div>
    @endif

    @if($tab === 'task-group-templates')
        <div>
            <livewire:task-group-template-index-list />
        </div>
    @endif
</div>
