<div>
    <div class="mb-4">
        <input x-init="$el.focus()" type="text" class="w-full form-control" placeholder="Search" wire:model.live="search" />
    </div>
    <table class="table table-fixed">
        <thead>
        <tr>
            <th style="width: 2%">ID</th>
            <th style="width: 13%">Name</th>
            <th style="width: 3%">Task Groups</th>
            <th style="width: 5%">Updated</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projectTemplates as $pTemplate)
            <tr>
                <td>
                    <a wire:navigate.hover href="{{ route('project-templates.show', $pTemplate->id) }}" class="link">
                        {{ $pTemplate->id }}
                    </a>
                </td>
                <td>
                    <a wire:navigate.hover href="{{ route('project-templates.show', $pTemplate->id) }}" class="link">
                        {{ $pTemplate->name }}
                    </a>
                </td>
                <td>{{ $pTemplate->checklist_templates_count }}</td>
                <td>
                    <x-datetime :date="$pTemplate->updated_at" />
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {!! $projectTemplates->links() !!}
    </div>
</div>
