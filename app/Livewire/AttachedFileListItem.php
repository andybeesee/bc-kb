<?php

namespace App\Livewire;

use App\Models\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class AttachedFileListItem extends Component
{
    use WithFileUploads;

    public File $file;

    public bool $showRelated = false;

    public $editing = false;

    public $filename;

    public $extension;

    public $newFile;

    public function render()
    {
        return view('livewire.attached-file-list-item');
    }

    public function startEditing()
    {
        $this->newFile = null;
        $this->filename = pathinfo($this->file->filename, PATHINFO_FILENAME);
        $this->extension = pathinfo($this->file->filename, PATHINFO_EXTENSION);
        $this->editing = true;
    }

    public function cancelEditing()
    {
        $this->editing = false;
        $this->newFile = null;
        $this->filename = '';
    }

    public function save()
    {
        $this->file->filename = $this->filename.'.'.$this->extension;
        $this->file->save();

        if(!is_null($this->newFile)) {
            $this->file->replace($this->newFile);
        }

        $this->editing = false;
        $this->dispatch('fileSaved', $this->file->id);
    }
}
