<div x-data="{ adding: @entangle('adding') }">
    <button type="button" class="btn btn-white" @click="adding = true" x-show="!adding">
        Start a New Discussion
    </button>

    <form class="card" x-show="adding" class="my-2" wire:submit="addNewDiscussion">
        <div class="card-title">
            New Discussion
        </div>
        <div class="card-body grid gap-4">
            <x-form.input type="text" display="vertical" label="Subject of Discussion" wire:model="newSubject" name="subj" />

            <x-form.textarea name="post" display="vertical" label="First Post" wire:model="newDiscussionPost" />
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                Add Discussion
            </button>
            <button type="button" class="ml-2 btn btn-white" @click="adding = false">
                Nevermind
            </button>
        </div>
    </form>
    @foreach($discussions as $discussion)
        <div>
            {{ $discussion->subject }}
        </div>
    @endforeach
</div>
