<div>
    {{--TODO: Permissions checks --}}
    {{-- TODO: search users --}}
    <x-dropdown
        wire:model="open"
        content-classes="rounded-md border min-h-[50px] min-w-[200px] z-[10] bg-white border-zinc-500 shadow-sm max-h-[250px] overflow-y-scroll"
    >
        <x-slot name="trigger">
            <button
                title="Change who this is assigned to"
                class="flex items-center hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-md px-1 py-0.5"
                type="button"
            >
                @if(!empty($assignedTo))
                    {{ $assignedTo->name }}
                    {{-- TODO: some better wayt o show it is assigned to the current user --}}
                    @if($assignedToCurrentUser)
                        <span class="text-xs text-blue-700">(You)</span>
                    @endif
                @else
                    <span class="text-zinc-300">Not Assigned</span>
                @endif

                <x-icon icon="caret-down-fill" class="text-zinc-500 mt-1.5 h-2 w-2 ml-1" />
            </button>
        </x-slot>

        <x-slot name="content">
            <div
                x-show="open"
                style="display: none;"
            >
                <div class="grid divide-y divide-zinc-400">
                    @foreach($this->userOptions as $userOpt)
                        <button
                            wire:click="$emit('assigned', {{$modelId}}, {{$userOpt->id}})"
                            class="p-1 text-left text-sm hover:bg-zinc-100"
                            type="button">
                            {{ $userOpt->name }}
                        </button>
                    @endforeach
                </div>

                select users up in her
            </div>
        </x-slot>
    </x-dropdown>
</div>
