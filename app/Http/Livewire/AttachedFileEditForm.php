<?php

namespace App\Http\Livewire;

use App\Models\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class AttachedFileEditForm extends Component
{
    use WithFileUploads;

    public File $file;

    public $filename;

    public $newFile = null;

    public $extension = null;

    public function mount()
    {
        $this->filename = pathinfo($this->file->filename, PATHINFO_FILENAME);
        $this->extension = pathinfo($this->file->filename, PATHINFO_EXTENSION);
    }

    public function render()
    {
        return view('livewire.attached-file-edit-form');
    }

    public function save()
    {
        $this->file->filename = $this->filename.'.'.$this->extension;
        $this->file->save();

        if(!is_null($this->newFile)) {
            $this->file->replace($this->newFile);
        }

        $this->emitUp('fileSaved', $this->file->id);
    }

    public function cancel()
    {
        $this->emitUp('fileCancelled', $this->file->id);
    }
}
