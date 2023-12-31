<?php

namespace App\Livewire;

use App\Models\File;
use App\Models\Task;
use App\Models\Checklist;
use App\Traits\LivewireTaskFunctions;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ProjectTaskList extends Component
{
    use WithFileUploads, LivewireTaskFunctions;

    public int $projectId;

    public $files;

    public null|int $showDetailTask = null;

    public $addingGroup = false;

    public $openedChecklist = null;

    public $addingTask = false;

    public $addingTaskToChecklist = null;

    public null|string $startingTab = null;

    public function render()
    {
        return view('livewire.project-task-list');
    }

    public function getDefaultChecklistProperty()
    {
        $q = Task::where('project_id', $this->projectId)->whereNull('checklist_id');

        return (object) [
            'incomplete_tasks_count' => (clone $q)->isIncomplete()->count(),
            'complete_tasks_count' => (clone $q)->isComplete()->count(),
            'late_tasks_count' => (clone $q)->isLate()->count(),
            'incomplete_assigned_to_user_tasks_count' => (clone $q)->isAssignedTo(auth()->user()->id)->count()
        ];
    }

    public function getChecklistsProperty()
    {
        return Checklist::withCount([
            // 'tasks',
            'incompleteTasks',
            'completeTasks',
            'lateTasks',
            'incompleteAssignedToUserTasks'
        ])
            ->where('project_id', $this->projectId)
            ->orderBy('sort')
            ->get();
    }

    public function openDetail($taskId, $tab = null)
    {
        $this->showDetailTask = $taskId;
        $this->startingTab = $tab;
    }

    public function closeDetail()
    {
        $this->showDetailTask = null;
    }

    public function getOpenChecklistDetailProperty()
    {
        if(empty($this->openedChecklist)) {
            return false;
        }

        return Checklist::with('tasks')->findOrFail($this->openedChecklist);
    }

    public function getTasksToShowProperty()
    {
        $q = Task::where('project_id', $this->projectId)
            ->orderBy('sort')
            ->with(['assignedTo', 'completedBy']);

        if(empty($this->openedChecklist)) {
            $q = $q->whereNull('checklist_id');
        } else {
            $q = $q->where('checklist_id', $this->openedChecklist);
        }

        return $q->get();
    }

    #[On('movedList')]
    public function handleTaskMove($taskId, $checklistId, $items)
    {
        DB::table('tasks')
            ->where('id', $taskId)
            ->update([
                'checklist_id' => empty($checklistId) ? null : $checklistId,
            ]);

        $this->handleSort($items, $checklistId);
    }

    #[On('task-added')]
    public function handleTaskAdd()
    {

    }

    public function openAddTask($checklistId = null)
    {
        $this->addingTask = true;
        $this->addingTaskToChecklist = $checklistId;
    }

    #[On('sorted')]
    public function handleSort($items, $checklistId = null)
    {
        $taskQuery = DB::table('tasks')->where('project_id', $this->projectId);

        if(!empty($checklistId)) {
            $taskQuery = $taskQuery->whereNull('checklist_id');
        } else {
            $taskQuery = $taskQuery->where('checklist_id', $checklistId);
        }

        $tasks = $taskQuery->get()->pluck('id', 'sort')->toArray();

        foreach($items as $data) {
            $taskId = $data['id'];
            $newSort = $data['sort'];

            $curSort = $tasks[$taskId] ?? 0;
            if($curSort === $newSort) {
                continue;
            }

            DB::table('tasks')
                ->where('project_id', $this->projectId)
                ->where('id', $taskId)
                ->update([
                    'sort' => $newSort,
                ]);
        }
    }

    #[On('checklistSorted')]
    public function handleChecklistSorted($checklistIds)
    {
        $checklists = DB::table('checklists')
            ->where('project_id', $this->projectId)
            ->get()
            ->pluck('id', 'sort')
            ->toArray();

        foreach($checklistIds as $data) {
            $checklistId = $data['id'];
            $newSort = $data['sort'];

            $curSort = $checklists[$checklistId] ?? 0;
            if($curSort === $newSort) {
                continue;
            }

            DB::table('checklists')
                ->where('project_id', $this->projectId)
                ->where('id', $checklistId)
                ->update([
                    'sort' => $newSort,
                ]);
        }
    }

    #[On('attachTaskFiles')]
    public function attachFiles($taskId)
    {
        \Log::debug("Uploading", $this->files);

        File::attachFiles($this->files, 'task', $taskId);

        $this->files = [];
    }

    public function deleteGroup($id)
    {
        // TODO: Shoudl this delete all nested items? it should probably be an option when clicked
        DB::table('tasks')
            ->where('id', $id)
            ->delete();
    }
}
