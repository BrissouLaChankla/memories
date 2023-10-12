<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;



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
        return view('albums.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
        
        $slug = $this->generateUniqueSlug($request->title);
        $request->merge(['slug' => $slug, 'user_id' =>  Auth::id()]);
        $album = Album::create($request->all());

        $album->save();

        session()->flash('success', 'Le chapitre a bien été crée !');
        return redirect()->route('albums.show', ['album' => $album->slug]);
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
        // Trouve l'album
        $album = Album::with('photos')->find($album->id);

        // Trouve l'emplacement sur le disque
        $albumFolder = storage_path('app/public/images/'.$album->slug);

    
        // Le fume
        if (File::exists($albumFolder)) {
            File::deleteDirectory($albumFolder);
        }

        // Retire en BDD les photos de l'album
        foreach ($album->photos as $photo) {
            Photo::destroy($photo->id);
        }

        // Retire en BDD l'album
        Album::destroy($album->id);


        return json_encode("gg");
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

    public function downloadAlbumZip(Album $album) {


        // Parcours du répertoire pour trouver tous les fichiers ZIP
        $zip_files = glob(public_path().'/*.zip');

        // Suppression de tous les fichiers ZIP trouvés
        foreach ($zip_files as $zip_file) {
            if (is_file($zip_file)) {
                unlink($zip_file);
            }
        }



        $zip_file = $album->title.'.zip';
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);


        $path = storage_path('app/public/images/'.$album->slug);


        $files = new \DirectoryIterator($path);
        foreach ($files as $name => $file)
        {
            // We're skipping all subfolders
            if (!$file->isDir()) {
                $filePath     = $file->getRealPath();

                // extracting filename with substr/strlen
                $relativePath = $album->title.'/' . substr($filePath, strlen($path) + 1);

                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
        return response()->download($zip_file);
        
    }

}
