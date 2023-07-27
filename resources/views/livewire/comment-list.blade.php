<div>
    <div class="card">
        <div class="card-title">
            Comments
        </div>
        <form class="card-body" wire:submit="addComment">
            <x-form.textarea display="vertical" wire:model="newComment" name="comment" label="New Comment" />
            <button type="submit" class="mt-2 btn btn-primary">
                Add Comment
            </button>
        </form>
        <div>
            @foreach($this->comments as $comment)
                <livewire:comment-list-item :comment="$comment" :key="$attachedId.'-'.$attachedType.'-comm-'.$comment->id" />
            @endforeach
        </div>
    </div>
</div>
