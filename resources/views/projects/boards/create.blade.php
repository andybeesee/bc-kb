<x-layouts.project-layout :project="$project">
    <h2>Adding a Board</h2>

    <form method="get" class="grid mb-4 gap-0.5" >

        <label>
            <input onchange="event.target.closest('form').submit()" type="radio" value="select" name="how" {{ $how === 'select' ? "checked=checked" : "" }} />
            Select an Existing Board
        </label>

        <label>
            <input onchange="event.target.closest('form').submit()" type="radio" value="create" name="how" {{ $how === 'create' ? "checked=checked" : "" }} />
            Create a New Board
        </label>
    </form>

    @if($how === 'select')
        project select input
    @elseif($how === 'create')
        <x-board.create-form :project="$project" context="project" />
    @endif
</x-layouts.project-layout>
