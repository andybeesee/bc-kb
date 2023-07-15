<?php

namespace App\Http\Livewire;

use App\Models\File;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class AttachedFileList extends Component
{
    use WithFileUploads;

    public string $attachedType;

    public int $attachedId;

    public $files;

    public array $editing = [];

    public $listeners = [
        'fileListAttached' => 'uploadFiles',
        'fileSaved' => 'render',
        'fileCancelled' => 'render',
    ];

    public function render()
    {
        $attachedFiles = File::orderBy('filename')
            ->where('attached_type', $this->attachedType)
            ->where('attached_id', $this->attachedId)
            ->get();

        $relatedFiles = null;
        if($this->attachedType === 'project') {
            $relatedFiles = File::with('attached')->orderBy('filename')
                ->where('attached_type', 'task')
                ->whereIn('attached_id', function($iq) {
                    return $iq->select('tasks.id')
                        ->from('tasks')
                        ->where('tasks.project_id', $this->attachedId);
                })->get();
        }

        return view('livewire.attached-file-list')
            ->with('attachedFiles', $attachedFiles)
            ->with('relatedFiles', $relatedFiles);
    }

    public function uploadFiles()
    {
        \Log::debug("Uploading", $this->files);

        File::attachFiles($this->files, $this->attachedType, $this->attachedId);

        $this->files = [];
    }

    public function startEditing($id)
    {
        $this->editing = [$id, ...$this->editing];;
    }

    public function stopEditing($id)
    {
        $editing = [];
        foreach($this->editing as $editingId) {
            if($id === $editingId) {
                continue;
            }

            $editing[] = $id;
        }

        $this->editing = $editing;;
    }

    public function deleteFile($id)
    {
        $file = File::findOrFail($id);
        $file->delete();
    }
}