<div>
    @if($isNew)
        <h1>New Project</h1>
    @else

    @endif
    <form class="grid max-w-xl gap-5" wire:submit.prevent="saveProject">
        <x-form.input wire:model="project.name" label="Name" name="name" help="All projects must have a unique name" :value="$project->name" />

        <x-form.textarea wire:model="project.description" label="Description" name="description" help="optionally put additional info in here" :value="$project->description" />

        <x-form.input wire:model="project.due_date" type="date" name="due_date" label="Due Date" help="This is optional" :value="$project->due_date?->format('Y-m-d')" />

        <x-form.select wire:model="project.status" :empty-start="false" :options="$statuses" label="Status" name="status" :value="$project->status" />

        <x-form.select wire:model="project.team_id" label="Team" :options="$teams" name="team" :value="$project->team_id" />

        <x-form.select wire:model="project.owner_id" label="Owner" :options="$owners" name="owner" :value="$project->owner_id" />

        <div class="form-group">
            <div class="form-label"></div>
            <div class="form-control-container">
                <button type="submit" class="btn min-w-[325px] btn-primary">
                    {{ $isNew ? 'Add Project' : 'Save Changes' }}
                </button>
            </div>
        </div>
    </form>

</div>
