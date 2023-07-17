<div class="mx-1 md:mx-6 lg:mx-10 grid grid-cols-4 gap-8 items-start">
    <div>
        <div class="mb-3">
            <x-form.input
                type="text" p
                laceholder="Search"
                class="p-1 text-sm"
                name="project_search"
                wire:model="projectSearch"
            />
        </div>
        <div class="grid">
            @foreach($this->projects as $project)
                <div
                    wire:click.self="$set('projectId', {{$project->id}})"
                    class="cursor-pointer text-sm p-2 flex truncate items-center rounded-md {{ $project->id === $projectId ? 'bg-purple-100 dark:bg-purple-700 hover:bg-purple-200 dark:hover:bg-purple-800' : 'hover:bg-zinc-100 hover:bg-zinc-700' }}"
                    title="{{ $project->name }} -- {{ $project->status }}"
                >
                    {{ $project->name }}
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-span-3">
        @if(empty($projectId))
            <div>
                Dashboard or somethign
            </div>
        @else
            <livewire:project-detail-page :project-id="$projectId" wire:key="container-project-detail-{{ $projectId }}" />
        @endif
    </div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
</div>
