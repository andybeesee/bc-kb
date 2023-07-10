<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FileDownloadController extends Controller
{
    public function __invoke(File $file)
    {
        return 'TODO: FILE DOWNLOAD';
        // TODO: Implement __invoke() method.
    }
}
