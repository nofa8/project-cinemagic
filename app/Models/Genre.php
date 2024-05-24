<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];


    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class,'movies_genres','movie_id','genre_id');
    }

}
