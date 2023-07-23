<div>
    <div class="card">
        <div class="card-title">
            Comments
        </div>
        <form class="card-body" wire:submit.prevent="addComment">
            <x-form.textarea style="vertical" wire:model="newComment" name="comment" label="New Comment" />
            <button type="submit" class="mt-2 btn btn-primary">
                Add Comment
            </button>
        </form>
        <div>
            @foreach($comments as $comment)
                <div>
                    <livewire:comment-list-item :comment="$comment" wire:key="comm-{{ $comment->id }}-{{ $comment->updated_at->getTimestamp() }}" />
                </div>
            @endforeach
        </div>
    </div>
</div>
