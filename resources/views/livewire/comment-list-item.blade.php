<div class="p-3" x-data="{
    confirmDelete() {
        if(confirm('really?')) {
            this.$wire.destroy();
        }
    }
}">
    @if($editing)
        <form wire:submit="saveChange">
            <x-form.textarea name="updatedcomment" label="Update Your Comment" wire:model="updatedComment" />

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    Save Changes
                </button>
                <button type="button" class="btn btn-white" wire:click="$set('editing', false)">
                    Cancel
                </button>
            </div>
        </form>
    @else
        <div class="text-sm text-zinc-600 dark:text-zinc-400">
            {{ $comment->creator->name }} on {{ $comment->created_at->format(config('app.date_display')) }}

            @can('update', $comment)
                <button wire:click="startEditing" type="button" class="btn ml-6 btn-xs btn-white">Edit</button>
                <button @click="confirmDelete" type="button" class="btn btn-xs btn-danger">delete</button>
            @endcan
        </div>
        <div class="max-w-3xl">
            {{-- TODO: Rich text support --}}
            {{ $comment->comment }}
        </div>
    @endif
</div>
