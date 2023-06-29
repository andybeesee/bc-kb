<x-app-layout title="New Team">
    <div class="container">
        <h1>New Team</h1>

        <form method="POST" action="{{ route('admin.teams.store') }}">
            @csrf
            <x-form.input name="name" label="Name" />

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    Add Team
                </button>

                <a href="{{ route('admin.teams.index') }}" class="btn btn-white ml-2">
                    Nevermind
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
