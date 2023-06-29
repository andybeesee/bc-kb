@props(['board', 'project'])
@php
    $nextBoard = \App\Models\Board::where('project_id', $project->id)
        ->where('id', '!=', $board->id)
        ->where('sort', '>', $board->sort)
        ->orderBy('sort', "ASC")
        ->first();

    $previousBoard = \App\Models\Board::where('project_id', $project->id)
        ->where('id', '!=', $board->id)
        ->where('sort', '<', $board->sort)
        ->orderBy('sort', "DESC")
        ->first();

@endphp
<x-app-layout :project="$project">
    <div class="container">
        <div class="mb-4">
            <h1>{{ $board->name }}</h1>
            <div class="subtitle" title="Project">
                Project:
                <a class="underline hover:text-blue-400" href="{{ route('projects.boards.index', $project) }}">
                    {{ $project->name }}
                </a>
            </div>
        </div>

        <div class="sub-nav mb-5">
            <a href="{{ route('projects.boards.show', [$project, $board]) }}" class="link">Dashboard</a>
            <a href="{{ route('projects.boards.edit', [$project, $board]) }}" class="link">Edit</a>
            <a href="{{ route('projects.boards.tasks.index', [$project, $board]) }}" class="link">Tasks</a>
            <a href="{{ route('projects.boards.tasks.create', [$project, $board]) }}" class="link">Add Task</a>
        </div>

        <div class="mb-10">
            {{ $slot }}
        </div>

        <div class="grid grid-cols-2">
            <div class="text-sm text-left">
                @if($previousBoard)
                    <a class="link inline-flex items-center" href="{{ route('projects.boards.show', [$project, $previousBoard]) }}">
                        <x-icon icon="chevron-left" class="h-5 w-5 mr-1.5" />
                        {{ $previousBoard->name }}
                    </a>
                @endif

            </div>
            <div class="text-sm text-right">
                @if($nextBoard)
                    <a class="link inline-flex items-center" href="{{ route('projects.boards.show', [$project, $nextBoard]) }}">
                        {{ $nextBoard->name }}
                        <x-icon icon="chevron-right" class="h-5 w-5 mr-1.5" />
                    </a>
                @endif
            </div>
        </div>

    </div>

</x-app-layout>
