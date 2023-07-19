<div>
    @if($isNew)
        <h1>New Project</h1>
    @else

    @endif
    <div class="grid gap-4">
        <x-form.input label="Name" name="name" help="All projects must have a unique name" :value="$project->name" />

        <x-form.textarea label="Description" name="description" help="optionally put additional info in here" :value="$project->description" />

        <x-form.input type="date" name="due_date" label="Due Date" help="This is optional" :value="$project->due_date?->format('Y-m-d')" />

        <x-form.select :empty-start="false" :options="$statuses" label="Status" name="status" :value="$project->status" />

        <x-form.select label="Team" :options="$teams" name="team" :value="$project->team_id" />

        <x-form.select label="Owner" :options="$owners" name="owner" :value="$project->owner_id" />

    </div>

</div>
