<div class="container">

    @if($editing)
        <form class="grid gap-4 mb-4" wire:submit.prevent="saveChanges">
            <x-form.input display="vertical" type="text" label="Template Name" wire:model="updatedName" name="updatedName" />

            <x-form.textarea display="vertical" label="Template description" wire:model="updatedDescription" name="updatedDescription" />

            <div class="flex items-center">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <button type="button" wire:click="$set('editing', false)" class="ml-4 btn btn-white">Nevermind</button>
            </div>

        </form>
    @else
        <div class="mb-4">
            <span class="text-sm">Project Template</span>

            <div class="flex items-center">
                <h1>{{ $projectTemplate->name }}</h1>
            </div>
            <p class="max-w-2xl mb-4">{{ $projectTemplate->description }}</p>

            <div class="flex items-center space-x-3">
                <button class="btn btn-white btn-sm" type="button" wire:click="$set('editing', true)">Edit Name/Description</button>
                <a class="btn btn-primary btn-sm" href="{{ route('projects.index', ['tab' => 'new', 'template' => $projectTemplate->id]) }}">Start New Project</a>
            </div>

        </div>
    @endif
    <div
        class="card"
        x-data="{
            init() {
                new Sortable(this.$refs.groupList, {
                    handle: '.handle',
                    onEnd: () => {
                        const ids = Array.from(this.$refs.groupList.querySelectorAll(`[data-id]`))
                            .map(el => el.getAttribute('data-id'));

                        $wire.updateOrder(ids);
                    }
                });
            }
        }"
    >
        <div class="card-title">Checklists</div>
        <div x-ref="groupList">
            {{-- TODO: INline sorting/editing right here to add/remove --}}
            @foreach($projectTemplate->checklistTemplates as $tgt)
                <div class="px-3 py-1 flex items-center" data-id="{{ $tgt->id }}">
                    <x-icon icon="grip-vertical" class="handle cursor-move h-3 w-3 mr-1" />
                    <a class="link" href="{{ route('checklist-templates.show', $tgt->id) }}">{{ $tgt->name }}</a>
                    <button type="button" wire:click="removeChecklist({{ $tgt->id }})" class="text-red-800 dark:text-red-300" title="Remove Group">
                        <x-icon icon="x-circle" class="h-4 w-4 ml-2" />
                    </button>
                </div>
            @endforeach
        </div>
        <form class="p-3" wire:submit="addChecklist">
            <x-form.select display="vertical" label="Add New Checklist" name="newchecklist" wire:model="newChecklistTemplate">
                <option value=""></option>
                @foreach($this->newGroupOptions as $opt)
                    <option value="{{ $opt->id }}">{{ $opt->name }}</option>
                @endforeach
            </x-form.select>

            <button class="btn btn-primary mt-4">Add Checklist Template</button>
        </form>
    </div>
</div>
