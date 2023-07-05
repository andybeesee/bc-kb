<div x-data="{ addingGroup: false }">
    {{--TODO: we need to do groupings on here... and update accordingly when livewire event happens... ick --}}
    <div class="card">
        <div class="card-title">
            Tasks <span class="text-sm font-normal text-zinc-500">Ungrouped tasks</span>
        </div>
        <div class="card-body divide-y divide-zinc-300" x-sortable="{ options: { handle: '.handle' } }">
            @foreach($tasks as $task)
                <x-task.list-item class="py-2 px-1" :task="$task" :sortable="true" />
            @endforeach
        </div>
    </div>

    <div class="my-3">
        <div>
            <button class="btn btn-white" x-show="!addingGroup" type="button" @click="addingGroup = true">
                Add a Group
            </button>
        </div>
        <div class="card" x-show="addingGroup">
            <div class="card-title">
                New Group
            </div>
            <form action="">
                <div class="card-body">
                    group name, new tasks, or import 'template group' option...after/before option?
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Add Group</button>
                    <button type="button" class="btn btn-white" @click="addingGroup = false">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    {{-- TODO: Group Sorting --}}
    {{-- TODO: Moving tasks between groups --}}

    @foreach($groups as $group)
        {{-- TODO: Dropdown to change color of section --}}
        <div class="mt-4 grid gap-4">
            <div class="card">
                <div class="card-title flex items-center">
                    <div class="mr-1 cursor-move handle">
                        <x-icon icon="grip-vertical" class="h-4 w-4" />
                    </div>
                    {{ $group->name }}
                </div>

                <div class="card-body divide-y divide-zinc-300" x-sortable="{ options: { handle: '.handle' } }">
                    @foreach($group->tasks as $task)
                        <x-task.list-item class="py-2 px-1" :task="$task" :sortable="true" />
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
