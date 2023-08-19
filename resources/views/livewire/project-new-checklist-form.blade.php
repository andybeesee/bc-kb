<?php

use Livewire\Volt\Component;

new class extends Component {
    public $projectId;

    public $how = 'new';

    public function getChecklistTemplateOptionsProperty()
    {
        if($this->how === 'import') {
            return ['1', 'two'];
        }

        return [];
    }
} ?>

<form wire:submit="handleAdd" class="card">
    <div class="card-header">
        Checklist Form
    </div>
    <div class="card-body">
        <x-form.radio-container label="How you doing this?">
            <x-form.radio name="how" value="template" wire:model.live="how" label="Import from a Template" />
            <x-form.radio name="how" value="new" wire:model.live="how" label="Brand New Checklist" />
            <x-form.radio name="how" value="copy" wire:model.live="how" label="Copy from another Project" />
        </x-form.radio-container>
    </div>

    @switch($how)
        @case('template')
            <div>
                template
            </div>
        @break
        @case('new')
            <div>
                new
            </div>
        @break
        @case('copy')
            <div>
                copy
            </div>
        @break
    @endswitch

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">
            Add
        </button>
        <button type="button" class="btn btn-white">
            Nevermind
        </button>
    </div>
</form>
