<?php

namespace App\Models;

use App\Traits\TracksCreatorUpdater;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory, TracksCreatorUpdater;
}
