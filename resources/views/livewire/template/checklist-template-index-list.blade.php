<div>
    <div class="mb-4">
        <input x-init="$el.focus()" type="text" class="w-full form-control" placeholder="Search" wire:model.live="search" />
    </div>
    <table class="table">
        <thead>
        <tr>
            <th style="width: 4%">Id</th>
            <th style="width: 25%">Name</th>
            <th style="width: 8%">Tasks</th>
            <th style="width: 8%">Updated</th>
        </tr>
        </thead>
        <tbody>
        @foreach($checklistTemplates as $tgTemplate)
            <tr>
                <td>
                    <a href="{{ route('checklist-templates.show', $tgTemplate->id) }}" class="link">
                        {{ $tgTemplate->id }}
                    </a>
                </td>
                <td>
                    <a href="{{ route('checklist-templates.show', $tgTemplate->id) }}" class="link">
                        {{ $tgTemplate->name }}
                    </a>
                </td>
                <td>{{ count($tgTemplate->tasks) }}</td>
                <td>
                    <x-datetime :date="$tgTemplate->updated_at" />
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {!! $checklistTemplates->links() !!}
    </div>
</div>
