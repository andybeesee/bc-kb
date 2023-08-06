@props(['project'])
@php
    $bgColors = \App\View\StatusColorUtils::getBackgroundColors($project->status);
@endphp
<div class="flex p-2 items-center {{ $bgColors }}">
    <div class="flex items-center w-full">
        <div class="flex-grow">
            <div class="flex items-center w-full">
                <div class="mr-2 rounded-full bg-zinc-100 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300">
                    <x-icon class="h-4 w-4 {{ \App\View\StatusColorUtils::getIconColors($project->status) }}" :icon="\App\View\StatusColorUtils::getIcon($project->status)" />
                </div>
                <a href="{{ route('projects.show', $project) }}" class="hover:underline font-semibold">
                    {{ $project->name }}
                </a>

                @if($project->team)
                    <span title="Team" class="ml-4 px-1 bg-zinc-100 dark:bg-zinc-700 rounded-md text-xs">{{ $project->team->name }}</span>
                @endif

                <div class="ml-auto flex items-center space-x-3">
                    @if($project->past_due_tasks_count > 0)
                        <div class="text-red-700 dark:text-red-500">
                            {{ $project->past_due_tasks_count }} Late Task{{ $project->past_due_tasks_count !== 1 ? 's' : '' }}
                        </div>
                    @endif
                    @if($project->incomplete_tasks_count > 0)
                        <div>
                            {{ $project->incomplete_tasks_count }} Open Task{{ $project->incomplete_tasks_count !== 1 ? 's' : '' }}
                        </div>
                    @endif
                    <a class="px-3 p-1" href="{{ route('projects.show', $project) }}">
                        <x-icon icon="arrow-right" class="h-5 w-5" />
                    </a>
                </div>
            </div>
            <div class="text-xs mt-1 flex items-center space-x-4 text-zinc-500 dark:text-zinc-400">
                @if($project->currentStatus)
                    <div title="Update entered by {{ $project->currentStatus->creator->name }}">
                        Last update {{ $project->currentStatus->created_at->format(config('app.date_display')) }}: {{ $project->currentStatus->status }}
                        <button @click="openForm({{ $project->id }})" class="underline hover:text-zinc-800" type="button">Update</button>
                    </div>
                @endif
                @if($project->due_date)
                    {{-- TODO: inline due date change? --}}
                    <div class="ml-auto {{ $project->isLate ? 'text-red-600' : '' }}">
                        Due {{ $project->due_date->format(config('app.date_display')) }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
