<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'album_id',
        'metadata',
        'user_id',
    ];

    public function album() {
        return $this->belongsTo(Album::class);
    }
    
    public function author() {
        return $this->belongsTo(User::class, "user_id");
    }

    public function getAuthorNameAttribute(){
        return $this->author->name;
    }

    public function getAlbumSlugAttribute() {
        return $this->album->slug;
    }
}
