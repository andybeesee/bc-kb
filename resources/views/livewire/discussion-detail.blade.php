<div>
    <h1>{{ $discussion->name }}</h1>

    <div>
        <livewire:comment-list attached-type="discussion" :attached-id="$discussion->id" />
    </div>
</div>
