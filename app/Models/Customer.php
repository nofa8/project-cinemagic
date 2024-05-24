<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Customer extends Model{
    use HasFactory;

    protected $fillable = [
        'nif',
        'payment_type',
        'payment_ref',
    ];




    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function purchases(): BelongsToMany
    {
        return $this->belongsToMany(
            Purchase::class,
            'customers_purchases',
            'customer_id',
            'purchase_id'
        );
    }
}