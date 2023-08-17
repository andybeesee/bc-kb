<div>
    @if($isNew)
        <h1>New Project</h1>
    @else

    @endif
    <form class="grid max-w-xl gap-5" wire:submit="saveProject">
        <x-form.input wire:model="name" label="Name" name="name" help="All projects must have a unique name" />

        <x-form.textarea wire:model="description" label="Description" name="description" help="optionally put additional info in here" />

        @if($isNew)
            <x-form.select
                label="Project Template"
                name="template"
                wire:model="template"
                style="max-width: 50%;"
                :options="$this->templateOptions"
            />
        @endif

        <x-form.date-picker name="due_date" wire:model="dueDate" label="Due Date" />

        <x-form.select wire:model="status" :empty-start="false" :options="$statuses" label="Status" name="status" />

        <x-form.select wire:model="teamId" label="Team" :options="$teams" name="team" />

        <x-form.select wire:model="ownerId" label="Owner" :options="$owners" name="owner" />

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
