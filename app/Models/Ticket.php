<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'screening_id',
        'seat_id',
        'purchase_id',
        'price',
        'qrcode_url',
        'status',
    ];

    public function getCodeFullUrlAttribute()
    {
        if ($this->qrcode_url) {
            return asset("storage/ticket_qrcodes/{$this->qrcode_url}");
        } else {
            // To be changed eventually
            return null;
        }
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function screening(): BelongsTo
    {
        return $this->belongsTo(Screening::class, 'screening_id','id');
    }

    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class,'seat_id');
    }

}
