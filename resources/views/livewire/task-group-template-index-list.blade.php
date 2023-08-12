<div>
    <div class="mb-4">
        <input x-init="$el.focus()" type="text" class="w-full form-control" placeholder="Search" wire:model.live="search" />
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Tasks</th>
            <th>Updated</th>
        </tr>
        </thead>
        <tbody>
        @foreach($taskGroupTemplates as $tgTemplate)
            <tr>
                <td>{{ $tgTemplate->name }}</td>
                <td>{{ count($tgTemplate->tasks) }}</td>
                <td>{{ $tgTemplate->updated_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {!! $taskGroupTemplates->links() !!}
    </div>
</div>
