<div>
    @if($iconOnly)
        <div>
            <div title="{{ $status }}" class="rounded-full {{ $colors }}">
                <x-icon :icon="$icon" class="{{ $iconClass }}" />
            </div>
        </div>
    @else
        @if(!$canChange)
            <div class="px-2 py-0.5 font-semibold border rounded-md {{ $colors }}">
                {{ $status }}
            </div>
        @else
            <x-dropdown
                wire:model="changing"
                align="left"
                content-classes="border border-zinc-400 bg-white z-[10] shadow"
            >
                <x-slot name="trigger">
                    <button
                        type="button"
                        class="flex items-center px-2 py-0.5 font-semibold border rounded-md {{ $hoverColors }} {{ $colors }}"
                    >
                        {{ $status }}
                        <x-icon icon="caret-down-fill" class="h-3 w-3 ml-2.5" />
                    </button>
                </x-slot>
                <x-slot name="content">
                    <div class="grid divide-y divide-zinc-200">
                        @if($changing)
                            @foreach(config('statuses') as $id => $name)
                                <button
                                    wire:click="setStatus('{{ $id }}')"
                                    class="p-2 text-left {{ $optionClasses[$id] }}"
                                    type="button"
                                >
                                    {{ $name }}
                                </button>
                            @endforeach
                        @endif
                    </div>
                </x-slot>
            </x-dropdown>
        @endif
    @endif
</div>
