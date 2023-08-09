<div class="mx-4 md:mx-10 lg:mx-12">
    <div class="button-tabs mb-4">
        <button wire:click="$set('tab', 'templates')" type="button" class="{{ $tab === 'templates' ? 'active' : '' }}">
            Templates
        </button>
        <button wire:click="$set('tab', 'create')" type="button" class="{{ $tab === 'create' ? 'active' : '' }}">
            New Template
        </button>
    </div>

    @if($tab === 'templates')
        <div>
            <div class="mb-4">
                <x-form.input autofocus type="text" name="search" class="w-full" placeholder="Search" wire:model="search" />
            </div>
            <div>
                proj templates, filters and whatever else
            </div>
        </div>
    @endif

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
</div>
