<div>
    @foreach($discussions as $discussion)
        <div>
            {{ $discussion->subject }}
        </div>
    @endforeach
</div>
