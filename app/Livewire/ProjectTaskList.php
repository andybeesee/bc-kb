<?php

namespace App\Livewire;

use App\Models\File;
use App\Models\Task;
use App\Models\TaskGroup;
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

    public null|string $startingTab = null;

    public function render()
    {
        $groups = TaskGroup::with(['tasks' => fn($tq) => $tq->with(['completedBy', 'assignedTo'])->withCount('files')])
            ->where('project_id', $this->projectId)
            ->orderBy('sort')
            ->get();

        $tasks = Task::with(['completedBy', 'assignedTo'])
            ->withCount(['files', 'comments'])
            ->where('project_id', $this->projectId)
            ->whereNull('task_group_id')
            ->orderBy('sort')
            ->get();

        return view('livewire.project-task-list')
            ->with('tasks', $tasks)
            ->with('groups', $groups);
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
    public function handleTaskMove($taskId, $groupId, $items)
    {
        DB::table('tasks')
            ->where('id', $taskId)
            ->update([
                'task_group_id' => empty($groupId) ? null : $groupId,
            ]);

        $this->handleSort($items, $groupId);
    }

    #[On('sorted')]
    public function handleSort($items, $groupId = null)
    {
        $taskQuery = DB::table('tasks')->where('project_id', $this->projectId);

        if(!empty($groupId)) {
            $taskQuery = $taskQuery->whereNull('task_group_id');
        } else {
            $taskQuery = $taskQuery->where('task_group_id', $groupId);
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

    #[On('groupSorted')]
    public function handleGroupSorted($groupIds)
    {
        $groups = DB::table('task_groups')
            ->where('project_id', $this->projectId)
            ->get()
            ->pluck('id', 'sort')
            ->toArray();

        foreach($groupIds as $data) {
            $groupId = $data['id'];
            $newSort = $data['sort'];

            $curSort = $groups[$groupId] ?? 0;
            if($curSort === $newSort) {
                continue;
            }

            DB::table('task_groups')
                ->where('project_id', $this->projectId)
                ->where('id', $groupId)
                ->update([
                    'sort' => $newSort,
                ]);
        }
    }

    public function deleteGroup($id)
    {
        // TODO: Shoudl this delete all nested items? it should probably be an option when clicked
        DB::table('tasks')
            ->where('id', $id)
            ->delete();
    }
}
