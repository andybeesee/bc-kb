<x-layouts.project-layout :project="$project">

    <form class="md:w-1/3" method="post" action="{{ route('projects.update', $project) }}">
        @csrf
        @method('put')

        <x-project.form :project="$project " />

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                Save Changes
            </button>
            <a href="{{ route('projects.show', $project) }}" class="btn btn-white ml-3">
                Nevermind
            </a>
        </div>

    </form>



</x-layouts.project-layout>
