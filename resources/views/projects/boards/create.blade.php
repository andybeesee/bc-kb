<x-layouts.project-layout :project="$project">
    <h2>Adding a Board</h2>

    <div class="flex items-center space-x-3 mb-5">
        <a class="btn icon start" href="?how=select">
            @if($how === 'select')
                <x-icon icon="check-circle" />
            @endif
            Select an Existing Board
        </a>
        <a class="btn icon" href="?how=create">
            @if($how === 'create')
                <x-icon icon="check-circle" />
            @endif
            Create a New Board
        </a>
    </div>

    @if($how === 'select')
        project select input
    @elseif($how === 'create')
        <x-board.create-form :project="$project" context="project" />
    @endif
</x-layouts.project-layout>
