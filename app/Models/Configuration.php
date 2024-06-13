<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{

    protected $fillable = [
        'ticket_price',
        'registered_customer_ticket_discount',
    ];
    protected $table = 'configuration';

    public $timestamps = false;
}
