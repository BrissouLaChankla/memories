<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [HomeController::class, 'index'])->name('home');

    
    Route::resource('albums', AlbumController::class);
    Route::get('albums/download/{album}', [AlbumController::class, 'downloadAlbumZip'])->name('albums.download');
    
    Route::resource('photos', PhotoController::class);
    Route::post('photos/create/{album_id}', [PhotoController::class, 'create']);
    
    Route::post('uploads-dropzone', [PhotoController::class,'uploadsDropzone'])->name('uploads');

    Route::get('generate-thumbs', [PhotoController::class, 'generateThumbs']);
    Route::post('postThumbs', [PhotoController::class, 'postThumbs']);
    

});
