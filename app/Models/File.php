<?php

namespace App\Models;

use App\Events\FilesAttachedToSomething;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\TemporaryUploadedFile;

class File extends Model
{
    use HasFactory;

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
            $file->save();

            $fileIds[] = $file->id;
        }

        FilesAttachedToSomething::dispatch($fileIds, $toType, $toId);

        return $fileIds;
    }
}
