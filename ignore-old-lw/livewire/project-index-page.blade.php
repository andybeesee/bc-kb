<div class="mx-4 md:mx-10 lg:mx-12">
    <div class="button-tabs mb-4">
        <button
            wire:click.self="$set('tab', 'dashboard')"
            class="{{ $tab == 'dashboard' ? 'active' : '' }}"
            title="Show dashboard"
        >
            <x-icon icon="pie-chart-fill" class="h-4 w-4" />
            Dashboard
        </button>

        <button
            wire:click.self="$set('tab', 'list')"
            class="{{ $tab == 'list' ? 'active' : '' }}"
            title="Show Project List"
        >
            <x-icon icon="list" class="h-4 w-4" />
            Project List
        </button>

        <button type="button"
                wire:click.self="$set('tab', 'new')"
                class="{{ $tab == 'new' ? 'active' : '' }}"
                title="Start a New project"
        >
            <x-icon icon="plus-circle" class="h-4 w-4" />
            Start a New Project
        </button>
    </div>
    <div>
        @switch($tab)
            @case('dashboard')
                <livewire:project-index-dashboard />
                @break
            @case('new')
                <livewire:project-form />
                @break
            @case('list')
                <livewire:project-index-list />
                @break
        @endswitch
    </div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
</div>
