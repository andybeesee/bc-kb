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
            <livewire:template-form save-redirect="true" />
        </div>
    @endif
</div>
