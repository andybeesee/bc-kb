<?php

namespace App\Http\Livewire;

use App\Models\Project;
use Livewire\Component;

class ProjectDetailPage extends Component
{
    public int $projectId;

    protected $listeners = [
        'setProjectDueDate' => 'setDueDate',
        'removeProjectDueDate' => 'removeDueDate',
    ];

    public function render()
    {
        $project = Project::findOrFail($this->projectId);

        return view('livewire.project-detail-page')->with('project', $project);
    }

    public function setDueDate($date)
    {
        \DB::table('projects')
            ->where('id', $this->projectId)
            ->update([
                'due_date' => $date,
                'updated_at' => now(),
            ]);
    }

    public function removeDueDate()
    {
        \DB::table('projects')
            ->where('id', $this->projectId)
            ->update([
                'due_date' => null,
                'updated_at' => now(),
            ]);
    }
}
