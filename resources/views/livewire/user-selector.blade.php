<div>
    {{--TODO: Permissions checks --}}
    {{-- TODO: search users --}}
    <x-dropdown
        wire:model="open"
        content-classes="rounded-md border min-h-[50px] min-w-[200px] z-[10] bg-white dark:bg-zinc-900 border-zinc-500 shadow-sm max-h-[250px] overflow-y-scroll"
    >
        <x-slot name="trigger">
            <button
                title="Change user"
                class="flex items-center hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-md px-1 py-0.5"
                type="button"
            >
                @if(!empty($user))
                    <span title="{{ $user->name }}" class="truncate">
                        {{ $user->name }}
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
                class="text-black dark:text-zinc-100"
                style="display: none;"
            >
                <div class="grid divide-y divide-zinc-400">
                    @if(!empty($user) &&! $disableRemove)
                        <button
                            wire:click="$dispatch('{{ $removeEvent }}', [{{$modelId}}])"
                            class="p-1 flex items-center text-left text-red-800 text-sm bg-red-50 dark:text-red-50 dark:bg-red-800 dark:hover:bg-red-600 hover:bg-red-100"
                            type="button"
                        >
                            Remove User

                            <x-icon icon="x-circle" class="ml-auto h-4 w-4" />
                        </button>
                    @endif
                    @foreach($this->userOptions as $userOpt)
                        @php $assignedToThisUser =  $user?->id === $userOpt->id; @endphp
                        <button
                            wire:click="$dispatch('{{ $changeEvent }}', [{{$modelId}}, {{$userOpt->id}}])"
                            class="{{ $assignedToThisUser ? 'dark:bg-indigo-700 bg-indigo-100' : '' }} p-1 flex items-center text-left text-sm hover:bg-zinc-100 dark:hover:bg-zinc-600"
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
            </div>
        </x-slot>
    </x-dropdown>
</div>
