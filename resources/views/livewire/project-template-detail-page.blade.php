<div class="container">
    <span class="text-sm">Project Template</span>
    <h1>{{ $projectTemplate->name }}</h1>
    <p class="max-w-2xl mb-4">{{ $projectTemplate->description }}</p>
    <div class="card">
        <div class="card-title">Task Groups</div>
        <div>
            {{-- TODO: INline sorting/editing right here to add/remove --}}
            @foreach($projectTemplate->taskGroupTemplates as $tgt)
                <div class="px-3 py-1">
                    <a class="link" href="{{ route('task-group-templates.show', $tgt->id) }}">{{ $tgt->name }}</a>
                </div>
            @endforeach
        </div>
    </div>
</div>
