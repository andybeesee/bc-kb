<div x-data="{ adding: @entangle('adding') }">
    @if($openPostId)
        <div @modal-close="$wire.set('openPostId', null)">
            <x-modal name="whatevers">
                <div class="p-4">
                    <livewire:discussion-detail :discussion="$this->openDiscussion" />
                </div>
            </x-modal>
        </div>

    @endif
    <button type="button" class="btn btn-white" @click="adding = true" x-show="!adding">
        Start a New Discussion
    </button>

    {{ $openPostId }}

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

    <div class="mt-4 grid divide-y dark:divide-zinc-700 divide-zinc-400">
        @foreach($discussions as $discussion)
            <div class="p-2">
                <button @click="$wire.set('openPostId', {{ $discussion->id }})" class="link" type="button">{{ $discussion->subject }}</button>
                <div class="flex items-center">
                    <div class="text-zinc-600 dark:text-zinc-400">
                        Last Post by {{ $discussion->lastComment->creator->name  }} on <x-datetime :date="$discussion->lastComment->created_at" />
                    </div>
                    <div class="ml-auto text-zinc-600 dark:text-zinc-400">
                        Started by {{ $discussion->creator->name }} on <x-datetime :date="$discussion->created_at" />
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
