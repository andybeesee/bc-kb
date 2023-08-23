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

    public $addingTask = false;

    public $addingTaskToChecklist = null;

    public null|string $startingTab = null;

    public function render()
    {
        $checklists = Checklist::with(['tasks' => fn($tq) => $tq->with(['completedBy', 'assignedTo'])->withCount('files')])
            ->where('project_id', $this->projectId)
            ->orderBy('sort')
            ->get();

        $tasks = Task::with(['completedBy', 'assignedTo'])
            ->withCount(['files', 'comments'])
            ->where('project_id', $this->projectId)
            ->whereNull('checklist_id')
            ->orderBy('sort')
            ->get();

        return view('livewire.project-task-list')
            ->with('tasks', $tasks)
            ->with('checklists', $checklists);
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

    public function openAddTask($checklistId)
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
