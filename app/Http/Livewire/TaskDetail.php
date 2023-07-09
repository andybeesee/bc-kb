<?php

namespace App\Http\Livewire;

use App\Models\Task;
use App\Traits\LivewireTaskFunctions;
use Livewire\Component;
use Livewire\WithFileUploads;

class TaskDetail extends Component
{
    use WithFileUploads, LivewireTaskFunctions;

    public int $taskId;

    public $modalMode = false;

    public $startingTab = null;

    public $tab = 'detail';

    protected $listeners = [
        'updateDueDate' => 'handleSetTaskDue',
        'removeDueDate' => 'handleRemoveTaskDue',
        'assigned' => 'handleAssignment',
        'removeAssigned' => 'removeAssignment',
        'changeCompleted' => 'updateCompletedBy',
        'completeDateChange' => 'updateCompletedDate',
    ];


    public function mount()
    {
        if(!empty($this->startingTab)) {
            $this->tab = $this->startingTab;
        }
    }

    public function render()
    {
        \Log::debug("RE-rendering?");

        $task = Task::with([
                'completedBy',
                'assignedTo',
                'project',
            ])
            ->withCount([
                'files',
            ])
            ->findOrFail($this->taskId);

        return view('livewire.task-detail')
            ->with('task', $task);
    }

    public function setTab($tab)
    {
        $this->tab = $tab;
    }
}
