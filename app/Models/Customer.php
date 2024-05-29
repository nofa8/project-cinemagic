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
    public $incrementing = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }


    public function purchases(): BelongsToMany
    {
        return $this->belongsToMany(
            Purchase::class,
            'customers_purchases',
            'customers_id',
            'purchases_id'
        );
    }
}
