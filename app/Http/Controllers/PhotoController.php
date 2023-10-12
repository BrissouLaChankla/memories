<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\Finder;


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
        $mime = $image->getMimeType();
        $albumSlug = Album::find($request->album_id)->slug;





        if (str_contains($mime, 'image')) {

            $imageName = time() . rand(1, 99) . '.webp';


            // Stockez l'image dans le dossier de stockage (storage/app)
            $destinationPath = $image->storeAs('images/' . $albumSlug, $imageName, 'local');


            // Obtenez le chemin complet de l'image dans le stockage
            $storagePath = storage_path('app/public/' . $destinationPath);
            chmod(storage_path('app/public/images/' . $albumSlug), 0755);




            // Ouvrez l'image avec Intervention Image
            $img = Image::make($image)->orientate();




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
            $img->encode('webp', 99);
            // Enregistrez l'image convertie
            $img->save($storagePath);

            // Créez un sous-dossier "thumb"
            $destinationThumbPath = $image->storeAs('images/' . $albumSlug . '/thumb/', $imageName, 'local');
            $storageThumbPath = storage_path('app/public/' . $destinationThumbPath);
            chmod(storage_path('app/public/images/' . $albumSlug . '/thumb'), 0755);

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
        } elseif (str_contains($mime, 'video')) {

            // ici on parle image mais c'est VIDEO 

            $imageName = time() . rand(1, 99) . '.' . $image->getClientOriginalExtension();


            // Stockez l'image dans le dossier de stockage (storage/app)
            $destinationPath = $image->storeAs('images/' . $albumSlug, $imageName, 'local');
            $storagePath = storage_path('app/public/' . $destinationPath);
            chmod(storage_path('app/public/images/' . $albumSlug), 0755);



            // $destinationThumbPath = $image->storeAs('images/' . $albumSlug . '/thumb/', $imageName, 'local');
            // $storageThumbPath = storage_path('app/public/' . $destinationThumbPath);
            // chmod(storage_path('app/public/images/' . $albumSlug . '/thumb'), 0755);




        } else {
            return response()->json(['error' => 'Type de fichier non pris en charge.']);
        }


        $newPhoto = new Photo();
        // PARTIE BDD
        if (str_contains($mime, 'image')) {
            $metadata = $img->exif();
            $newPhoto->metadata = json_encode($metadata);
        }


        $newPhoto->url = $imageName;
        $newPhoto->album_id = $request->album_id;
        $newPhoto->user_id = Auth::id();

        $newPhoto->save();


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
        $photoFile = storage_path('app/public/images/' . $album->slug . '/' . $request->input('photo_name'));
        $photoFileThumb = storage_path('app/public/images/' . $album->slug . '/thumb/' . $request->input('photo_name'));

        // remove la photo & sa miniature
        if (File::exists($photoFile)) {
            File::delete([$photoFile, $photoFileThumb]);
        }

        // Remove l'entrée en bdd
        Photo::destroy($photo->id);

        return json_encode("gg");
    }



    // Custom
    public function postThumbs(Request $request) {

        // Transforme en file img
        $decodedImage = base64_decode($request->img);
        
        // Crée l'image 
        $image = Image::make($decodedImage)->encode('webp', 90);

        // Crée le nom du fichier 
        $newname = str_replace(array(".mp4", ".mov", ".avi", ".mkv", ".wmv", ".flv", ".mpeg", ".3gp"), ".webp", $request->photo_name);

        Storage::put('images/'. $request->album_name . '/thumb/'.$newname, $image);
       // Créez un sous-dossier "thumb"
    //    $destinationThumbPath = $image->storeAs('images/' . $request->album_name . '/thumb/', $newname, 'local');
    //    $storageThumbPath = storage_path('app/public/' . $destinationThumbPath);
    //    chmod(storage_path('app/public/images/' . $request->album_name . '/thumb'), 0755);

       
        return json_encode("gg!");
    }


    public function generateThumbs()
    {
        $albums = Album::all();
        $mp4Files = [];

        foreach ($albums as $album) {
            $directory = public_path('storage/images/' . $album->slug); // Remplacez par le chemin de votre dossier
            $finder = new Finder();
            $finder->files()->in($directory)->name('/\.(mp4|mov|avi|mkv|wmv|flv|mpeg|3gp)$/i');

            $mp4FileUrls = collect($finder)->map(function ($file) {
                return $file->getFilename();
                // return asset('images/' . Str::after($file->getPathname(), 'public/images/'));

            });

            foreach ($mp4FileUrls as $file) {
                $mp4Files[$file] = $album->slug;
                // array_push($mp4Files, $album->slug . '/' . $file);
            }
        }

        // Vous pouvez les retourner sous forme de réponse JSON, par exemple :

        return view('generatethumb')->with([
            "videos" => $mp4Files
        ]);
    }
}
