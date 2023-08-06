<div>
    <div class="text-xl font-bold">
        Update status on {{ $project->name }}
    </div>

    @if(!empty($project->currentStatus))
        <div class="my-2 px-3 py-2 border-l-4 border-blue-800 bg-blue-50">
            <span class="text-xs text-blue-700">Current status</span>
            <br>
            {{ $project->currentStatus->status }}
        </div>
    @endif

    <form wire:submit.prevent="updateThatStatus">
        <div class="grid gap-4">
            <x-form.select label="Change Project Status" display="vertical" :options="$statusOptions" name="project_status" wire:model="newStatus" />

            <x-form.textarea placeholder="Something something" display="vertical" name="newstatus" wire:model="newStatusDescription" label="New Status" />

            <div class="flex items-center">
                <button type="submit" class="btn btn-primary">
                    Update Status
                </button>
                <button wire:click="$parent.closeProjectUpdateForm" type="button" class="ml-4 btn btn-white">
                    Nevermind
                </button>
            </div>
        </div>
    </form>
    input,
    save,
    change sstatus option
</div>
