<div class="container">
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

    @if($tab === 'project-templates')
        <div>
            <div class="mb-4">
                <x-form.input type="text" name="search" class="w-full" placeholder="Search" wire:model="search" />
            </div>
            proj templs
        </div>
    @endif

    @if($tab === 'task-group-templates')
        <div>
            <div class="mb-4">
                <x-form.input type="text" name="search" class="w-full" placeholder="Search" wire:model="search" />
            </div>
            taskgroup temp
        </div>
    @endif

    @if($tab === 'create')
        <div>
            New Template Form
        </div>
    @endif
</div>
