<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Room_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{

    public function index()
    {
        return response()->json(Photo::all())->setStatusCode(200, 'OK');
    }


    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['title', 'room_category']);
        $file = $request->photo;
        if ($file)
        $data['path'] = $file->store('/', 'public');
        $data['title'] = "Untitled";
        $data['owner_id'] = Auth::user()->id;

        return Photo::create($data);

//        return response()->json([
//            'id' => $photo->id,
//            'title' => $photo->title,
//            'room_category' => Room_category::find($request->room_category)->name,
//            'url' => $photo->path,
//        ])->setStatusCode(201, 'Created');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy(Photo $photo)
    {
        return $photo-> delete();
    }
}
