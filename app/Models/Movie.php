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

    public function getPhotoFullUrlAttribute()
    {
        if ($this->poster_filename && Storage::exists("public/posters/{$this->poster_filename}")) {
            return asset("storage/posters/{$this->poster_filename}");
        } else {
            // To be changed eventually
            return asset("storage/photos/_no_poster_1.png");
        }
    }

    public function genre(): BelongsTo
    {
        return $this->BelongsTo(Genre::class, 'genre_code', 'code');
    }

    public function screenings(): BelongsToMany
    {
        return $this->belongsToMany(Screening::class,'screenings_movies','screenings_id','movies_id');
    }

}
