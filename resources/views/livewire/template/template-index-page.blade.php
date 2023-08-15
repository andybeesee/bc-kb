<div class="mx-4 md:mx-10 lg:mx-12">
    <div class="button-tabs mb-4">
        <button wire:click="$set('tab', 'project-templates')" type="button" class="{{ $tab === 'project-templates' ? 'active' : '' }}">
            Project Templates
        </button>
        <button wire:click="$set('tab', 'checklist-templates')" type="button" class="{{ $tab === 'checklist-templates' ? 'active' : '' }}">
            Checklist Templates
        </button>
        <button wire:click="$set('tab', 'create')" type="button" class="{{ $tab === 'create' ? 'active' : '' }}">
            New Template
        </button>
    </div>

    @if($tab === 'create')
        <div>
            <div class="grid gap-4">
                <x-form.select wire:model.live="newType" :options="['project' => 'Project', 'checklist' => 'Checklist']" name="type" label="Type" />

                @if($newType === 'project')
                    <livewire:template.project-template-form :save-redirect="true" />
                @else
                    <livewire:template.checklist-template-form :save-redirect="true" />
                @endif
            </div>
        </div>
    @endif

    @if($tab === 'project-templates')
        <div>
            <livewire:template.project-template-index-list />
        </div>
    @endif

    @if($tab === 'checklist-templates')
        <div>
            <livewire:template.checklist-template-index-list />
        </div>
    @endif
</div>
