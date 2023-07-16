<div>
    <div class="mb-6">
        <div class="flex items-center">
            <div class="mb-2 text-3xl font-bold font-serif">{{ $project->name }}</div>
            
            projectDetailClosed
        </div>

        <div>
            <livewire:project-status-button :project="$project" />
        </div>
    </div>
</div>
