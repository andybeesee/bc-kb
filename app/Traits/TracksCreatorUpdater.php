<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait TracksCreatorUpdater
{
    public static function bootTracksCreatorUpdater()
    {
        static::creating(function(Model $model) {
            if(!$model->isDirty('created_by')) {
                $model->created_by = auth()->user()->id;
            }
        });

        static::saving(function(Model $model) {
            if(!$model->isDirty('updated_by')) {
                $model->updated_by = auth()->user()->id;
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
