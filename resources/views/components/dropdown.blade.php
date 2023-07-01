@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white dark:bg-gray-700'])

@php
switch ($align) {
    case 'left':
        $alignmentClasses = 'origin-top-left left-0';
        break;
    case 'top':
        $alignmentClasses = 'origin-top';
        break;
    case 'right':
    default:
        $alignmentClasses = 'origin-top-right right-0';
        break;
}

switch ($width) {
    case '48':
        $width = 'w-48';
        break;
}

// TODO: Introduce popper to auto flip dropdown to top?
@endphp

<div
    class="relative"
    @if(!empty($attributes->has('wire:model')))
        x-data="{ open: @entangle($attributes->wire('model')) }"
    @else
        x-data="{ open: false }"
    @endif
    @click.outside="open = false"
    @close.stop="open = false"
>
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div
        x-show="open"
        {{-- TODO: Animations ar ejanky when data is loaded asynchronously, need to fix that and re-enable
        x-transition.delay.100ms:enter="transition ease-out duration-200"
        x-transition.delay.100ms:enter-start="transform opacity-0 scale-95"
        x-transition.delay.100ms:enter-end="transform opacity-100 scale-100"
        x-transition.delay.100ms:leave="transition ease-in duration-75"
        x-transition.delay.100ms:leave-start="transform opacity-100 scale-100"
        x-transition.delay.100ms:leave-end="transform opacity-0 scale-95"
        --}}
        class="absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }}"
        style="display: none;"
        @click.outside="open = false"
    >
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
