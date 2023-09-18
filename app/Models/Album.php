<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'location',
        'slug',
        'description',
        'user_id'
    ];


    public function photos() {
        return $this->hasMany(Photo::class);
    }

    public function author() {
        return $this->belongsTo(User::class, "user_id");
    }

    public function getAuthorNameAttribute(){
        return $this->author->name;
    }

    public function getCoverAttribute()
    {
        return $this->photos[0]->url ?? null;
    }
}
