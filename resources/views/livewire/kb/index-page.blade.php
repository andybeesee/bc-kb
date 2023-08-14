<div>
    <div class="mx-2 md:mx-10 button-tabs">
        <button
            wire:click.self="$set('tab', 'dashboard')"
            class="{{ $tab == 'dashboard' ? 'active' : '' }}"
            title="Show dashboard"
        >
            <x-icon icon="newspaper" class="h-4 w-4" />
            Dashboard
        </button>
        <button
            wire:click.self="$set('tab', 'articles-index')"
            class="{{ $tab == 'articles-index' ? 'active' : '' }}"
            title="Show dashboard"
        >
            <x-icon icon="journal-richtext" class="h-4 w-4" />
            All Articles
        </button>
        <button
            wire:click.self="$set('tab', 'content-chunks-index')"
            class="{{ $tab == 'content-chunks-index' ? 'active' : '' }}"
            title="Show dashboard"
        >
            <x-icon icon="body-text" class="h-4 w-4" />
            Content Chunks
        </button>
        <button
            wire:click.self="$set('tab', 'new-article')"
            class="{{ $tab == 'new-article' ? 'active' : '' }}"
            title="Show dashboard"
        >
            <x-icon icon="pencil-square" class="h-4 w-4" />
            New Article
        </button>
    </div>


    <div class="mt-5 md:mx-10">
        @switch($tab)
            @case('articles-index')
                <livewire:kb.article-list-index />
                @break
            @case('content-chunks-index')
                <livewire:kb.chunk-list-index />
                @break
            @case('new-article')
                TODO: new article form
                @break
            @case('dashboard')
                <div>
                    recently updated articles, articles with recent comments, your change suggestions, popular articles, etc.
                </div>
                @break
        @endswitch
    </div>
</div>
