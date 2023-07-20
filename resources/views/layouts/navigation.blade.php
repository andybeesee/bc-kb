@php
    $links = [
        ['name' => 'Dashboard', 'href' => route('dashboard')],
        ['name' => 'Projects', 'href' => route('projects.index')],
        // ['name' => 'Boards', 'href' => route('boards.index')],
        ['name' => 'Templates', 'href' => '#'],
    ];

    if(auth()->user()->admin){
        $links[] = [
            'name' => 'Teams Admin',
            'href' => route('admin.teams.index'),
        ];
    }
@endphp

<nav>
    <div class="hidden md:flex px-10 justify-between items-center container border-b border-zinc-500">
        <a href="/" class="px-1 py-2 font-bold text-indigo-600 dark:text-indigo-100">BCKB</a>
        <div class="flex space-x-4">
            @foreach($links as $link)
                <a
                    class="px-1 py-2 dark:text-zinc-600 hover:underline"
                    href="{{ $link['href'] }}"
                    data-active-class="font-bold dark:text-zinc-100 text-zinc-800"
                    data-inactive-class="dark:text-zinc-600 text-zinc-500 hover:underline hover:text-zinc-700 dark:hover:text-zinc-300"
                >
                    {{ $link['name'] }}
                </a>
            @endforeach
        </div>
        <div>
            <button
                class="px-1 py-2 hover:underline text-zinc-800 dark:text-zinc-200 "
                type="button"
                onclick="document.getElementById('logout-form').submit()"
            >
                Sign out {{ auth()->user()->name }}
            </button>
        </div>
    </div>
    <div  x-data="{ mobileMenuOpen: false }" class="md:hidden">
        <div class="flex justify-between border-b">
            <a class="px-3 py-2" href="/">BC KB</a>
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="px-3 py-1" type="button">
                <x-icon x-show="!mobileMenuOpen" class="h-6 w-6" icon="list" />
                <x-icon x-show="mobileMenuOpen" style="display: none" class="h-6 w-6" icon="x-circle" />
            </button>
        </div>
        <div class="flex flex-col border-b" x-show="mobileMenuOpen" style="display: none;">
            @foreach($links as $link)
                <a class="px-3 py-2 hover:underline" href="{{ $link['href'] }}" active-class="font-bold">
                    {{ $link['name'] }}
                </a>
            @endforeach
            <button class="text-left px-3 py-2 hover:underline" type="button" onclick="document.getElementById('logout-form').submit()">
                Sign out {{ auth()->user()->name }}
            </button>
        </div>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="post">
        @csrf
    </form>
</nav>
