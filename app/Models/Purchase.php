<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'date',
        'total_price',
        'customer_name',
        'customer_email',
        'nif',
        'payment_type',
        'payment_ref',
        'receipt_pdf_filename',
    ];


    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
