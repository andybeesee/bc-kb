<?php

namespace App\Models;

use App\Events\FilesAttachedToSomething;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\TemporaryUploadedFile;

class File extends Model
{
    use HasFactory;

    protected $casts = [
        'old_versions' => 'array',
    ];

    public static function attachFiles($tempFiles, $toType, $toId)
    {
        $fileIds = [];

        /** @var TemporaryUploadedFile $tempFile */
        foreach($tempFiles as $tempFile) {
            $path = Str::plural($toType).'/'.$toId.'/'.$tempFile->getFilename();
            $tempFile->store($path);
            $file = new File();
            $file->filename = $tempFile->getClientOriginalName();
            $file->location = $path;
            $file->attached_type = $toType;
            $file->attached_id = $toId;
            $file->old_versions = [];
            $file->save();

            $fileIds[] = $file->id;
        }

        FilesAttachedToSomething::dispatch($fileIds, $toType, $toId);

        return $fileIds;
    }

    public function replace(TemporaryUploadedFile $tempFile)
    {
        $oldLocation = $this->location;

        $path = Str::plural($this->attached_type).'/'.$this->attached_id.'/'.$tempFile->getFilename();

        $tempFile->store($path);

        $currentExtension = pathinfo($this->filename, PATHINFO_EXTENSION);
        $newExtension = pathinfo($tempFile->getFilename(), PATHINFO_EXTENSION);

        if($currentExtension !== $newExtension) {
            $this->filename = pathinfo($this->filename, PATHINFO_FILENAME).'.'.$newExtension;
        }

        // TODO: Maybe we want more information?
        $ovs = $this->old_versions;
        $ovs[] = [

            'location' => $oldLocation,
            'replaced' => date('Y-m-d'),
            'replaced_by' => auth()->user()->name,
        ];

        $this->old_versions = $ovs;

        $this->location = $path;
        $this->save();
    }
}
