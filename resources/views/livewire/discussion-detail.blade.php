<div>
    <h1>{{ $discussion->subject }}</h1>

    <div>
        <livewire:comment-list attached-type="discussion" :attached-id="$discussion->id" />
    </div>
</div>
