<div>
    <div class="card" x-data="{}" x-filedrop="{ eventName: 'fileListAttached' }">
        <div class="card-title">
            Files
        </div>
        <div
            class="card-body"
            x-data="{
                deleteFile(fileId) {
                    if(confirm('really delete it?')) {
                        $wire.deleteFile(fileId);
                    }
                }
            }"
        >
            <div class="grid divide-y divide-zinc-300">
                @if($attachedFiles->count() === 0)
                    <div class="py-3">
                        No Files! Drag and drop to attach files.
                    </div>
                @endif
                @foreach($attachedFiles as $file)
                    <livewire:attached-file-list-item :file="$file" wire:key="{{$file->id}}-{{ $file->updated_at->getTimestamp() }}"/>
                @endforeach
            </div>
        </div>
    </div>

    @if(!is_null($relatedFiles))
        <div class="card mt-4">
            <div class="card-title">Related Files</div>
            <div class="card-body">
                <p>These are files attached to related items</p>
                <div class="grid divide-y divide-zinc-300">
                    @foreach($relatedFiles as $relatedFile)
                        <livewire:attached-file-list-item
                            :file="$relatedFile"
                            :show-related="true"
                            wire:key="{{$relatedFile->id}}-{{ $relatedFile->updated_at->getTimestamp() }}"
                        />
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
