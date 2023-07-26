<div>
    @if($editing)
        <div class="py-2">
            <form class="p-2 grid gap-4" wire:submit="save">
                <x-form.input
                    autofocus
                    label="Filename"
                    type="text"
                    class="form-control form-control-sm"
                    name="filename"
                    wire:model="filename"
                />

                <x-form.input
                    label="Replace File"
                    type="file"
                    help="Leave empty if you don't want to change the file"
                    wire:model="newFile"
                    class="form-control form-control-sm"
                    name="newfile"
                />

                <div class="flex items-center ">
                    <button type="submit" class="btn btn-primary btn-sm">
                        Save
                    </button>
                    <button type="button" wire:click="cancelEditing" class="ml-3 btn btn-white btn-sm">
                        Cancel
                    </button>
                </div>

            </form>
        </div>
    @else
        <div class="p-2">
            <div class="flex items-center">
                <a href="{{ route('files.download', $file->id) }}" class="link" target="_blank">
                    {{ $file->filename }}
                </a>

                <button type="button" wire:click="startEditing({{ $file->id }})" class="btn btn-white btn-xs ml-auto">
                    Edit
                </button>
                <button type="button" @click="deleteFile({{ $file->id }})" class="btn btn-danger btn-xs ml-3">
                    Delete
                </button>
            </div>
            @if($showRelated)
                <div class="text-sm">
                    @switch($file->attached_type)
                        @case('task')
                            Task <a href="{{ route('tasks.show', $file->attached_id) }}" class="link">#{{ $file->attached_id }}</a> - {{ $file->attached->name }}
                            @break

                    @endswitch
                </div>
            @endif
        </div>
    @endif
</div>
