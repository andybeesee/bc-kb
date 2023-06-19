@props(['project' => null, 'context' => 'board'])

<form action="" method="post">
    @csrf

    <input type="hidden" name="context" value="{{$context}}" />

    @isset($project)
        <input type="hidden" name="project" value="{{ $project->id }}" />
    @endisset

    <div class="grid gap-4">
        <x-form.input type="text" label="Board Name" name="name" help="Something short and useful (IT New Hire Tasks, or Accounting's Tasks)" />

        <x-form.input type="date" label="Due Date" name="due_date" />
    </div>

</form>
