<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Movie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'genre_code',
        'year',
        'poster_filename',
        'synopsis',
        'trailer_url',
    ];

    public function getImageFullUrlAttribute()
    {
        if ($this->poster_filename && Storage::exists("public/posters/{$this->poster_filename}")) {
            return asset("storage/posters/{$this->poster_filename}");
        } else {
            // To be changed eventually
            return asset("storage/posters/_no_poster_2.png");
        }
    }
    public function getImageExistsAttribute()
    {
        return Storage::exists("public/posters/{$this->poster_filename}");
    }

    public function genreRef(): BelongsTo
    {
        return $this->BelongsTo(Genre::class, 'genre_code', 'code');
    }



    
    public function screenings()
    {
        return $this->hasMany(Screening::class);
    }
}


