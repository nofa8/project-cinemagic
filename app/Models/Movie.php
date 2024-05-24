<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'genre_code',
        'year',
        'poster_filename',
        'synopsis',
        'trailer_url',
    ];


    public function genre(): BelongsTo
    {
        return $this->BelongsTo(Genre::class, 'genre_code', 'code');
    }

    public function screenings(): BelongsToMany
    {
        return $this->belongsToMany(Screening::class,'screenings_movies','screening_id','movie_id');
    }

}
