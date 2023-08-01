<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

trait LivewireProjectFunctions
{
    #[On('update-project-status')]
    public function updateProjectStatus($projectId, $newStatus)
    {
        DB::table('projects')
            ->where('id', $projectId)
            ->update([
                'status' => $newStatus,
                'updated_at' => now(),
            ]);

        // TODO: Track Activity

        $this->dispatch('projectUpdated', $projectId);
    }

    #[On('update-project-due-date')]
    public function setProjectDueDate($projectId, $date)
    {
        DB::table('projects')
            ->where('id', $projectId)
            ->update([
                'due_date' => $date,
                'updated_at' => now(),
            ]);

        $this->dispatch('projectUpdated', $projectId);
    }

    #[On('remove-project-due-date')]
    public function removeProjectDueDate($projectId)
    {
        DB::table('projects')
            ->where('id', $projectId)
            ->update([
                'due_date' => null,
                'updated_at' => now(),
            ]);

        $this->dispatch('projectUpdated', $projectId);
    }

}
