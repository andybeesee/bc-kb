<?php

namespace App\Http\Livewire;

use App\Models\Project;
use Livewire\Component;

class ProjectDetailPage extends Component
{
    public Project $project;

    protected $listeners = [
        'setProjectDueDate' => 'setDueDate',
        'removeProjectDueDate' => 'removeDueDate',
    ];

    public string $tab = 'dashboard';

    protected $queryString = [
        'tab',
    ];

    public function render()
    {
        // $project = Project::findOrFail($this->project->id);

        return view('livewire.project-detail-page');
    }

    public function setDueDate($date)
    {
        \DB::table('projects')
            ->where('id', $this->project->id)
            ->update([
                'due_date' => $date,
                'updated_at' => now(),
            ]);
    }

    public function removeDueDate()
    {
        \DB::table('projects')
            ->where('id', $this->project->id)
            ->update([
                'due_date' => null,
                'updated_at' => now(),
            ]);
    }
}
