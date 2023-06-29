<x-app-layout title="Team">
    <div class="container">
        <h1>Editing {{ $team->name }}</h1>

        <form method="post" action="{{ route('admin.teams.update', $team) }}">
            @csrf
            @method('PUT')

            <x-form.input name="name" label="Name" :value="$team->name" />

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    Save Changes
                </button>

                <a href="{{ route('admin.teams.show', $team) }}" class="btn btn-white ml-2">
                    Nevermind
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
