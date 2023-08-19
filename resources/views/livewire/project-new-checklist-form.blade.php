<?php

use Livewire\Volt\Component;

new class extends Component {
    public $projectId;

    public $how = 'new';

    public $name = '';

    public $tasks = '';

    public $copyFromProject = null;

    public $importChecklistTemplateIds = [];

    public function getChecklistTemplateOptionsProperty()
    {
        if($this->how === 'import') {
            return ['1', 'two'];
        }

        return [];
    }

    public function getProjectOptionsProperty()
    {

    }

    public function handleAdd()
    {
        switch ($this->how) {
            case 'new':
                $this->validate(['name' => 'required']);

                $cl = new \App\Models\Checklist();
                $cl->project_id = $this->projectId;
                $cl->name = $this->name;
                $cl->save();

                if(!empty($this->tasks)) {
                    foreach(preg_split('/\r\n|\r|\n/', $this->tasks) as $index => $taskName) {
                        $this->addTask($cl, $taskName, $index + 1);
                    }
                }
                break;

        }
    }

    protected function addTask(\App\Models\Checklist $checklist, $taskName, $sort)
    {
        $t = new \App\Models\Task();
        $t->project_id = $this->projectId;
        $t->checklist_id = $checklist->id;
        $t->name = $taskName;
        $t->sort = $sort;
        $t->save();
    }
} ?>

<form wire:submit="handleAdd" class="card">
    <div class="card-title">
        Checklist Form
    </div>
    <div class="card-body">
        <x-form.radio-container label="How you doing this?">
            <x-form.radio name="how" value="template" wire:model.live="how" label="Import from a Template" />
            <x-form.radio name="how" value="new" wire:model.live="how" label="Brand New Checklist" />
            <x-form.radio name="how" value="copy" wire:model.live="how" label="Copy from another Project" />
        </x-form.radio-container>


        @switch($how)
            @case('template')
                <div>
                    template
                </div>
                @break
            @case('new')
                <div class="mt-4 grid gap-4">
                    <x-form.input label="Checklist Name" wire:model="name" name="clname" />
                    <x-form.textarea name="tasktea" label="Tasks" rows="8" wire:model="tasks" help="One task per line" />
                </div>
                @break
            @case('copy')
                <div>
                    copy
                </div>
                @break
        @endswitch
    </div>


    <div class="card-footer">
        <button type="submit" class="btn btn-primary">
            Add
        </button>
        <button @click="$dispatch('cancel')" type="button" class="btn btn-white">
            Nevermind
        </button>
    </div>
</form>
