<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;



class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return "cc";
        return view('albums.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $slug = $this->generateUniqueSlug($request->title);
        $request->merge(['slug' => $slug, 'user_id' =>  Auth::id()]);
        $album = Album::create($request->all());

        $album->save();

        session()->flash('success', 'Le chapitre a bien été crée !');
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $album = Album::where('slug', $slug)->with("photos")->first();
        return view("albums.show", compact("album"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Album $album)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)
    {
        //
    }


    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title); // Generate a basic slug

        $originalSlug = $slug;
        $counter = 2;

        while (Album::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

}
