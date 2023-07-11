<div>
    <div class="card" x-data="{}" x-filedrop="{ eventName: 'fileListAttached' }">
        <div class="card-title">
            Files
        </div>
        <div class="card-body">
            <div class="grid divide-y divide-zinc-300">
                @if($attachedFiles->count() === 0)
                    <div class="py-3">
                        No Files! Drag and drop to attach files.
                    </div>
                @endif
                @foreach($attachedFiles as $file)
                    @if(in_array($file->id, $editing))
                        <div class="py-2">
                            <livewire:attached-file-edit-form :file="$file" />
                        </div>
                    @else
                        <div class="p-2 flex items-center">
                            <a
                                href="{{ route('files.download', $file->id) }}"
                                class="link"
                                target="_blank"
                            >
                                {{ $file->filename }}
                            </a>

                            <button wire:click="startEditing({{ $file->id }})" class="btn btn-white btn-xs ml-auto">
                                Edit
                            </button>
                            <button class="btn btn-danger btn-xs ml-3">
                                Delete
                            </button>
                        </div>
                    @endif

                @endforeach
            </div>
        </div>
    </div>
</div>
