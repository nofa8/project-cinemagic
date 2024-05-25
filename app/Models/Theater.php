<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Theater extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo_filename',
    ];
    public $timestamps = false;

    public function screenings(): BelongsToMany
    {
        return $this->belongsToMany(Screening::class, 'screenings_theaters', 'screening_id','theater_id');
    }

    public function seats(): BelongsToMany
    {
        return $this->belongsToMany(Seat::class, 'seats_theaters','seat_id','theater_id');
    }

}
