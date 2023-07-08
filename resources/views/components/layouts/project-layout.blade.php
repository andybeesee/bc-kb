@props(['project', 'board' => null])
<x-app-layout title="Project Detail">
    <div class="container">

        <h1>{{ $project->name }}</h1>

        <div class="meta mb-4">
            <div>
                <livewire:project-status-button :project="$project" />
            </div>
            @if(!empty($project->due_date))
                <div class="meta-item">
                    <x-icon icon="calendar3" />
                    Due {{ $project->due_date->format(config('app.date_display')) }}
                </div>
            @endif
            @if(!empty($project->completed_date))
                <div class="meta-item">
                    {{-- TODO: use 'calendar2-x' icon if completed late --}}
                    <x-icon icon="calendar2-check" />
                    Due {{ $project->completed_date->format(config('app.date_display')) }}
                </div>
            @endif
            @if(!empty($project->team))
                <div class="meta-item" title="Team">
                    <x-icon icon="people-fill" />
                    {{ $project->team->name }}
                </div>
            @endif

            @if(!empty($project->owner))
                <div class="meta-item" title="Owner">
                    <x-icon icon="person" />
                    {{ $project->owner->name }}
                </div>
            @endif
        </div>

        <div>
            <div class="mb-5">
                 <div class="sub-nav">
                    <a class="link" href="{{ route('projects.show', $project) }}" data-exact-active="y">Tasks</a>
                    <a class="link" href="{{ route('projects.edit', $project) }}">Edit</a>
                    <a class="link" href="#">Files</a>
                     <a class="link" href="#">Discussion</a>
                </div>
            </div>


            @if(!empty($board))
                <h2>{{ $board->name }}</h2>
            @else
                {{ $slot }}

            @endif


    </div>
</x-app-layout>
