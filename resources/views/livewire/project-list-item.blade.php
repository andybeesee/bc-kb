<div
    x-data="{ modifying: @entangle('modifying') }"
    class="flex items-center"
>
    @if($modifying)
        <x-modal name="proj-{{ $project->id }}-list-item-modal" :show="$modifying" @modal-close="modifying =  false">
            <div class="p-4">
                MODAL CONTENT
            </div>
        </x-modal>
    @endif
    <div class="flex items-start w-full">
        <div class="mr-3 mt-1 rounded-full bg-zinc-100 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300">
            <livewire:project-status-button wire:key="proj-stat-{{ $project->id }}-{{ $project->updated_at->getTimestamp() }}" :icon-only="true" icon-class="h-4 w-4" :project="$project" />
        </div>
        <div class="flex-grow">
            <div class="flex items-start w-full">
                <div class="flex items-center">
                    <div x-data="{menuOpen: false}" class="relative">
                        <button @click.stop="menuOpen = true" type="button" class="pt-1 mr-2 hover:bg-zinc-200 hover:dark:bg-zinc-900 rounded-full">
                            <x-icon icon="three-dots-vertical" class="h-4 w-4" />
                        </button>
                        <div @click.outside="menuOpen = false" x-show="menuOpen" class="min-w-[150px] absolute grid z-[100] rounded-md bg-white dark:bg-zinc-800 border border-zinc-500" style="display: none;">
                            <button type="button" class="p-2 text-left hover:bg-zinc-300 dark:hover:bg-zinc-900" wire:click.stop="openTab('edit')" >Edit Project</button>
                            <button type="button" class="p-2 text-left hover:bg-zinc-300 dark:hover:bg-zinc-900" wire:click.stop="openTab('update')" >Add an Update</button>
                        </div>
                    </div>
                    <div class="font-semibold">
                        {{ $project->name }}
                    </div>

                </div>
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
                    <div>
                        <x-icon icon="chevron-right" class="h-3 w-3" />
                    </div>
                </div>
            </div>
            <div class="text-xs mt-1 flex items-center space-x-4 text-zinc-500 dark:text-zinc-400">
                @if($project->due_date)
                    {{-- TODO: inline due date change? --}}
                    <div class="{{ $project->isLate ? 'text-red-600' : '' }}">
                        Due {{ $project->due_date->format(config('app.date_display')) }}
                    </div>
                @endif
                @if($project->currentStatus)
                    <div title="Update entered by {{ $project->currentStatus->creator->name }}">
                        Last update {{ $project->currentStatus->created_at->format(config('app.date_display')) }}: {{ $project->currentStatus->status }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
