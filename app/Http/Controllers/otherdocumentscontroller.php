<?php

namespace App\Http\Controllers;
use Webpatser\Uuid\Uuid;

class OtherdocumentsController extends Controller
{
    public function index()
    {
        $otherdocuments = Otherdocuments::all();
        return view('otherdocuments.index', compact('otherdocuments'));
    }

    public function create()
    {
        return view('Otherdocuments.create');
    }

    

public function store(Request $request)
{
    $otherdocuments = $request->all();
    $otherdocuments['uuid'] = (string)Uuid::generate();
    if ($request->hasFile('cover')) {
        $otherdocuments['cover'] = $request->cover->getClientOriginalName();
        $request->cover->storeAs('otherdocuments', $book['cover']);
    }
    Book::create($otherdocuments);
    return redirect()->route('otherdocuments.index');
}

public function download($uuid)
{
    $otherdocuments = Otherdocuments::where('uuid', $uuid)->firstOrFail();
    $pathToFile = storage_path('app/otherdocuments/' . $otherdocuments->cover);
    return response()->download($pathToFile);
}
}