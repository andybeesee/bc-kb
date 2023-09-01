<?php

use Livewire\Volt\Component;

new class extends Component {
    public $projectId = null;

    public $checklistId = null;

    public $taskName = null;

    public $dueDate = null;

    public $showProjectSelect = false;

    public $showChecklistSelect = false;

    public $added = false;

    public function saveTask()
    {
        $this->validate(['taskName' => 'required', 'dueDate' => 'nullable|date']);

        $task = new \App\Models\Task();
        $task->name = $this->taskName;
        $task->due_date = $this->dueDate;
        $task->project_id = $this->projectId;
        $task->checklist_id = $this->checklistId;
        $task->sort = \App\Models\Checklist::getNextTaskSort($this->projectId, $this->checklistId);
        $task->save();

        $this->taskName = null;
        $this->added = true;

        $this->dispatch('task-added', $task->id);
    }

    public function getChecklistOptionsProperty()
    {
        return \App\Models\Checklist::where('project_id', $this->projectId)->orderBy('name')->get();
    }
}
?>

<form class="card" wire:submit="saveTask">
    <div class="card-title card-header">
        New Task
    </div>
    <div x-data="{ init() { this.$nextTick(() => this.$refs.nameinput.focus()) } }" class="card-body grid gap-4">
        @if($added)
            <div class="bg-green-100 flex justify-center dark:bg-green-900 rounded p-4">
                <span class="font-bold">Added Task!</span>
                <button type="button" wire:click="$set('added', false)" class="ml-2">
                    <x-icon icon="x-circle" class="h-4 w-4" />
                </button>
            </div>
        @endif
        <x-form.input x-ref="nameinput" type="text" name="name" wire:model="taskName" label="Task Name" />

        <x-form.date-picker name="due" wire:model="dueDate" label="Due Date" />

        @if($showProjectSelect)
            <x-form.select name="project" wire:model="projectId" label="Project" />
        @endif

        @if($showChecklistSelect && !empty($projectId))
            <x-form.select name="checklist" wire:model="checklistId" label="Checklist" :options="$this->checklistOptions->pluck('name', 'id')" />
        @endif
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">
            Add Task
        </button>
        <button @click="$dispatch('cancel')" type="button" class="btn btn-white">
            {{ $added ? 'Done Adding' : 'Nevermind' }}
        </button>
    </div>
</form>
