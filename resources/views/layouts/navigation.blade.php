@php
    $links = [
        ['name' => 'Dashboard', 'href' => '#'],
        ['name' => 'Projects', 'href' => route('projects.index')],
        ['name' => 'Boards', 'href' => '#'],
        ['name' => 'Templates', 'href' => '#'],
    ];
@endphp

<nav hx-boost="true">
    <div class="hidden md:flex justify-between items-center max-w-4xl mx-auto">
        <a href="/" class="px-1 py-2 font-bold text-indigo-100">BCKB</a>
        <div class="flex space-x-4">
            @foreach($links as $link)
                <a class="px-1 py-2 hover:underline" href="{{ $link['href'] }}" active-class="font-bold">
                    {{ $link['name'] }}
                </a>
            @endforeach
        </div>
        <div>
            <button class="px-1 py-2 hover:underline" type="button" hx-post="{{ route('logout') }}">Sign out {{ auth()->user()->name }}</button>
        </div>
    </div>
    <div class="md:hidden" data-controller="toggle">
        <div class="flex justify-between border-b">
            <a class="px-3 py-2" href="/">BC KB</a>
            <button class="px-3 py-1" type="button" data-action="click->toggle#toggle">
                <x-icon data-toggle-target="closedIcon" class="h-6 w-6" icon="list" />
                <x-icon data-toggle-target="openIcon" style="display: none" class="h-6 w-6" icon="x-circle" />
            </button>
        </div>
        <div class="flex flex-col border-b" data-toggle-target="content">
            @foreach($links as $link)
                <a class="px-3 py-2 hover:underline" href="{{ $link['href'] }}" active-class="font-bold">
                    {{ $link['name'] }}
                </a>
            @endforeach
            <button class="text-left px-3 py-2 hover:underline" type="button" hx-post="{{ route('logout') }}">Sign out {{ auth()->user()->name }}</button>
        </div>
    </div>
</nav>
