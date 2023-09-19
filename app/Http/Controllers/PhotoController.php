<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $album_id = $request->input('album_id');
        $slug = Album::find($album_id)->slug;

        return view('photos.create')->with([
            "album_id" => $album_id,
            "album_slug" => $slug
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $image = $request->file('file');
        $imageName = time() . rand(1, 99) . '.webp';

        $albumSlug = Album::find($request->album_id)->slug;

        // Stockez l'image dans le dossier de stockage (storage/app)
        $destinationPath = $image->storeAs('images/' . $albumSlug, $imageName, 'local');
  

        // Obtenez le chemin complet de l'image dans le stockage
        $storagePath = storage_path('app/public/' . $destinationPath);
        chmod(storage_path('app/public/images/'.$albumSlug), 0755);


        // Ouvrez l'image avec Intervention Image
        $img = Image::make($image)->orientate();


        // PARTIE BDD
        $metadata = $img->exif();
        $newPhoto = new Photo();
        $newPhoto->url = $imageName;
        $newPhoto->album_id = $request->album_id;
        $newPhoto->user_id = Auth::id();

        $newPhoto->metadata = json_encode($metadata); 
        $newPhoto->save();

        // Obtenez les dimensions de l'image
        $width = $img->width();
        $height = $img->height();

        // Redimensionnez l'image uniquement si ses dimensions dépassent certaines valeurs
        if ($width > 2000 || $height > 1200) {
            $img->resize(2000, 1200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        // Convertissez l'image en format WebP
        $img->encode('webp', 98); 
        // Enregistrez l'image convertie
        $img->save($storagePath);

        // Créez un sous-dossier "thumb"
        $destinationThumbPath = $image->storeAs('images/' . $albumSlug.'/thumb/', $imageName, 'local');
        $storageThumbPath = storage_path('app/public/' . $destinationThumbPath);
        chmod(storage_path('app/public/images/'.$albumSlug.'/thumb'), 0755);

        // Créez une copie de l'image redimensionnée en tant que "thumbnail" dans le sous-dossier "thumb"

        // Copiez l'image redimensionnée dans le sous-dossier "thumb"
        $thumbImg = Image::make($storagePath)->orientate();
        $thumbImg->resize(333, 200, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        // $thumbImg->fit(500, 250);
        $thumbImg->encode('webp', 90);
        $thumbImg->save($storageThumbPath);

        return response()->json(['success' => $imageName]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $photo = Photo::where('url', $request->input('photo_name'))->first();
        $album = Album::find($photo->album_id);

        // Localise où sont stockées miniature + photo
        $photoFile = storage_path('app/public/images/'.$album->slug .'/'. $request->input('photo_name'));
        $photoFileThumb = storage_path('app/public/images/'.$album->slug.'/thumb/'. $request->input('photo_name'));

        // remove la photo & sa miniature
        if(File::exists($photoFile)){
            File::delete([$photoFile, $photoFileThumb]);
        }

        // Remove l'entrée en bdd
        Photo::destroy($photo->id);

        return json_encode("gg");
    }


    // Custom

}
