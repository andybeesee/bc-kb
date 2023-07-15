<div class="p-3">
    <div class="text-sm text-zinc-600 dark:text-zinc-400">
        {{ $comment->creator->name }} on {{ $comment->created_at->format(config('app.date_display')) }}
    </div>
    <div class="max-w-3xl">
        {{-- TODO: Rich text support --}}
        {{ $comment->comment }}
    </div>
</div>
