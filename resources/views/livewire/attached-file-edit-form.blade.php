<div>
    <form class="p-2 grid gap-4" wire:submit.prevent="save">

        <x-form.input
            autofocus
            label="Filename"
            type="text"
            class="form-control form-control-sm"
            name="filename"
            wire:model="filename"
        />

        <x-form.input
            label="Replace File"
            type="file"
            help="Leave empty if you don't want to change the file"
            wire:model="newFile"
            class="form-control form-control-sm"
            name="newfile"
        />

        <div class="flex items-center ">
            <button type="submit" class="btn btn-primary btn-sm">
                Save
            </button>
            <button type="button" wire:click="cancel" class="ml-3 btn btn-white btn-sm">
                Cancel
            </button>
        </div>

    </form>
</div>
