@props(['board', 'project', 'task'])
@php
    $nextTask = \App\Models\Task::where('board_id', $board->id)
        ->where('id', '!=', $board->id)
        ->where('sort', '>', $board->sort)
        ->orderBy('sort', "ASC")
        ->first();

    $previousTask = \App\Models\Task::where('board_id', $board->id)
        ->where('id', '!=', $board->id)
        ->where('sort', '<', $board->sort)
        ->orderBy('sort', "DESC")
        ->first();

@endphp
<x-app-layout :project="$project">
    <div class="container">
        <div class="mb-4">
            <h1>{{ $task->name }}</h1>
            <div class="flex items-center subtitle space-x-4">
                <div class="subtitle" title="Project">
                    Project:
                    <a class="underline hover:text-blue-400" href="{{ route('projects.boards.index', $project) }}">
                        {{ $project->name }}
                    </a>
                </div>

                <div class="subtitle" title="Board">
                    Board:
                    <a class="underline hover:text-blue-400" href="{{ route('projects.boards.show', [$project, $board]) }}">
                        {{ $board->name }}
                    </a>
                </div>
            </div>

        </div>

        <div class="sub-nav mb-5">
            <a href="{{ route('projects.boards.tasks.show', [$project, $board, $task]) }}" class="link">Dashboard</a>
            <a href="{{ route('projects.boards.tasks.edit', [$project, $board, $task]) }}" class="link">Edit</a>
        </div>

        <div class="mb-10">
            {{ $slot }}
        </div>

        <div hx-boost="true" class="grid grid-cols-2">
            <div class="text-sm text-left">
                @if($previousTask)
                    <a class="link inline-flex items-center" href="{{ route('projects.boards.tasks.show', [$project, $board, $previousTask]) }}">
                        <x-icon icon="chevron-left" class="h-5 w-5 mr-1.5" />
                        {{ $previousTask->name }}
                    </a>
                @endif

            </div>
            <div class="text-sm text-right">
                @if($nextTask)
                    <a class="link inline-flex items-center" href="{{ route('projects.boards.tasks.show', [$project, $board, $nextTask]) }}">
                        {{ $nextTask->name }}
                        <x-icon icon="chevron-right" class="h-5 w-5 mr-1.5" />
                    </a>
                @endif
            </div>
        </div>

    </div>

</x-app-layout>
