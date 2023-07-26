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
        class="absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }}"
        style="display: none;"
        @click.outside="open = false"
    >
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
