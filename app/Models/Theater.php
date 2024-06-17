<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
class Theater extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'photo_filename',
    ];
    public $timestamps = false;


    public function getImageFullUrlAttribute()
    {
        if ($this->photo_filename && Storage::exists("public/photos/{$this->photo_filename}")) {
            return asset("storage/photos/{$this->photo_filename}");

        } else {
            return asset("storage/posters/_no_poster_2.png");
        }
    }
    public function getImageExistsAttribute()
    {
        return Storage::exists("public/photos/{$this->photo_filename}");
    }


    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class);
    }

    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class, 'theater_id', 'id');
    }
}
