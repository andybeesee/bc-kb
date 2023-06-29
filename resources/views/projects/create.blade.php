<x-app-layout title="New Project">
    <div class="container">
        <h1>New Project</h1>
        <form class="md:w-1/3" method="post" action="{{ route('projects.store') }}">
            @csrf

            <x-project.form />

            {{-- TODO: Select template to pre-populate --}}

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    Add Project
                </button>
            </div>


        </form>
    </div>
</x-app-layout>
