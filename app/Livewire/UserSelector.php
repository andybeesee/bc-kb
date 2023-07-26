<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UserSelector extends Component
{
    public int $modelId;

    public string $changeEvent = 'userSelected';

    public string $removeEvent = 'userRemoved';

    public bool $disableRemove = false;

    public int|null $teamId;

    public User|null $user = null;

    public bool $open = false;

    public function render()
    {
        $assignedToCurrentUser = $this->user?->id === auth()->user()->id;

        return view('livewire.user-selector')
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

            if(!empty($this->user)) {
                $q = $q->orWhere('users.id', '=', $this->assignedTo->id);
            }
        }

        return $q->get();
    }
}
