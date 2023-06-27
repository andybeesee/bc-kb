<x-app-layout title="New Project">
    <div class="container">
        <h1>New Project</h1>
        <form method="post" action="{{ route('projects.store') }}">
            @csrf
            <div class="grid gap-4">
                <x-form.input label="Name" name="name" help="All projects must have a unique name" />

                <x-form.textarea label="Description" name="description" help="optionally put additional info in here" />

                <x-form.input type="date" name="due_date" label="Due Date" help="This is optional" />

                {{-- TODO: autocomplete statuses, we want defined status list to choose from? --}}
                <x-form.input
                    label="Status"
                    name="status"
                    value="Not Started"
                    help="Like: Future Project, In Progress, Cancelled, Completed"
                />
            </div>

            {{-- TODO: Select template to pre-populate --}}

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    Add Project
                </button>
            </div>


        </form>
    </div>
</x-app-layout>
