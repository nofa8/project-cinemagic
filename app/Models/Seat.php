<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'theater_id',
        'row',
        'seat_number',
    ];
    public $timestamps = false;

    public function tickets(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class, 'tickets_seats', 'ticket_id','seat_id');
    }

    public function theater(): BelongsTo
    {
        return $this->belongsTo(Theater::class);
    }

}
