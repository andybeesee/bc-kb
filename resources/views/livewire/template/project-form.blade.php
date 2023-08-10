<form wire:submit="save" class="grid gap-4">
    <x-form.input type="text" name="name" wire:model="name" label="Name" />

    <x-form.textarea name="description" wire:model="description" label="Description" help="When should you use this?" />

    <div class="form-group">
        <div class="form-label">Include Task Groups</div>
        <div
            class="form-control-container"
            x-data="{
                groups: @entangle('groups').live,
                addGroup(id) {
                    this.groups.push(id);
                },
                removeGroup(id) {
                    this.groups = this.groups.filter(g => g !== id);
                }
            }"
        >
            <div class="grid grid-cols-2 w-2/3 gap-4">
                <div>
                    <div class="text-xs text-zinc-400 mb-0.5">Click a Group to Select</div>
                    <div class="h-[250px] overflow-y-scroll border border-zinc-500">
                        <input wire:model.live.debounce="groupSearch" type="text" placeholder="Search Groups" class="w-full form-control form-control-sm" />
                        <div class="divide-y divide-zinc-500">
                            @foreach($this->groupOptions as $groupOpt)
                                <div class="p-1 hover:bg-zinc-100 dark:hover:bg-zinc-900 cursor-pointer" @click="addGroup('{{ $groupOpt->id }}')">
                                    {{ $groupOpt->name }}
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
                <div>
                    <div class="text-xs text-zinc-400 mb-0.5">Selected Groups</div>
                    <div class="h-[250px] overflow-y-scroll border-zinc-500 border divide-y divide-zinc-500">
                        @foreach($this->selectedGroups as $selGroup)
                            <div class="p-1 hover:bg-zinc-100 dark:hover:bg-zinc-900 cursor-pointer" @click="removeGroup('{{ $selGroup->id }}')">
                                {{ $selGroup->name }}
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="form-label"></div>
        <div class="form-control-container">
            <button type="submit" class="btn btn-primary w-2/3">
                Add Project Template
            </button>
        </div>
    </div>


</form>
