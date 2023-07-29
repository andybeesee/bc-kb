<?php

namespace App\Livewire;

use App\Models\Project;
use Illuminate\Support\Str;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class ProjectStatusButton extends Component
{
    #[Reactive]
    public Project $project;

    public bool $changing = false;

    public bool $canChange = false;

    public $iconOnly = false;

    public string $iconClass = '';

    public array $optionClasses = [
        'idea' => 'bg-zinc-100 dark:bg-zinc-800 dark:text-zinc-50 dark:hover:bg-zinc-600 hover:bg-zinc-300 border-zinc-400 text-zinc-900',
        'in_progress' => 'bg-blue-600 dark:bg-blue-800 dark:text-blue-50 dark:hover:bg-blue-600 hover:bg-blue-800 border-blue-700 text-white',
        'complete' => 'bg-emerald-200 dark:bg-emerald-800 dark:text-emerald-50 dark:hover:bg-emerald-600 hover:bg-emerald-400 border-emerald-400 text-emerald-900',
        'incomplete' => 'bg-orange-200 dark:bg-orange-800 dark:text-orange-50 dark:hover:bg-orange-600 hover:bg-orange-400 border-orange-400 text-orange-900',
        'late' => 'bg-red-200 dark:bg-red-800 dark:text-red-50 dark:hover:bg-red-600 hover:bg-red-300 border-red-400 text-red-900',
        'abandoned' => 'bg-zinc-100 dark:bg-zinc-800 dark:text-zinc-50 dark:hover:bg-zinc-600 hover:bg-zinc-300 border-zinc-300 text-zinc-500',
    ];

    public function mount() {
        \Log::debug("re moointed status button");
        $this->canChange = !$this->project->isComplete;
    }

    public function render()
    {
        \Log::debug("re-rendered status button");
        $status = config('statuses')[$this->project->status] ?? 'Unknown';
        $colors = 'bg-zinc-200 border-zinc-400 text-zinc-900';
        $hoverColors = 'hover:bg-zinc-400';

        switch ($this->project->status) {
            case 'idea':
                $colors = 'bg-zinc-200 dark:bg-zinc-700 dark:text-zinc-200 border-zinc-400 text-zinc-900';
                $hoverColors = 'hover:bg-zinc-400';
                $icon = 'lightbulb';
                break;
            case 'in_progress':
                $colors = 'bg-blue-600 border-blue-700 text-white';
                $hoverColors = 'hover:bg-blue-700';
                $icon = 'circle';
                break;
            case 'complete':
                $colors = 'bg-emerald-200 border-emerald-400 text-emerald-900 dark:bg-emerald-300';
                $hoverColors = 'hover:bg-emerald-400';
                $icon = 'check-circle-fill';
                break;
            case 'late':
                $colors = 'bg-red-200 border-red-400 text-red-900 dark:bg-red-800 dark:text-white';
                $hoverColors = 'hover:bg-red-400';
                $icon = 'clock';
                break;
            case 'abandoned':
                $colors = 'bg-zinc-100 dark:bg-zinc-600 dark:text-zinc-300 border-zinc-300 text-zinc-500';
                $hoverColors = 'hover:bg-zinc-400';
                $icon = 'trash3';
                break;
        }

        return view('livewire.project-status-button')
            ->with('colors', $colors)
            ->with('hoverColors', $hoverColors)
            ->with('icon', $icon)
            ->with('status', $status);
    }

    public function setStatus($newStatus)
    {
        $this->dispatch('update-project-status', $this->project->id, $newStatus);
        $this->changing = false;
    }
}
