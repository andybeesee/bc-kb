<?php

namespace App\Traits;

use App\Models\CurrentStatus;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;

trait HasStatuses
{

    public function currentStatus()
    {
        return $this->morphOne(CurrentStatus::class, 'attached')->orderBy('created_at', 'DESC');
    }

    public function statuses()
    {
        return $this->morphMany(CurrentStatus::class, 'attached')->orderBy('created_at', 'DESC');
    }

    public function setStatus($description, $by = null)
    {
        $by = empty($by) ? auth()->user()->id : $by;

        $cs = new CurrentStatus();
        $cs->status = $description;
        $cs->attached_id = $this->id;
        $cs->attached_type = array_search(static::class, Relation::$morphMap);
        $cs->created_by = $by;
        $cs->updated_by = $by;
        $cs->save();
    }
}
