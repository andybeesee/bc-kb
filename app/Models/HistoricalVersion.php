<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class HistoricalVersion extends Model
{
    use HasFactory;

    public static function generate(Model $model, $changeSummary, $by = null)
    {
        $by = $by ?? auth()->user()->id;

        // TODO: we'll eventually need to the WHOLE record for an article, that is track all individual pieces of content too...

        $hv = new HistoricalVersion();
        $hv->attached_type = array_search(get_class($model), Relation::$morphMap);
        $hv->attached_id = $model->id;
        $hv->change_summary = $changeSummary;
        $hv->data = $model->toJson();
        $hv->created_by = $by;
        $hv->updated_by = $by;
        $hv->save();
    }
}
