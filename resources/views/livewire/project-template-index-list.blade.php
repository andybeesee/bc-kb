<div>
    <div class="mb-4">
        <input x-init="$el.focus()" type="text" class="w-full form-control" placeholder="Search" wire:model.live="search" />
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Task Groups</th>
            <th>Updated</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projectTemplates as $pTemplate)
            <tr>
                <td>{{ $pTemplate->name }}</td>
                <td>{{ $pTemplate->task_group_templates_count }}</td>
                <td>{{ $pTemplate->updated_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {!! $projectTemplates->links() !!}
    </div>
</div>
