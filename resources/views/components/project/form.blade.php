@props(['project' => null])
@php

$teams = \App\Models\Team::orderBy('name')->get();
$owners = \App\Models\User::orderBy('name')->get();
$statuses = config('statuses');

if(empty($project)) {
    $project = new \App\Models\Project();
    $project->team_id = auth()->user()->teams()->first()?->id;
    $project->owner_id = auth()->user()->id;
}
@endphp
<div>
    <div class="grid gap-4">
        <x-form.input label="Name" name="name" help="All projects must have a unique name" :value="$project->name" />

        <x-form.textarea label="Description" name="description" help="optionally put additional info in here" :value="$project->description" />

        <x-form.input type="date" name="due_date" label="Due Date" help="This is optional" :value="$project->due_date?->format('Y-m-d')" />

        <x-form.select :empty-start="false" :options="$statuses" label="Status" name="status" :value="$project->status" />

        <x-form.select label="Team" :options="$teams" name="team" :value="$project->team_id" />

        <x-form.select label="Owner" :options="$owners" name="owner" :value="$project->owner_id" />

    </div>

</div>
