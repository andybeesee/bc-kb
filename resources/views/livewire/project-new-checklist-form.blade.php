<?php

use Livewire\Volt\Component;

new class extends Component {
    public $projectId;

    public $how = 'template';

    public $name = '';

    public $tasks = '';

    public $copyFromProject = null;

    public $selectedTemplates = [];

    public $templateSearch = '';

    public function getChecklistTemplateOptionsProperty()
    {
        if($this->how === 'template') {
            $q = \App\Models\ChecklistTemplate::with('projectTemplates')->with('projectTemplates')->orderBy('name');

            if(!empty($this->templateSearch)) {
                $q = $q->where(function($sq) {
                    $term = '%'.$this->templateSearch.'%';
                    return $sq->where('name', 'LIKE', $term)
                        ->orWhereHas('projectTemplates', fn($pq) => $pq->where('name', 'LIKE', $term));
                });
            }

            if(count($this->selectedTemplates) > 0) {
                $q = $q->whereNotIn('id', $this->selectedTemplates);
            }
            return $q->limit(100)->get();
        }

        return [];
    }

    public function getSelectedTemplateModelsProperty()
    {
        if(count($this->selectedTemplates) === 0) {
            return [];
        }

        return \App\Models\ChecklistTemplate::whereIn('id', $this->selectedTemplates)->get();
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
            case 'template':
                $this->validate(['selectedTemplates' => 'min:1']);

                $project = \App\Models\Project::findOr($this->projectId);

                \App\Models\ChecklistTemplate::whereIn('id', $this->selectedTemplates)
                    ->get()
                    ->each(function(\App\Models\ChecklistTemplate $checklistTemplate) use($project) {
                        $project->importChecklistTemplate($checklistTemplate);
                    });
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
                <div x-data="{
                    init() {
                        this.$nextTick(() => this.$refs.search.focus());
                    },
                    selectedTemplates: @entangle('selectedTemplates').live,
                    toggle(id) {
                        const idx = this.selectedTemplates.indexOf(id);
                        if(idx > -1) {
                            this.selectedTemplates = this.selectedTemplates.filter(t => t !== id);
                        } else {
                            this.selectedTemplates.push(id);
                        }
                    }
                }" class="mt-4">
                    <div class="form-group">
                        <div class="form-label">Select Template(s)</div>
                        <div class="form-control-container">
                            <div class="grid grid-cols-2 items-start gap-5">
                                <div class="grid items-start">
                                    <div class="text-xs">Select Checklists</div>
                                    <div class="flex flex-col items-start divide-y divide-zinc-200 border border-zinc-300 max-h-[200px] min-h-[200px] overflow-y-scroll">
                                        <input x-ref="search" autofocus placeholder="Search" type="text" wire:model.live.debounce="templateSearch" class="w-full sticky top-0" />
                                        @foreach($this->checklistTemplateOptions as $tempOption)
                                            <div @click="toggle({{ $tempOption->id }})" class="w-full p-0.5 cursor-pointer hover:bg-zinc-100">
                                                <div class="font-semibold">{{ $tempOption->name }}</div>
                                                <div class="text-xs">{{ count($tempOption->tasks) }} Tasks</div>
                                                @if($tempOption->projectTemplates->count() > 0)
                                                    <div class="text-xs">
                                                        @if($tempOption->projectTemplates->count() > 3)
                                                            <span title=" {{ $tempOption->projectTemplates->pluck('name')->implode("\r\n") }}">
                                                                Used in {{ $tempOption->projectTemplates->count() }} project templates
                                                            </span>
                                                        @else
                                                            Used in these {{ $tempOption->projectTemplates->count() }} templates: {{ $tempOption->projectTemplates->pluck('name')->implode(',') }}
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs">Selected Checklists</div>
                                    <div class="flex divide-y divide-zinc-200 flex-col border items-start border-zinc-300 max-h-[200px] min-h-[200px] overflow-y-scroll">
                                        @foreach($this->selectedTemplateModels as $tempOption)
                                            <div @click="toggle({{ $tempOption->id }})" class="w-full p-0.5 cursor-pointer hover:bg-zinc-100">
                                                <div class="font-semibold">{{ $tempOption->name }}</div>
                                                <div class="text-xs">{{ count($tempOption->tasks) }} Tasks</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
