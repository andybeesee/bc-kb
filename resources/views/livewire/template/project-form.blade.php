<form wire:submit="save" class="grid gap-4">
    <x-form.input type="text" name="name" wire:model="name" label="Name" />

    <x-form.textarea name="description" wire:model="description" label="Description" help="When should you use this?" />

    <div class="form-group">
        <div class="form-label">Include Task Groups</div>
        <div class="form-control-container">
            <div x-data="{ open: false }">
                <button @click="open = !open" type="button">Select a task group</button>
                <div style="display: none;" x-show="open" @click.outside="open = false">
                    <div>
                        @foreach($groupOptions as $groupOpt)
                            <div class="hover:bg-zinc-100 cursor-pointer" @click="addGroup('{{ $groupOpt->toJson() }}')">
                                {{ $groupOpt->name }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="group-list grid">
                selected groups!
            </div>
        </div>
    </div>


</form>
