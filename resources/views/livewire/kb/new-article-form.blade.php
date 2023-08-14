<form class="container" wire:submit="save">
    <div class="grid gap-4">
        <x-form.input type="text" name="title" wire:model="title" label="Article Title" />

        <x-form.input type="number" step="0.01" max="999.99" min="0.01" name="version" wire:model="version" label="Starting Version Number" />

        <x-form.textarea name="summary" wire:model="summary" label="Summary" />

        <x-form.checkbox label="Released?" name="released" wire:model="released" />
    </div>


    <div class="form-group mt-4">
        <div class="form-label"></div>
        <div class="form-group-container">
            <button type="submit" class="btn btn-primary">
                Create the Article
            </button>
        </div>
    </div>
</form>
