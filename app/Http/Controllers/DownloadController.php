<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    //
    public function download($file){
        // $file;
        $content=Storage::disk('public')->path($file);
        return response()->download($content);
    }
}
