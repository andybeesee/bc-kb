@props(['project', 'board' => null])

@php
    $newBoard = empty($board);
    $board = $board ?? new \App\Models\Board();
    $route = $newBoard ? route('projects.boards.store', $project) : route('projects.boards.update', [$project, $board]);
@endphp

<form action="{{ $route }}" method="post">
    @csrf
    @method($newBoard ? 'POST' : 'PUT')

    @isset($project)
        <input type="hidden" name="project" value="{{ $project->id }}" />
    @endisset

    <div class="grid gap-4">
        <x-form.input type="text" :value="$board->name" label="Board Name" name="name" help="Something short and useful (IT New Hire Tasks, or Accounting's Tasks)" />

        <x-form.input type="date" :value="$board->due_date" label="Due Date" name="due_date" />

        @if($newBoard)
            <x-form.textarea label="Initial Tasks (1 per line)" name="tasks" rows="10" />
        @endif

        {{ $slot }}
    </div>

    <button type="submit" class="mt-4 btn btn-primary">
        {{ $newBoard ? 'Add' : 'Update' }} Board
    </button>

</form>
