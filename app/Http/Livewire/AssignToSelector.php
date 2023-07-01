<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class AssignToSelector extends Component
{
    public int $modelId;

    public int|null $teamId;

    public User|null $assignedTo;

    public bool $open = false;

    public function render()
    {
        $assignedToCurrentUser = $this->assignedTo?->id === auth()->user()->id;
        return view('livewire.assign-to-selector')
            ->with('assignedToCurrentUser', $assignedToCurrentUser);
    }

    public function getUserOptionsProperty()
    {
        if(!$this->open) {
            return [];
        }

        $q = User::orderBy('name');

        if(!empty($this->teamId)) {
            $q = $q->whereHas('team', fn($tq) => $tq->where('teams.id', $this->teamId));

            if(!empty($this->assignedTo)) {
                $q = $q->orWhere('users.id', '=', $this->assignedTo->id);
            }
        }

        return $q->get();
    }
}
