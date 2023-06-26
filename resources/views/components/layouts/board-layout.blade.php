@props(['board'])
<x-app-layout title="Board Detail">
    <div class="container">
        {{ Breadcrumbs::render() }}
        <h1>{{ $board->name }}</h1>


        <div class="subtitle">
            Due date, owner, misc. counts here,
        </div>

        <div>
            <div class="mb-5">
                <div class="sub-nav">
                    <a class="link" href="{{ route('boards.show', $board) }}" data-exact-active="y">Dashboard</a>
                    <a class="link" href="{{ route('boards.edit', $board) }}">Edit</a>
                    <a class="link" href="#">Projects</a>
                </div>
            </div>

            {{ $slot }}
        </div>
</x-app-layout>
