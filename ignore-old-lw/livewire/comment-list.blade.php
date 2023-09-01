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
            @foreach($comments as $comment)
                <div class="p-3" id="comment-{{ $comment->id }}" x-data="{
                    editing: false,
                    commentId: {{ $comment->id }},
                    updatedComment: `{{ $comment->comment }}`,
                    comment: `{{ $comment->comment }}`,
                    confirmDelete() {
                        if(confirm('really?')) {
                            this.$wire.destroyComment(this.commentId);
                        }
                    },
                    saveChange() {
                        this.$wire.saveChange(this.commentId, this.updatedComment);
                        this.comment = this.updatedComment;
                        this.editing = false
                    },
                }">
                    @can('update', $comment)
                        <form @submit.prevent="saveChange" x-show="editing">
                            <x-form.textarea value="{{ $comment->comment }}" display="vertical" name="updatedcomment" label="Update Your Comment" x-model="updatedComment" />

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    Save Changes
                                </button>
                                <button type="button" class="btn btn-white" @click="editing = false">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    @endcan

                    <div x-show="!editing" class="text-sm text-zinc-600 dark:text-zinc-400">
                        {{ $comment->creator->name }} on {{ $comment->created_at->format(config('app.date_display')) }}

                        @can('update', $comment)
                            <button @click="editing = true" type="button" class="btn ml-6 btn-xs btn-white">Edit</button>
                            <button @click="confirmDelete" type="button" class="btn btn-xs btn-danger">delete</button>
                        @endcan
                    </div>
                    <div class="max-w-3xl" x-text="comment">
                        {{-- TODO: Rich text support --}}
                        {{ $comment->comment }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
