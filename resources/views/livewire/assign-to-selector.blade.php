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
                    <span title="{{ $assignedTo->name }}" class="truncate">
                        {{ $assignedTo->name }}
                    </span>

                    {{-- TODO: some better wayt o show it is assigned to the current user --}}
                    @if($assignedToCurrentUser)
                        <span class="ml-1 text-xs text-blue-700">(You)</span>
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
                    @if(!empty($assignedTo))
                        <button
                            wire:click="$emit('removeAssigned', {{$modelId}})"
                            class="p-1 flex items-center text-left text-sm bg-red-50 hover:bg-red-100"
                            type="button"
                        >
                            Remove Assignment

                            <x-icon icon="x-circle" class="ml-auto h-4 w-4" />
                        </button>
                    @endif
                    @foreach($this->userOptions as $userOpt)
                        @php $assignedToThisUser =  $assignedTo?->id === $userOpt->id; @endphp
                        <button
                            wire:click="$emit('assigned', {{$modelId}}, {{$userOpt->id}})"
                            class="{{ $assignedToThisUser ? 'bg-indigo-100' : '' }} p-1 flex items-center text-left text-sm hover:bg-zinc-100"
                            type="button"
                        >
                            {{ $userOpt->name }}
                            @if($userOpt->id === auth()->user()->id)
                                <span class="text-xs text-blue-700">(You)</span>
                            @endif
                            @if($assignedToThisUser)
                                <x-icon icon="check-circle" class="ml-auto h-4 w-4" />
                            @endif
                        </button>
                    @endforeach
                </div>

                select users up in her
            </div>
        </x-slot>
    </x-dropdown>
</div>
